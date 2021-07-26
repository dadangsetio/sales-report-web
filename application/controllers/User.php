<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_role(['administrator']);

        $this->load->model('MainModel', 'main');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');
    }

    public function index()
    {
        $data['title'] = "User";
        $data['user'] = $this->main->get('user');

        template_view('user/index', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|trim|is_unique[user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|trim');
        $this->form_validation->set_rules('konfpass', 'Konfirmasi Password', 'required|matches[password]');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('noTelp', 'Nomor Telepon', 'required|numeric|trim');
        $this->form_validation->set_rules('level', 'Level', 'required');
    }

    public function add()
    {
        $data['title'] = "User";
        $data['idUser'] = $this->main->newUserId();

        $this->_validasi();
        if ($this->form_validation->run() == false) {
            template_view('user/add', $data);
        } else {
            $input = $this->input->post(null, true);
            unset($input['konfpass']);
            $input['idUser'] = $data['idUser'];
            $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
            $save = $this->main->insert('user', $input);
            if ($save) {
                msgBox('save');
            } else {
                msgBox('save', false);
            }
            redirect('user');
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $where = ['idUser' => $id];

        $data['title'] = "User";
        $data['user'] = $this->main->get_where('user', $where);
        $username = $data['user']->username;

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|trim');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('noTelp', 'Nomor Telepon', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            template_view('user/edit', $data);
        } else {
            $input = $this->input->post(null, true);

            if ($username != $input['username']) {
                $cekuser = $this->main->cekUsername($username, $input['username']);
                if ($cekuser > 0) {
                    setMsg('danger', "Username <strong>{$input['username']}</strong> sudah digunakan");
                    redirect('user/edit/' . $id);
                }
            }

            $edit = $this->main->update('user', $input, $where);
            if ($edit) {
                msgBox('edit');
                redirect('user');
            } else {
                msgBox('edit', false);
                redirect('user/edit' . $id);
            }
        }
    }

    public function hapus($getId)
    {
        $id = encode_php_tags($getId);
        $where = ['idUser' => $id];

        $cekUser = count((array) $this->main->get_where('transaksi', $where));

        if ($cekUser > 0) {
            msgBox('delete', false);
            setMsg('danger', '<strong>Gagal!</strong> Data telah digunakan transaksi, silahkan hapus transaksi terlebih dahulu.');
        } else {
            $del = $this->main->delete('user', $where);
            if ($del) {
                msgBox('delete');
                redirect('user');
            } else {
                msgBox('delete', false);
                redirect('user/add');
            }
        }

        redirect('user');
    }
}
