<?php

class Mahasiswa_model Extends CI_Model
{
    public function getMahasiswa($nim = null)
    {
        if ($nim === null) {
            return $this->db->get('mahasiswa')->result_array();
        } else {
            return $this->db->get_where('mahasiswa', ['nim' => $nim])->result_array();
        }
    }

    public function getAllJadwal($nim) {
        return $this->db->query("SELECT DISTINCT krs.nim, mata_kuliah.nama_matkul, dosen.nama AS nama_dosen, mata_kuliah.sks, jadwal_mata_kuliah.hari, jadwal_mata_kuliah.jam_mulai, jadwal_mata_kuliah.jam_selesai, jadwal_mata_kuliah.tahun, mata_kuliah.semester from krs INNER JOIN mahasiswa ON mahasiswa.nim = krs.nim INNER JOIN jadwal_mata_kuliah ON jadwal_mata_kuliah.id_jadwal_mata_kuliah = krs.id_jadwal_mata_kuliah INNER JOIN mata_kuliah ON mata_kuliah.id_matkul = jadwal_mata_kuliah.id_matkul INNER JOIN dosen on dosen.id_dosen =jadwal_mata_kuliah.id_dosen WHERE krs.nim= $nim and jadwal_mata_kuliah.tahun= 2022 and mata_kuliah.semester=1 ORDER BY jadwal_mata_kuliah.tahun ASC")->result_array();
    }

    public function getJadwal($nim) {
        return $this->db->query("SELECT DISTINCT krs.nim, mata_kuliah.nama_matkul, dosen.nama AS nama_dosen, mata_kuliah.sks, jadwal_mata_kuliah.hari, jadwal_mata_kuliah.jam_mulai, jadwal_mata_kuliah.jam_selesai, jadwal_mata_kuliah.tahun, mata_kuliah.semester from krs INNER JOIN mahasiswa ON mahasiswa.nim = krs.nim INNER JOIN jadwal_mata_kuliah ON jadwal_mata_kuliah.id_jadwal_mata_kuliah = krs.id_jadwal_mata_kuliah INNER JOIN mata_kuliah ON mata_kuliah.id_matkul = jadwal_mata_kuliah.id_matkul INNER JOIN dosen on dosen.id_dosen =jadwal_mata_kuliah.id_dosen 
        WHERE krs.nim = $nim and jadwal_mata_kuliah.tahun= 2022 and mata_kuliah.semester='1' 
        and jadwal_mata_kuliah.hari = 'Senin' and jadwal_mata_kuliah.jam_selesai > 1
        ORDER BY jadwal_mata_kuliah.tahun limit 1")->result_array();
    }

    public function deleteMahasiswa($nim)
    {
        $this->db->delete('mahasiswa', ['nim' => $nim]);
        return $this->db->affected_rows();
    }

    public function createMahasiswa($data)
    {
        $this->db->insert('mahasiswa',$data);
        return $this->db->affected_rows();
    }
    
    public function updateMahasiswa($data,$nim)
    {
        $this->db->update('mahasiswa', $data, ['nim' => $nim]);
        return $this->db->affected_rows();
    }
}