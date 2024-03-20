<?php
namespace App\Controllers;
use App\Models\DosenModel;

class Dosen extends BaseController 
{

public function index()
{

 $DataDosen = new DosenModel();
 $pager = \config\Services::pager();

 $data = array(
    'DataDosen' => $DataDosen->paginate(100,'dosen'),
    'pager' => $DataDosen->pager
    );
    return view('dosen', $data);

 

}

public function tambah()
    {
        // Validasi form tambah data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'kode_dosen' => 'required',
            'nama_dosen' => 'required',
            'status_dosen' => 'required'
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('error', $validation->getErrors());
            return redirect()->back();
        }

        // Ambil data dari form
        $kodeDosen = $this->request->getPost('kode_dosen');
        $namaDosen = $this->request->getPost('nama_dosen');
        $statusDosen = $this->request->getPost('status_dosen');

        // Simpan data ke database, sesuaikan dengan model dan database Anda
        $dosenModel = new \App\Models\DosenModel();
        $dosenModel->save([
            'kode_dosen' => $kodeDosen,
            'nama_dosen' => $namaDosen,
            'status_dosen' => $statusDosen
        ]);

        // Set flashdata untuk pesan sukses
        session()->setFlashdata('message', 'Data dosen berhasil ditambahkan.');

        // Redirect ke halaman index atau halaman lainnya
        return redirect()->to('/dosen');
    }

}