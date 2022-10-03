<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Api\ApiKabupatenModel;

class ApiKabupaten extends BaseController
{
    private $ApiKabupatenModel;

    public function __construct()
    {
        $this->ApiKabupatenModel = new ApiKabupatenModel();
    }

    public function index()
    {
        $id_provinsi = $this->request->getGet('id_provinsi') ?? null;
        $id_kabupaten = $this->request->getGet('id_kabupaten') ?? null;

        $dataKabupaten = array();

        if ($id_provinsi || $id_kabupaten) {
            $builder = $this->ApiKabupatenModel;

            if ($id_provinsi) {
                $builder->whereIn('id_provinsi', explode(",", $id_provinsi));
            }

            if ($id_kabupaten) {
                $builder->whereIn('id_kabupaten', explode(",", $id_kabupaten));
            }

            $dataKabupaten = $builder->get()->getResultArray();
        } else {
            $dataKabupaten = $this->ApiKabupatenModel
                ->get()
                ->getResultArray();
        }

        if ($dataKabupaten) {
            return $this->respond([
                'message' => "Data Kabupaten Ditemukan.",
                'data' => $dataKabupaten
            ], 200);
        } else {
            return $this->failNotFound("Data Kabupaten Tidak Ditemukan.");
        }
    }
}
