<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Api\ApiKelurahanModel;

class ApiKelurahan extends BaseController
{
    private $ApiKelurahanModel;

    public function __construct()
    {
        $this->ApiKelurahanModel = new ApiKelurahanModel();
    }

    public function index()
    {
        $id_kelurahan = $this->request->getGet('id_kelurahan');
        $id_kecamatan = $this->request->getGet('id_kecamatan');

        $builder = $this->ApiKelurahanModel;

        if ($id_kelurahan) {
            $builder->whereIn('id_kelurahan', explode(",", $id_kelurahan));
        }

        if ($id_kecamatan) {
            $builder->whereIn('id_kecamatan', explode(",", $id_kecamatan));
        }

        $dataKelurahan = $builder->get()->getResultArray();

        if (!$dataKelurahan) {
            return $this->failNotFound("Data Kelurahan Tidak Ditemukan.");
        } 
        
        return $this->respond([
            'message' => "Data Kelurahan Ditemukan.",
            'data' => $dataKelurahan
        ], 200);
    }
}
