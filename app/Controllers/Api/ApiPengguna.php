<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Api\ApiPenggunaModel;

class ApiPengguna extends BaseController
{
    private $ApiPenggunaModel;

    public function __construct()
    {
        $this->ApiPenggunaModel = new ApiPenggunaModel();
    }

    public function tambah()
    {
        $namaDepan = $this->content['nama_depan'] ?? null;
        $namaBelakang = $this->content['nama_belakang'] ?? null;
        $nomorTelepon = $this->content['nomor_telepon'] ?? null;
        $username = $this->content['username'] ?? null;
        $email = $this->content['email'] ?? null;
        $password = $this->content['password'] ?? null;
        $jabatan = $this->content['jabatan'] ?? null;

        // Required Validation
        if (!$namaDepan) {
            return $this->failValidationErrors("Nama Depan Tidak Boleh Kosong.");
        }

        if (!$username) {
            return $this->failValidationErrors("Username Tidak Boleh Kosong.");
        }

        if (!$password) {
            return $this->failValidationErrors("Password Tidak Boleh Kosong.");
        }

        // Validation Input
        $usernameValidation = $this->ApiPenggunaModel
            ->where('username', $username)
            ->get()
            ->getNumRows();

        if ($usernameValidation >= 1) {
            return $this->failValidationErrors("Username Sudah Digunakan.");
        }

        if ($email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->failValidationErrors("Email Tidak Valid.");
            }
        }

        $data = [
            'nama_depan' => $namaDepan,
            'nama_belakang' => $namaBelakang,
            'nomor_telepon' => $nomorTelepon,
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'jabatan' => $jabatan
        ];

        $this->ApiPenggunaModel->save($data);

        return $this->respondCreated($data);
    }
}
