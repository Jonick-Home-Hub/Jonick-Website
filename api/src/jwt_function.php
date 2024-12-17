<?php

class JWT
{
    private static $secret_key;
    private static $algo = 'HS256';

    // Set the secret key via an environment variable or constructor
    public function __construct()
    {
        // Set secret key from environment variable or use a default one
        self::$secret_key = getenv('JWT_SECRET_KEY') ?: bin2hex(random_bytes(32));
    }

    // Function to encode data into JWT
    public static function generateToken($data)
    {
        $header = self::base64UrlEncode(json_encode(['typ' => 'JWT', 'alg' => self::$algo]));
        $payload = self::base64UrlEncode(json_encode($data));
        
        $signature = self::sign("$header.$payload", self::$secret_key);
        $base64UrlSignature = self::base64UrlEncode($signature);
        
        return "$header.$payload.$base64UrlSignature";
    }

    // Function to validate JWT
    public static function validateToken($token)
    {
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            return false; // Invalid token format
        }

        list($header, $payload, $signature) = $parts;

        // Recreate the signature based on the header and payload
        $validSignature = self::sign("$header.$payload", self::$secret_key);

        // Compare the provided signature with the one we recreated
        if (!hash_equals(self::base64UrlEncode($validSignature), $signature)) {
            return false; // Invalid signature
        }

        return json_decode(base64_decode($payload), true); // Return decoded payload
    }

    // Helper method to sign the data
    private static function sign($data, $key)
    {
        return hash_hmac('sha256', $data, $key, true);
    }

    // Helper method to Base64 URL encode data
    private static function base64UrlEncode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }
}
