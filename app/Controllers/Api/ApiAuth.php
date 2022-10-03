<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Api\ApiPenggunaModel;
use \Firebase\JWT\JWT;

class ApiAuth extends BaseController
{
    private $ApiPenggunaModel;
    
    public function __construct()
    {
        $this->ApiPenggunaModel = new ApiPenggunaModel();
    }
    
    public function login()
    {
        $username = $this->content['username'] ?? null;
        $password = $this->content['password'] ?? null;

        // Required Validation
        if (!$username) {
            return $this->failValidationErrors("Username Tidak Boleh Kosong.");
        }

        if (!$password) {
            return $this->failValidationErrors("Password Tidak Boleh Kosong.");
        }

        $dataPengguna = $this->ApiPenggunaModel
            ->where('username', $username)
            ->first();

        if (!$dataPengguna) {
            return $this->failUnauthorized('Username atau Password Salah.');
        }

        if (!password_verify($password, $dataPengguna['password'])) {
            return $this->failUnauthorized('Username atau Password Salah.');
        }

        $key = $_ENV('JWT_SECRET');
        $iat = time(); // current timestamp value
        $exp = $iat + 3600;

        unset($dataPengguna['password']);

        $payload = array(
            "iss" => "Issuer of the JWT",
            "aud" => "Audience that the JWT",
            "sub" => "Subject of the JWT",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "pengguna" => $dataPengguna,
        );

        $token = JWT::encode($payload, $key, 'HS256');
 
        $response = [
            'message' => 'Login Succesful',
            'token' => $token
        ];
         
        return $this->respond($response, 200);
    }
}
