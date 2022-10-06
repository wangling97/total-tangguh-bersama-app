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

    public function index()
    {
        $id_pengguna = $this->request->getGet('id_pengguna');

        $builder = $this->ApiPenggunaModel;

        if ($id_pengguna) {
            $builder->whereIn('id_pengguna', explode(",", $id_pengguna));
        }

        $dataPengguna = $builder->get()->getResultArray();

        if (!$dataPengguna) {
            return $this->failNotFound("Data Pengguna Tidak Ditemukan.");
        }

        return $this->respond([
            'message' => "Data Pengguna Ditemukan.",
            'data' => $dataPengguna
        ], 200);
    }

    public function tambah()
    {
        $jsonData = [
            'nama_depan' => $this->request->getVar('nama_depan'),
            'nama_belakang' => $this->request->getVar('nama_belakang'),
            'nomor_telepon' => $this->request->getVar('nomor_telepon'),
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
            'jabatan' => $this->request->getVar('jabatan')
        ];

        $this->validation->setRule('nama_depan', 'Nama Depan', 'required');
        $this->validation->setRule('username', 'Username', 'required');
        $this->validation->setRule('password', 'Password', 'required');
        $this->validation->setRule('jabatan', 'Jabatan', 'in_list[admin,sales]');
        $this->validation->run($jsonData);

        if ($this->validation->getErrors()) {
            return $this->failValidationErrors($this->validation->getErrors());
        }

        if ($jsonData['email']) {
            if (!filter_var($jsonData['email'], FILTER_VALIDATE_EMAIL)) {
                return $this->failValidationErrors("Email Tidak Valid.");
            }
        }

        $usernameValidation = $this->ApiPenggunaModel
            ->where('username', $jsonData['username'])
            ->get()
            ->getNumRows();

        if ($usernameValidation >= 1) {
            return $this->failValidationErrors("Username Sudah Digunakan.");
        }

        $jsonData['password'] = password_hash($jsonData['password'], PASSWORD_DEFAULT);

        $this->db->transBegin();

        $this->ApiPenggunaModel->save($jsonData);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return $this->fail("Gagal tambah data pengguna.");
        }

        $this->db->transCommit();
        return $this->respondCreated($jsonData);
    }

    public function ubah()
    {
        $id_pengguna = $this->request->getVar('id_pengguna');

        $jsonData = [
            'nama_depan' => $this->request->getVar('nama_depan'),
            'nama_belakang' => $this->request->getVar('nama_belakang'),
            'nomor_telepon' => $this->request->getVar('nomor_telepon'),
            'email' => $this->request->getVar('email')
        ];

        $this->validation->setRule('nama_depan', 'Nama Depan', 'required');
        $this->validation->run($jsonData);

        if ($this->validation->getErrors()) {
            return $this->failValidationErrors($this->validation->getErrors());
        }

        if ($jsonData['email']) {
            if (!filter_var($jsonData['email'], FILTER_VALIDATE_EMAIL)) {
                return $this->failValidationErrors("Email Tidak Valid.");
            }
        }

        $this->db->transBegin();

        $this->ApiPenggunaModel->update($id_pengguna, array_filter($jsonData));

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return $this->fail("Gagal ubah data pengguna.");
        }

        $this->db->transCommit();
        return $this->respond([
            'message' => "Berhasil ubah data pengguna.",
            'data' => $jsonData
        ], 200);
    }

    public function hapus()
    {
        $id_pengguna = $this->request->getVar('id_pengguna');

        if (!$id_pengguna) {
            return $this->fail("Anda tidak bisa melakukan proses ini.", 422);
        }

        $dataPengguna = $this->ApiPenggunaModel
            ->where('id_pengguna', $id_pengguna)
            ->get()
            ->getNumRows();

        if ($dataPengguna < 1) {
            return $this->fail("Tidak menemukan data pengguna.", 422);
        }

        $this->db->transBegin();

        $this->ApiPenggunaModel->delete($id_pengguna);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return $this->fail("Gagal menghapus data pengguna.");
        }

        $this->db->transCommit();
        return $this->respondDeleted("Berhasil menghapus data pengguna.");
    }
}
