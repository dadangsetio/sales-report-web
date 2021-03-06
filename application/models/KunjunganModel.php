<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KunjunganModel extends CI_Model
{

    public function getKunjungan($where)
    {
        return $this->db->get_where('kunjungan ', $where)->result();
    }

    public function getKunjunganAll()
    {
        return $this->db->get('kunjungan')->result();
    }

    public function accept($getId)
    {
        $where = ['idkunjungan' => $getId];
        $this->db->update('kunjungan', ['isDone' => 1], $where);
    }
}
