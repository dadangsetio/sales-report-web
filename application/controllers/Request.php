<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Request extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_role(['administrator']);
        $this->load->model('MainModel', 'main');
        $this->load->model('BarangModel', 'barang');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('namaBarang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('idKategori', 'Kategori', 'required');
        $this->form_validation->set_rules('harga', 'harga', 'required|numeric|trim');
    }

    public function index()
    {
        $data['title'] = "Request";
        $data['barang'] = $this->barang->getBarang(0);

        template_view('request/index', $data);
    }

    public function accept($getId){
        $id = encode_php_tags($getId);
        $this->barang->accept($id);
        redirect('request');
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $where = ['kdBarang' => $id];

        $data['title'] = "Barang";
        $data['kategori'] = $this->main->get('kategori');
        $data['barang'] = $this->main->get_where('barang', $where);
        $data['kdBarang'] = $id;

        $this->_validasi();
        if ($this->form_validation->run() == false) {
            template_view('request/edit', $data);
        } else {
            $input = $this->input->post(null, true);

            $edit = $this->main->update('barang', $input, $where);
            if ($edit) {
                msgBox('edit');
                redirect('request');
            } else {
                msgBox('edit', false);
                redirect('request/edit/' . $id);
            }
        }
    }
}

