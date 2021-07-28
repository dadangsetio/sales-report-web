<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BarangModel extends CI_Model
{

    public function getBarang($isAccept = 1)
    {
        $this->db->where('isAccept', $isAccept);
        $this->db->join('user u', 'b.idUser=u.idUser');
        $this->db->select("b.kdBarang, b.namaBarang, b.harga, u.nama");
        return $this->db->get('barang b')->result();
    }

    public function accept($getId)
    {
        $where = ['kdBarang' => $getId];
        $this->db->update('barang', ['isAccept' => 1], $where);
    }
}
