const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');
const axios = require('axios');
const config = require('./config');

// Initialize WhatsApp client
const client = new Client({
    authStrategy: new LocalAuth({
        dataPath: config.sessionPath
    }),
    puppeteer: {
        headless: true,
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-dev-shm-usage',
            '--disable-accelerated-2d-canvas',
            '--no-first-run',
            '--no-zygote',
            '--disable-gpu'
        ]
    }
});

// Track processed messages to avoid duplicates
const processedMessages = new Set();

// Logger helper
function log(level, message, data = {}) {
    const timestamp = new Date().toISOString();
    const logMessage = `[${timestamp}] [${level.toUpperCase()}] ${message}`;

    if (Object.keys(data).length > 0) {
        console.log(logMessage, JSON.stringify(data));
    } else {
        console.log(logMessage);
    }
}

// QR Code event - scan this with WhatsApp mobile
client.on('qr', (qr) => {
    console.log('\n========================================');
    console.log('  SCAN QR CODE DENGAN WHATSAPP ANDA');
    console.log('========================================\n');
    qrcode.generate(qr, { small: true });
    console.log('\n========================================\n');
});

// Ready event - bot is connected
client.on('ready', () => {
    log('info', 'WhatsApp Bot is ready!');
    log('info', `Connected as: ${client.info.pushname}`);
    log('info', `Phone number: ${client.info.wid.user}`);
    console.log('\n========================================');
    console.log('  BOT SIAP MENERIMA PESAN');
    console.log('========================================\n');
});

// Authentication success
client.on('authenticated', () => {
    log('info', 'WhatsApp authentication successful');
});

// Authentication failure
client.on('auth_failure', (msg) => {
    log('error', 'WhatsApp authentication failed', { message: msg });
});

// Disconnected event
client.on('disconnected', (reason) => {
    log('warn', 'WhatsApp disconnected', { reason });
    log('info', 'Attempting to reconnect...');

    // Auto reconnect after 5 seconds
    setTimeout(() => {
        client.initialize();
    }, 5000);
});

// Message event - handle incoming messages
client.on('message', async (message) => {
    try {
        // Skip if already processed
        if (processedMessages.has(message.id._serialized)) {
            return;
        }
        processedMessages.add(message.id._serialized);

        // Clean up old processed messages (keep last 1000)
        if (processedMessages.size > 1000) {
            const entries = Array.from(processedMessages);
            entries.slice(0, 500).forEach(id => processedMessages.delete(id));
        }

        // Skip group messages (only process private chats)
        if (message.from.includes('@g.us')) {
            log('debug', 'Skipping group message', { from: message.from });
            return;
        }

        // Skip status updates
        if (message.from === 'status@broadcast') {
            return;
        }

        // Skip messages from self
        if (message.fromMe) {
            return;
        }

        // Get contact info
        const contact = await message.getContact();
        const nama = contact.pushname || contact.name || 'Unknown';
        const nomor = message.from.replace('@c.us', '');

        log('info', 'New message received', {
            nama,
            nomor,
            pesan: message.body.substring(0, 100)
        });

        // Send to CRM API
        await sendToCRM(nama, nomor, message.body);

        // Auto reply if enabled
        if (config.autoReply) {
            await message.reply(config.autoReplyMessage);
            log('info', 'Auto reply sent', { to: nomor });
        }

    } catch (error) {
        log('error', 'Error processing message', { error: error.message });
    }
});

// Send lead data to CRM
async function sendToCRM(nama, nomor, pesan) {
    try {
        const response = await axios.post(`${config.apiUrl}/webhook/whatsapp`, {
            nama,
            nomor,
            pesan,
            secret: config.webhookSecret
        }, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            timeout: 10000
        });

        const result = response.data;

        if (result.success) {
            if (result.action === 'created') {
                log('info', 'Lead created in CRM', {
                    lead_id: result.lead_id,
                    nama,
                    nomor
                });
            } else if (result.action === 'skipped') {
                log('info', 'Lead already exists in CRM', { nomor });
            }
        }

        return result;

    } catch (error) {
        if (error.response) {
            log('error', 'CRM API error', {
                status: error.response.status,
                data: error.response.data
            });
        } else if (error.request) {
            log('error', 'CRM API unreachable', {
                url: `${config.apiUrl}/webhook/whatsapp`
            });
        } else {
            log('error', 'Error sending to CRM', { error: error.message });
        }

        return null;
    }
}

// Graceful shutdown
process.on('SIGINT', async () => {
    log('info', 'Shutting down gracefully...');
    await client.destroy();
    process.exit(0);
});

process.on('SIGTERM', async () => {
    log('info', 'Shutting down gracefully...');
    await client.destroy();
    process.exit(0);
});

// Start the bot
console.log('\n========================================');
console.log('  ZHAFIRA CRM - WHATSAPP BOT');
console.log('========================================\n');
log('info', 'Starting WhatsApp bot...');
log('info', 'CRM API URL: ' + config.apiUrl);

client.initialize();
