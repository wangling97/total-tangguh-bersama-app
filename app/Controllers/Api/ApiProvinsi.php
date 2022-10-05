<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Api\ApiProvinsiModel;

class ApiProvinsi extends BaseController
{
    private $ApiProvinsiModel;

    public function __construct()
    {
        $this->ApiProvinsiModel = new ApiProvinsiModel();
    }

    public function index()
    {
        $id_provinsi = $this->request->getGet('id_provinsi');

        $builder = $this->ApiProvinsiModel;

        if ($id_provinsi) {
            $builder->whereIn('id_provinsi', explode(",", $id_provinsi));
        }
        
        $dataProvinsi = $builder->get()->getResultArray();
        
        if (!$dataProvinsi) {
            return $this->failNotFound("Data Provinsi Tidak Ditemukan.");
        } 

        return $this->respond([
            'message' => "Data Provinsi Ditemukan.",
            'data' => $dataProvinsi
        ], 200);
    }
}
