<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;




class TestingController extends ResourceController
{
    use ResponseTrait;

    public function dataSiswa()
    {
        $db = \Config\Database::connect();
        $db = db_connect();
        $result = $db->query(
            "SELECT siswa.nama,
            CASE WHEN siswa.status_aktif = 0 THEN 'Siswa Tidak Aktif' ELSE 'Siswa Aktif' END as status_siswa
        FROM siswa
        ORDER BY siswa.id LIMIT 5"
        );

        $row = $result->getResult();

        if ($result) {
            $response = [
                "status" => 200,
                "data" => $row,
                "message" => "Successfully Get Data"
            ];
            return $this->respond($response);
        } else {
            $response = [
                "status" => 400,
                'errors' => true,
                "message" => "Failed Get Data"
            ];
            return $this->respond($response, 400);
        }
    }


    public function dataAbsensi()
    {
        $db = \Config\Database::connect();
        $db = db_connect();
        $result = $db->query(
            "SELECT
            siswa.nama,
            absensi.jumlah_kehadiran,
            absensi.izin
            
        FROM siswa
        
        LEFT JOIN absensi
        
            ON siswa.id = absensi.siswa_id
        ORDER BY siswa.nama LIMIT 5"
        );

        $row = $result->getResult();

        if ($result) {
            $response = [
                "status" => 200,
                "data" => $row,
                "message" => "Successfully Get Data"
            ];
            return $this->respond($response);
        } else {
            $response = [
                "status" => 400,
                'errors' => true,
                "message" => "Failed Get Data"
            ];
            return $this->respond($response, 400);
        }
    }

    public function dataIzin()
    {
        $db = \Config\Database::connect();
        $db = db_connect();
        $result = $db->query(
            "SELECT 
            siswa.nama,
            absensi.siswa_id,
            absensi.jumlah_kehadiran,
            absensi.izin,
            report_izin.keterangan
        
        FROM siswa
        INNER JOIN absensi
        ON siswa.id = absensi.siswa_id
        INNER JOIN report_izin
        ON absensi.id = report_izin.absensi_id
        
        ORDER BY siswa.id LIMIT 5"
        );

        $row = $result->getResult();

        if ($result) {
            $response = [
                "status" => 200,
                "data" => $row,
                "message" => "Successfully Get Data"
            ];
            return $this->respond($response);
        } else {
            $response = [
                "status" => 400,
                'errors' => true,
                "message" => "Failed Get Data"
            ];
            return $this->respond($response, 400);
        }
    }

    public function dataPayment()
    {
        $db = \Config\Database::connect();
        $db = db_connect();
        $result = $db->query(
            "SELECT 
            siswa.nama,
            spp.nominal,
            spp.verifikasi_by,
            CASE 
                WHEN spp.verifikasi_by = 1 THEN 'BCA' 
                WHEN spp.verifikasi_by = 2 THEN 'Mandiri'
                ELSE 'BRI'
            END as pembayaran_via
            
        
        FROM siswa
        LEFT JOIN spp
            ON siswa.id = spp.siswa_id
            
        ORDER BY siswa.nama LIMIT 5"
        );

        $row = $result->getResult();

        if ($result) {
            $response = [
                "status" => 200,
                "data" => $row,
                "message" => "Successfully Get Data"
            ];
            return $this->respond($response);
        } else {
            $response = [
                "status" => 400,
                'errors' => true,
                "message" => "Failed Get Data"
            ];
            return $this->respond($response, 400);
        }
    }
}
