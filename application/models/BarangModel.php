<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BarangModel extends CI_Model
{

    public function getBarang($isAccept = 1)
    {
        $this->db->where('isAccept', $isAccept);
        return $this->db->get('barang')->result();
    }

    public function accept($getId)
    {
        $where = ['kdBarang' => $getId];
        $this->db->update('barang', ['isAccept' => 1], $where);
    }
}
