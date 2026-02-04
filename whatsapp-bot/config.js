require('dotenv').config();

module.exports = {
    // CRM API Configuration
    apiUrl: process.env.CRM_API_URL || 'https://crm.zhafiravila.com/api',
    webhookSecret: process.env.WEBHOOK_SECRET || 'zhafira-crm-2026',

    // WhatsApp Configuration
    sessionPath: process.env.SESSION_PATH || './.wwebjs_auth',

    // Bot Settings
    autoReply: process.env.AUTO_REPLY === 'true',
    autoReplyMessage: process.env.AUTO_REPLY_MESSAGE || 'Terima kasih telah menghubungi Zhafira Villa. Pesan Anda telah kami terima dan tim kami akan segera menghubungi Anda.',

    // Logging
    logLevel: process.env.LOG_LEVEL || 'info',
};
