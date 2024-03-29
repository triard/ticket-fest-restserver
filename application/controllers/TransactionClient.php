<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TransactionClient extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('curl');
        $this->API = "http://localhost/ticket-fest/Transaction";
        $this->load->library('session');
        $this->load->library('curl');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('Ticket_model');
        $this->load->model('Users_model');
        $this->load->model('Transaction_model');
        if ($this->session->userdata('level') != "admin") {
			redirect('Login', 'refresh');
		}
    }

    public function index()
    {
        $data['transaction'] = json_decode($this->curl->simple_get($this->API));
        $data['title'] = "Transaction";
        $this->load->view('admin/_partials/head', $data, FALSE);
        $this->load->view('admin/transaction/index', $data, FALSE);
        $this->load->view('admin/_partials/footer', $data, FALSE);

    }

    public function getProduct()
    {
        $data['title'] = 'Fest Admin Panel | Ticket';
        $data['transaction'] = $this->Transaction_model->getTransaction();
      
        $this->load->view('admin/_partials/head', $data, FALSE);
        $this->load->view('admin/transaction/index', $data, FALSE);
        $this->load->view('admin/_partials/footer', $data, FALSE);

    }

    public function post()
    {
        $data['title'] = "Tambah";
        $data['category'] = $this->Users_model->getAll();        
        $data['category'] = $this->Ticket_model->getAll();        
        $this->load->view('admin/transaction/post', $data, FALSE);
    }

    public function post_process()
    {
        $data = array(
            'id_ticket'                  => $this->input->post('id_ticket'),
            'id_user'                        => $this->input->post('id_user')
        );
        $insert =  $this->curl->simple_post($this->API, $data);
        // var_dump($insert);die;
        if ($insert) {
            $this->session->set_flashdata('result', 'Data Menu Berhasil Ditambahkan');
        } else {
            $this->session->set_flashdata('result', 'Data Menu Gagal Ditambahkan');
        }
        redirect('TransactionClient');
    }

    public function put()
    {
        $params = array('id_trans' =>  $this->uri->segment(3));
        $data['transaction'] = json_decode($this->curl->simple_get($this->API, $params));
        $data['title'] = "Edit Data";
         $this->load->view('admin/transaction/put', $data, FALSE);
     }

    public function put_process()
    {
        $data = array(
            'id_trans'                   => $this->input->post('id_trans'),
            'id_ticket'                  => $this->input->post('id_ticket'),
            'qty'                        => $this->input->post('qty'),
            'date'                       => $this->input->post('date')
        );
        $update =  $this->curl->simple_put($this->API, $data, array(CURLOPT_BUFFERSIZE => 10));
        // var_dump($update);die; 
        if($update)
        {
            $this->session->set_flashdata('hasil','Update Data Berhasil');
        }else
        {
           $this->session->set_flashdata('hasil','Update Data Gagal');
        }
        redirect('TransactionClient/');
    }

    public function delete()
    {
        $params = array('id_trans' =>  $this->uri->segment(3));
        $delete =  $this->curl->simple_delete($this->API, $params);
        if ($delete) {
            $this->session->set_flashdata('result', 'Hapus Data Menu Berhasil');
        } else {
            $this->session->set_flashdata('result', 'Hapus Data Menu Gagal');
        }
        redirect('TransactionClient');
    }
}