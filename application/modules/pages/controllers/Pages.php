<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pages extends Front_Controller
{

    //--------------------------------------------------------------------


    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('pages_model', null, true);
        $this->lang->load('pages');
    }

    //--------------------------------------------------------------------


    /*
      Method: index()

      Displays a list of form data.
     */

    public function index($pageslug = "")
    {
        if (empty($pageslug)) {
            show_404();
        }

        $where = array('page_slug' => $pageslug);
        if (is_numeric($pageslug)) {
            $where = array('id' => $pageslug);
        }
        $page = $this->pages_model->find_by($where);

        if (is_numeric($pageslug)) {
            $this->load->view('pages/previewPage', array("page" => $page));
        } else {
            Template::set_view('pages/index');
            Template::set('page', $page);
            Template::render();
        }

    }

    //--------------------------------------------------------------------
}