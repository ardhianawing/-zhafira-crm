<?php

namespace App\Services;

use App\Models\PushSubscription;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PushNotificationService
{
    /**
     * Send push notification to a specific user
     */
    public function sendToUser(User $user, string $title, string $body, array $data = []): void
    {
        $subscriptions = PushSubscription::where('user_id', $user->id)->get();

        foreach ($subscriptions as $subscription) {
            $this->sendNotification($subscription, $title, $body, $data);
        }
    }

    /**
     * Send push notification to a subscription
     */
    protected function sendNotification(PushSubscription $subscription, string $title, string $body, array $data = []): void
    {
        try {
            $payload = json_encode([
                'title' => $title,
                'body' => $body,
                'icon' => '/icons/icon-192x192.png',
                'badge' => '/icons/icon-192x192.png',
                'data' => $data,
            ]);

            $vapidPublicKey = config('webpush.public_key');
            $vapidPrivateKey = config('webpush.private_key');

            if (!$vapidPublicKey || !$vapidPrivateKey) {
                Log::warning('VAPID keys not configured');
                return;
            }

            // Create JWT for VAPID
            $header = $this->base64UrlEncode(json_encode([
                'typ' => 'JWT',
                'alg' => 'ES256'
            ]));

            $jwtPayload = $this->base64UrlEncode(json_encode([
                'aud' => parse_url($subscription->endpoint, PHP_URL_SCHEME) . '://' . parse_url($subscription->endpoint, PHP_URL_HOST),
                'exp' => time() + 86400,
                'sub' => 'mailto:admin@zhafiravila.com'
            ]));

            // For simplicity, we'll use a library approach
            // Install: composer require minishlink/web-push
            $auth = [
                'VAPID' => [
                    'subject' => 'mailto:admin@zhafiravila.com',
                    'publicKey' => $vapidPublicKey,
                    'privateKey' => $vapidPrivateKey,
                ],
            ];

            $webPush = new \Minishlink\WebPush\WebPush($auth);

            $webPush->sendOneNotification(
                \Minishlink\WebPush\Subscription::create([
                    'endpoint' => $subscription->endpoint,
                    'publicKey' => $subscription->p256dh,
                    'authToken' => $subscription->auth,
                ]),
                $payload
            );

        } catch (\Exception $e) {
            Log::error('Push notification failed: ' . $e->getMessage());

            // Remove invalid subscription
            if (str_contains($e->getMessage(), '410') || str_contains($e->getMessage(), 'expired')) {
                $subscription->delete();
            }
        }
    }

    protected function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
