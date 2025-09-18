<?php
namespace Core;

class Auth {
    public static function verifyToken($token){
        $base62 = new \Tuupola\Base62;
        $secret = Dotenv::getValue("AUTH_SECRET");
        
        $parts = explode(".", $token);
        if(count($parts) != 2){
            return null;
        }

        $dataJson = $base62->decode($parts[0]);
        try{
            $data = json_decode($dataJson, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return null;
        }

        if((new \DateTime())->getTimestamp() > $data["exp"]){
            return null;
        }
        
        $clientSignature = bin2hex($base62->decode($parts[1]));
        $expectedSignature = hash_hmac("sha3-256", $dataJson, $secret);
        return hash_equals($clientSignature, $expectedSignature) ? $data : null;
    }

    /**
     * Giriş tokeni oluşturmaktadır.
     * 
     * @param string $uid uid işte
     * @param int $exp Tokenin ölüm zamanı (integer timestamp)
     * 
     * @return string token
     */
    public static function generateToken($uid, $exp){
        $base62 = new \Tuupola\Base62;
        $secret = Dotenv::getValue("AUTH_SECRET");
        
        $data = [
            "uid" => $uid,
            "exp" => $exp
        ];
        $dataJson = json_encode($data);
        
        return $base62->encode($dataJson) . "." . $base62->encode(hash_hmac("sha3-256", $dataJson, $secret, true));
    }
}