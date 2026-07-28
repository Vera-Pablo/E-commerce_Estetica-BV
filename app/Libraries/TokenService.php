<?php

namespace App\Libraries;

class TokenService
{
    private static function getSecret(): string
    {
        $key = config('App')->encryptionKey ?? '';
        return !empty($key) ? $key : 'EsteticaBV_Default_Secure_Secret_Key_2026';
    }

    public static function createToken(array $payload, int $ttlSeconds = 86400): string
    {
        $payload['exp'] = time() + $ttlSeconds;
        $json = json_encode($payload);
        $encodedPayload = self::base64UrlEncode($json);
        $signature = hash_hmac('sha256', $encodedPayload, self::getSecret());

        return $encodedPayload . '.' . $signature;
    }

    public static function verifyToken(string $token): ?array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 2) {
            return null;
        }

        [$encodedPayload, $providedSignature] = $parts;
        $expectedSignature = hash_hmac('sha256', $encodedPayload, self::getSecret());

        if (!hash_equals($expectedSignature, $providedSignature)) {
            return null;
        }

        $json = self::base64UrlDecode($encodedPayload);
        $payload = json_decode($json, true);

        if (!is_array($payload) || !isset($payload['exp'])) {
            return null;
        }

        if (time() > $payload['exp']) {
            return null;
        }

        return $payload;
    }

    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', (4 - strlen($data) % 4) % 4));
    }
}
