<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TransaksiModel extends CI_Model
{

    public function getKeranjang($id)
    {
        $this->db->select('k.noItem, b.kdBarang, b.namaBarang, b.harga, k.qty');
        $this->db->join('barang b', 'k.kdBarang=b.kdBarang');
        return $this->db->get_where('keranjang k', ['k.idUser' => $id])->result();
    }

    public function getBarang()
    {
        $this->db->join('kategori k', 'k.idKategori=b.idKategori');
        return $this->db->get('barang b')->result();
    }

    public function cekItem($where)
    {
        return $this->db->get_where('keranjang', $where)->num_rows();
    }

    public function updateQtyKeranjang($qty = 0, $where)
    {
        $getQty = $this->db->get_where('keranjang', $where)->row()->qty;
        $result = (int) $getQty + (int) $qty;

        return $this->db->update('keranjang', ['qty' => $result], $where);
    }

    public function getTotalKeranjang($id)
    {
        $this->db->join('barang b', 'b.kdBarang=k.kdBarang');
        $keranjang = $this->db->get_where('keranjang k', ['k.idUser' => $id])->result();

        $subtotal = [];
        foreach ($keranjang as $k) {
            $subtotal[] = $k->qty * $k->harga;
        }

        return array_sum($subtotal);
    }

    public function getTransaksi($id = null, $idUser)
    {
        
        if ($id == null) {
            if($idUser != null){
                $this->db->where(['idUser' => $idUser]);
            }
            return $this->db->get('transaksi')->result();
        } else {
            $this->db->join('user u', 'u.idUser=t.idUser');
            return $this->db->get_where('transaksi t', ['idTransaksi' => $id])->row();
        } 
    }

    // public function getTotalHarga($id)
    // {
    //     $this->db->select("sum(harga*qty) as total");
    //     $this->db->join('barang b', 'b.kdBarang=td.kdBarang');
    //     $this->db->where('idTransaksi', $id);
    //     return $this->db->get('transaksi_detail td')->row()->total;
    // }

    public function getDetailTransaksi($id)
    {
        // $this->db->select("namaBarang, harga, qty, (harga*qty) as subtotal");
        // $this->db->join('barang b', 'b.kdBarang=td.kdBarang');
        // $this->db->where('idTransaksi', $id);
        // return $this->db->get('transaksi_detail td')->result();

        $this->db->select("b.namaBarang, td.qty, td.subtotal, (td.subtotal/td.qty) as harga");
        $this->db->join('barang b', 'b.kdBarang=td.kdBarang');
        $this->db->where('idTransaksi', $id);
        return $this->db->get('transaksi_detail td')->result();
    }

    public function getLaporanTransaksi($tgl1, $tgl2, $idUser = null)
    {
        
        $this->db->join('user u', 'u.idUser=t.idUser');
        if ($tgl1 != null && $tgl2 != null) {
            $this->db->where('tanggal' . ' >=', $tgl1);
            $this->db->where('tanggal' . ' <=', $tgl2);
        }
        if($idUser != null){
            $this->db->where('t.idUser', $idUser);
        }
        return $this->db->get('transaksi t')->result();
    }

    public function getTotalTransaksi($bln = null, $custom = [], $idUser = null)
    {
        if ($bln != null) {
            $this->db->like('tanggal', $bln, 'after');
        }
        if ($custom != null) {
            $this->db->where('tanggal' . ' >=', $custom[0]);
            $this->db->where('tanggal' . ' <=', $custom[1]);
        }
        if($idUser != null){
            $this->db->where(["idUser"=>$idUser]);
        }
        $this->db->select_sum('totalHarga', 'totalTransaksi');
        return $this->db->get('transaksi')->row()->totalTransaksi;
    }

    public function chartTransaksi($date = null)
    {
        if ($date != null) {
            $this->db->like('tanggal', $date, 'after');
        }
        $this->db->select_sum('totalHarga', 'totalTransaksi');
        return $this->db->get('transaksi')->row()->totalTransaksi;
    }
}
