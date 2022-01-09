<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contacts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Content-Type: text/html; charset=UTF-8");
        Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    }
    
    public function index()
    {
        $this->load->model('Contact');
        $data = array(
            'tagList' => $this->Contact->getTagList()
        );
        $this->load->view('contactsView', $data);
    }
}
