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
        $jsonData = [
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
        ];

        $this->validation->setRule('username', 'Username', 'required');
        $this->validation->setRule('password', 'Password', 'required');
        $this->validation->run($jsonData);

        if($this->validation->getErrors()) {
            return $this->failValidationErrors($this->validation->getErrors());
        }   

        $dataPengguna = $this->ApiPenggunaModel
            ->where('username', $jsonData['username'])
            ->first();

        if (!$dataPengguna) {
            return $this->failUnauthorized('Username atau Password Salah.');
        }

        if (!password_verify($jsonData['password'], $dataPengguna['password'])) {
            return $this->failUnauthorized('Username atau Password Salah.');
        }

        $key = env('JWT_SECRET');
        $iat = time(); // current timestamp value
        $exp = $iat + 3600;

        unset($dataPengguna['password']);

        $payload = array(
            "iat" => $iat, // Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "pengguna" => $dataPengguna,
        );

        try {
            $token = JWT::encode($payload, $key, 'HS256');

            $response = [
                'message' => 'Login Berhasil.',
                'token' => $token
            ];
             
            return $this->respond($response, 200);
        } catch (\Exception $ex) {
            $this->fail($ex->getMessage());
        }
    }
}
