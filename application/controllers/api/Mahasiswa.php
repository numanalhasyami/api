<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa Extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mhs');
        // $this->methods['index_get']['limit'] = 100;
    }

    public function detail_get()
    {
        $nim = $this->get('nim');
        
        if ($nim === null){
            $mahasiswa = $this->mhs->getMahasiswa();
        } else {
            $mahasiswa = $this->mhs->getMahasiswa($nim);
        }
        
        
        if($mahasiswa) {
            $this->response([
                'status' => '000',                
                'data' =>  $mahasiswa
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'nim Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        
    }

    public function jadwal_get()
    {
        $nim = $this->get('nim');

        $mahasiswa = $this->mhs->getJadwal($nim);             
        
        if($mahasiswa) {
            $this->response([
                'status' => '000',                
                'data' =>  $mahasiswa
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Jadwal Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        
    }

    public function index_delete()
    {
        $nim = $this->delete('nim');

        if($nim === null) {
            $this->response([
                'status' => false,
                'message' => 'Required nim'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {

            if($this->mhs->deleteMahasiswa($nim) > 0) {
                $this->response([
                    'status' => 000,
                    'nim' => $nim,
                    'message' => 'Deleted'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'nim Not Found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }

        }
    }

    public function index_post()
    {
        $data = [
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')
        ];

        if($this->mhs->createMahasiswa($data) > 0) {
            $this->response([
                'status' => 000,
                'data' => $data,
                'message' => 'Mahasiswa Berhasil di TAMBAHKAN'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed To Created New Data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $nim = $this->put('nim');
        
        $data = [
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];

        if($this->mhs->updateMahasiswa($data,$nim) > 0) {
            $this->response([
                'status' => true,
                'data' => $data,
                'message' => 'Mahasiswa Berhasil di UPDATED'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed To Update Data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

    }
}