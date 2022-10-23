<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('MahasiswaModel', 'model');
    }

    public function index_get()
    {
        $data = $this->model->getMahasiswa();
        $this->set_response([
          'status' => TRUE,
          'code' => 200,
          'message' => 'Success',
          'data' => $data,  
        ], REST_Controller::HTTP_OK);
    }

    public function sendmail_post(){
        $to_email = $this->post('email');
        $this->load->library('email');
        $this->email->from('tesalad@imtstack.com', 'Tes Salad');
        $this->email->to($to_email);
        $this->email->subject('Testing Announcement!');
        $this->email->message("
            <center>
                <div style= 'border: 2px solid #006FFF; border-radius: 32px; font-color: #000000; font-family: Helvetica, sans-serif;'>
                    <h1 style='color: #006FFF'> Welcome to <b>IMTStack</b> </h1>
                    <img style: 'border-radius: 50%;' alt='IMT' src='https://img.freepik.com/free-vector/messages-concept-illustration_114360-524.jpg?w=400'>
                    <h2 style= 'font-weight: bold;'> Selamat! Anda telah terdaftar pada program testing dari IMT Stack!</h2>
                    <p>Harap melakukan konfirmasi dengan menekan tombol di bawah ini</p>
                    <a href='https://www.youtube.com/watch?v=dQw4w9WgXcQ' style= 'box-shadow: 0px 0px 24px -8px #000000;
                    background-color:#006fff;
                    border-radius:42px;
                    display:inline-block;
                    cursor:pointer;
                    color:#ffffff;
                    font-size:16px;
                    padding:8px 16px;
                    text-decoration:none;
                    text-shadow:0px 1px 0px #ffffff;'>Konfirmasi</a>
                    <p style= 'font-size: 10px; font-weight: thin'> This is an automatic mail, please do not reply!</p>
                </div>
            </center>
        ");

        if ($this->email->send()){
            $this->set_response([
                'status' => TRUE,
                'code' => 200,
                'message'=> 'Email berhasil dikirimkan, silahkan periksa inbox email anda!',
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->set_response([
                'status' => FALSE,
                'code'=> 500,
                'message' => 'Gagal mengirimkan email',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
