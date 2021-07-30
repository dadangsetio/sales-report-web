<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kunjungan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('Asia/Jakarta');
        is_role(['administrator', 'sales']);
        $this->load->model('MainModel', 'main');
        $this->load->model('KunjunganModel', 'model');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');
    }

    public function index()
    {
        $data['title'] = "kunjungan";
        $nama = userdata()->nama;
        $role = userdata()->level;
        if($role == "sales"){
            $data['kunjungan'] = $this->model->getKunjungan(['nama_sales' => $nama]);
        }else{
            $data['kunjungan'] = $this->model->getKunjunganAll();
        }

        template_view('kunjungan/index', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_cv', 'Nama Perusahaan', 'required|trim');
        $this->form_validation->set_rules('nama_client', 'Nama Client', 'required|trim');
        $this->form_validation->set_rules('nama_sales', 'Nama Sales', 'required|trim');
        $this->form_validation->set_message('required', 'Kolom {field} harus diisi');
    }

    public function add()
    {
        $data['title'] = "Kunjungan";
        $data['user'] = $this->main->get('user');
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            template_view('kunjungan/add', $data);
        } else {
            $input = $this->input->post(null, true);

            $save = $this->main->insert('kunjungan', $input);
            if ($save) {
                msgBox('save');
                redirect('kunjungan');
            } else {
                msgBox('save', false);
                redirect('kunjungan/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $where = ['idkunjungan' => $id];

        $data['title'] = 'kunjungan';
        $data['kunjungan'] = $this->main->get_where('kunjungan', $where);

        $this->_validasi();
        if ($this->form_validation->run() == false) {
            template_view('kunjungan/edit', $data);
        } else {
            $input = $this->input->post(null, true);

            $edit = $this->main->update('kunjungan', $input, $where);
            if ($edit) {
                msgBox('edit');
                redirect('kunjungan');
            } else {
                msgBox('edit', false);
                redirect('kunjungan/edit/' . $id);
            }
        }
    }

    public function hapus($getId)
    {
        $id = encode_php_tags($getId);
        $where = ['idkunjungan' => $id];
        $del = $this->main->delete('kunjungan', $where);
        if ($del) {
            msgBox('delete');
            redirect('kunjungan');
        } else {
            msgBox('delete', false);
            redirect('kunjungan/add');
        }

        redirect('kunjungan');
    }

    public function accept($getId){
        $id = encode_php_tags($getId);
        $this->model->accept($id);
        redirect('kunjungan');
    }
}
