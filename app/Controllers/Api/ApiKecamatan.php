<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Api\ApiKecamatanModel;

class ApiKecamatan extends BaseController
{
    private $ApiKecamatanModel;

    public function __construct()
    {
        $this->ApiKecamatanModel = new ApiKecamatanModel();
    }

    public function index()
    {
        $id_kabupaten = $this->request->getGet('id_kabupaten');
        $id_kecamatan = $this->request->getGet('id_kecamatan');

        $dataKecamatan = array();

        if ($id_kabupaten || $id_kecamatan) {
            $builder = $this->ApiKecamatanModel;

            if ($id_kabupaten) {
                $builder->whereIn('id_kabupaten', explode(",", $id_kabupaten));
            }

            if ($id_kecamatan) {
                $builder->whereIn('id_kecamatan', explode(",", $id_kecamatan));
            }

            $dataKecamatan = $builder->get()->getResultArray();
        } else {
            $dataKecamatan = $this->ApiKecamatanModel
                ->get()
                ->getResultArray();
        }

        if ($dataKecamatan) {
            return $this->respond([
                'message' => "Data Kecamatan Ditemukan.",
                'data' => $dataKecamatan
            ], 200);
        } else {
            return $this->failNotFound("Data Kecamatan Tidak Ditemukan.");
        }
    }
}
