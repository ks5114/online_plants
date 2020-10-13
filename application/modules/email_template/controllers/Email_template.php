<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class email_template extends Front_Controller {

    //--------------------------------------------------------------------


    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('email_template_model', null, true);
        $this->lang->load('email_template');
    }

    //--------------------------------------------------------------------



    /*
      Method: index()

      Displays a list of form data.
     */
    public function index() {

        $records = $this->email_template_model->find_all();

        Template::set('records', $records);
        Template::render();
    }

    //--------------------------------------------------------------------
}