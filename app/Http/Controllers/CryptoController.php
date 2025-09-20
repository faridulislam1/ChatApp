<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CryptoController extends Controller
{
    public function decryptData()
    {
        // Example ciphertext (encrypted user data)
        $ciphertext = 'yz4rWHHSNYywMVRFX24JqjU5VUkzMitNeHR2ZjRtMlBJc0VuemoyN2tiWHhFbW1vci9GZkNvNGQ4QjhpckZlb0l6ZHlKVjNKUlk4L0dJYWM1T1VMMUswVm5vQ1hZNEwwbStWYTVKMHFHNy9FWFdta2wvOEE1azU4TWY1R0U5TUt0eDczR0xWTXVLemRzTTZsSmswOFN1ZUxUckh5VW1aVVl6c2pDWVovV3o3TmVqVXVUR2hhWXBiTTJHQkEybi9LS084VE03aUpwRnZsdGhaWQ==';

        // Shared key & token
        $key    = "53qEpDIaiSYtfOJfVzAOBOPHCgFl2fEv"; // 32 bytes
        $cipher = "AES-256-CBC"; // ✅ must match key length
        $token  = "Z8WIQaS0WARPdKOz";

        // Check if cipher is supported
        if (in_array(strtolower($cipher), array_map('strtolower', openssl_get_cipher_methods()))) {

            // Decode base64
            $decoded_ciphertext = base64_decode($ciphertext);
            $ivlen = openssl_cipher_iv_length($cipher);
            $iv = substr($decoded_ciphertext, 0, $ivlen);
            $ciphertext_raw = substr($decoded_ciphertext, $ivlen);

            // Decrypt
            $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv);

            if ($original_plaintext !== false) {

                $payloads = json_decode($original_plaintext);

                // Validate security token
                if ($payloads && isset($payloads->securityToken) && $payloads->securityToken === md5($token)) {

                    // Access user data
                    $userId = $payloads->user->id ?? null;
                    $userName = $payloads->user->name ?? null;
                    $userEmail = $payloads->user->email ?? null;

                    return response()->json([
                        'status' => 'success',
                        'user_id' => $userId,
                        'name' => $userName,
                        'email' => $userEmail,
                        'raw_payload' => $payloads
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid token or payload.'
                    ], 400);
                }

            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Decryption failed.'
                ], 400);
            }

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Cipher not supported.'
            ], 400);
        }
    }
}
