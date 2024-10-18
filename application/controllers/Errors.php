<?php
class Errors extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function page_missing()
    {
        $this->output->set_status_header('404');
        $this->load->view('errors/my404'); //loading in custom error view
    }
}