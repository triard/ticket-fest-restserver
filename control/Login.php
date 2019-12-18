<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->API = "http://localhost/ticket-fest/Users";
        $this->load->library('session');
        $this->load->library('curl');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('Login_model');
        $this->load->library('form_validation');    
    }

    public function index()
    {
     
        $data['title'] = "Login";

        $this->load->view('login/index', $data);

    }

    public function post_process()
    {
            $data = array(
                'name'              => $this->input->post('name'),
                'username'          => $this->input->post('username'),
                'password'          => $this->input->post('password'),
                'email'             => $this->input->post('email'),
                'addres'            => $this->input->post('addres'),
                'telephone'         => $this->input->post('telephone'),
                'level'             => $this->input->post('level')
            );
        $insert =  $this->curl->simple_post($this->API, $data);
        if ($insert) {
            $this->session->set_flashdata('result', 'Data Menu Berhasil Ditambahkan');
        } else {
            $this->session->set_flashdata('result', 'Data Menu Gagal Ditambahkan');
        }
        redirect('Login');
    }

    public function proses_login()
  {
    $username = htmlspecialchars($this->input->post('username'));
    $password = htmlspecialchars($this->input->post('password'));
    $cek_login = $this->Login_model->index($username, $password);
    $data_session = array(
      'nama' => $username,
      'status' => "login"
    );
    if ($cek_login) {
      foreach ($cek_login as $row) {
        # code...
        $this->session->set_userdata('user', $row->username);
        $this->session->set_userdata('level', $row->level);
      }
      if ($this->session->userdata('level') == ('admin')) {
        # code...
        redirect('Overview');
        $this->session->userdata($data_session);
        //home
      } else if ($this->session->userdata('level') == ('user')) {
        redirect('Beranda');
        $this->session->userdata($data_session);
      }
    } else {
      $this->session->set_flashdata('message', 'Password salah');
      redirect('Login');
      //redirect('login/index','refresh');
    }
  }
      public function logout(){
        $this->session->sess_destroy();
        redirect('Login','refresh');
      }


}