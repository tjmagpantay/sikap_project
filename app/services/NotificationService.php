<?php
// app/services/NotificationService.php

// FOR FIREBASE NOTIFICATION

class NotificationService
{
    protected static function getServiceAccount()
    {
        $cfg = require __DIR__ . '/../../config/firebase.php';
        $path = $cfg['service_account_json'];
        if (!file_exists($path)) throw new Exception("Service account JSON not found: $path");
        return json_decode(file_get_contents($path), true);
    }

    // base64url encode
    protected static function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    // Get cached access token or request a new one
    protected static function getAccessToken() {
        $cfg = require __DIR__ . '/../../config/firebase.php';
        $sa = self::getServiceAccount();
        $cacheFile = __DIR__ . '/../../config/fcm_token_cache.json';

        // use cached token if still valid
        if (file_exists($cacheFile)) {
            $cached = json_decode(file_get_contents($cacheFile), true);
            if (!empty($cached['access_token']) && !empty($cached['expiry']) && $cached['expiry'] > time() + 30) {
                return $cached['access_token'];
            }
        }

        $now = time();
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $claim = [
            'iss' => $sa['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ];

        $jwt = self::base64UrlEncode(json_encode($header)) . '.' . self::base64UrlEncode(json_encode($claim));

        $privateKey = $sa['private_key'];
        $pkey = openssl_pkey_get_private($privateKey);
        if (!$pkey) throw new Exception("Invalid service account private key");

        $signature = null;
        openssl_sign($jwt, $signature, $pkey, OPENSSL_ALGO_SHA256);
        openssl_free_key($pkey);
        $jwt_signed = $jwt . '.' . self::base64UrlEncode($signature);

        // Request access token
        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt_signed
        ]));
        $res = curl_exec($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $json = json_decode($res, true);
        if ($http !== 200 || empty($json['access_token'])) {
            throw new Exception("Failed to obtain access token: $res");
        }
        $accessToken = $json['access_token'];
        $expiry = $now + intval($json['expires_in'] ?? 3600);

        file_put_contents($cacheFile, json_encode(['access_token' => $accessToken, 'expiry' => $expiry]));
        return $accessToken;
    }

    // Send a single message to a device token using FCM v1
    public static function sendToToken(string $token, string $title, string $body, array $data = []) {
        $sa = self::getServiceAccount();
        $projectId = $sa['project_id'];
        $accessToken = self::getAccessToken();

        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
        $payload = [
            'message' => [
                'token' => $token,
                'notification' => ['title' => $title, 'body' => $body],
                'data' => $data,
                'android' => ['priority' => 'high'],
                'apns' => ['headers' => ['apns-priority' => '10']],
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$accessToken}",
            "Content-Type: application/json; charset=utf-8"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $res = curl_exec($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ['http' => $http, 'result' => json_decode($res, true), 'raw' => $res];
    }

    // Bulk send to multiple tokens (loop; re-uses cached access token)
    public static function sendToTokens(array $tokens, string $title, string $body, array $data = []) {
        $results = [];
        foreach ($tokens as $t) {
            $results[] = self::sendToToken($t, $title, $body, $data);
        }
        return $results;
    }

    // Example: notify users by skills (call from job creation)
    public static function notifyUsersBySkills(int $job_id, string $job_title, string $job_url = '/') {
        global $conn;
        // get tokens for users matching job skills (example query)
        $stmt = $conn->prepare("
            SELECT DISTINCT u.id, u.fcm_token
            FROM users u
            JOIN user_skills us ON us.user_id = u.id
            JOIN job_skills js ON js.skill_id = us.skill_id
            WHERE js.job_id = ? AND u.fcm_token IS NOT NULL
        ");
        $stmt->bind_param("i", $job_id);
        $stmt->execute();
        $res = $stmt->get_result();

        $tokens = []; $userIds = [];
        while ($r = $res->fetch_assoc()) {
            $tokens[] = $r['fcm_token'];
            $userIds[] = $r['id'];
        }
        $stmt->close();

        if (!empty($tokens)) {
            // send (loop). For large scale, consider topic messaging or batching external service.
            self::sendToTokens($tokens, "New job: {$job_title}", "Click to view job.", ['url' => $job_url, 'job_id' => (string)$job_id]);

            // save rows to notifications table
            $stmt2 = $conn->prepare("INSERT INTO notifications (user_id, type, message, data) VALUES (?, 'job_post', ?, ?)");
            foreach ($userIds as $uid) {
                $msg = "New job posted: {$job_title}";
                $jsonData = json_encode(['job_id' => $job_id, 'url' => $job_url]);
                $stmt2->bind_param("iss", $uid, $msg, $jsonData);
                $stmt2->execute();
            }
            $stmt2->close();
        }
    }
}
