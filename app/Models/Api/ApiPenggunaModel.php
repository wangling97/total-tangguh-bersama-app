<?php

namespace App\Models\Api;

use CodeIgniter\Model;

class ApiPenggunaModel extends Model
{
    protected $table = 'mst_pengguna';
    protected $allowedFields = [
        'nama_depan',
        'nama_belakang',
        'nomor_telepon',
        'username',
        'email',
        'password',
        'jabatan'
    ];
}
