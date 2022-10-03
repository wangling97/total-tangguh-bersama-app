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
        $id_provinsi = $this->request->getGet('id_provinsi') ?? null;

        $dataProvinsi = array();

        if ($id_provinsi) {
            $dataProvinsi = $this->ApiProvinsiModel
                ->whereIn('id_provinsi', explode(",", $id_provinsi))
                ->get()
                ->getResultArray();
        } else {
            $dataProvinsi = $this->ApiProvinsiModel
                ->get()
                ->getResultArray();
        }

        if ($dataProvinsi) {
            return $this->respond([
                'message' => "Data Provinsi Ditemukan.",
                'data' => $dataProvinsi
            ], 200);
        } else {
            return $this->failNotFound("Data Provinsi Tidak Ditemukan.");
        }
    }
}
