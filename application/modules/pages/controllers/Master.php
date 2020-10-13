<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class master extends Admin_Controller
{

    //--------------------------------------------------------------------


    public function __construct()
    {
        parent::__construct();

        $this->auth->restrict('Pages.Master.View');

        $this->load->model('pages_model', null, true);
        $this->lang->load('pages');
        $this->module_config = module_config('pages');
//        $this->load->helper('ckeditor');
        Assets::add_js('js/editors/ckeditor/ckeditor.js');
        Template::set_block('sub_nav', 'master/_sub_nav');
    }

    //--------------------------------------------------------------------


    /*
      Method: index()

      Displays a list of form data.
     */
    public function index()
    {
        $this->load->model('pages/pages_model');
        $result = $this->pages_model->read($this->input->post());

        if ($this->input->is_ajax_request()) {
            Template::set("ajax", TRUE);
            Template::set('req_data', (isset($result['data']) && !empty($result['data'])) ? $result['data'] : "");
        } else {
            Assets::add_js('js/fancybox/source/jquery.fancybox.js');
            Assets::add_css('js/fancybox/source/jquery.fancybox.css');
            Assets::add_module_js('pages', 'pages.js');
        }

        Template::set('records', (isset($result['result']) && !empty($result['result'])) ? $result['result'] : '');
        Template::set('pagination', (isset($result['pagination']) && !empty($result['pagination'])) ? $result['pagination'] : '');
        Assets::add_js('grid.js');
        Template::set('toolbar_title', 'Manage Pages');
        Template::set('module_config', $this->module_config);
        Template::render();
    }

    //--------------------------------------------------------------------


    /*
      Method: create()

      Creates a Pages object.
     */
    public function create()
    {
        $this->auth->restrict('Pages.Master.Create');

        if ($this->input->post('save')) {
            if ($insert_id = $this->save_pages()) {
                // Log the activity
                $this->activity_model->log_activity($this->current_user->id, lang('bf_common_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'pages');

                Template::set_message(lang('pages_create_success'), 'success');
                Template::redirect(SITE_AREA . '/master/pages');
            } else {
                Template::set_message(lang('pages_create_failure') . $this->pages_model->error, 'error');
            }
        }
        //Assets::add_module_js('pages', 'pages.js');
        Template::set('toolbar_title', lang('bf_action_create') . ' Pages');
        Template::render();
    }

    //--------------------------------------------------------------------


    /*
      Method: edit()

      Allows editing of Pages data.
     */
    public function edit()
    {
        $id = $this->uri->segment(5);

        if (empty($id)) {
            Template::set_message(lang('pages_invalid_id'), 'error');
            redirect(SITE_AREA . '/master/pages');
        }

        if (isset($_POST['save'])) {
            $this->auth->restrict('Pages.Master.Edit');

            if ($this->save_pages('update', $id)) {
                // Log the activity
                $this->activity_model->log_activity($this->current_user->id, lang('bf_common_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'pages');

                Template::set_message(lang('pages_edit_success'), 'success');
            } else {
                Template::set_message(lang('pages_edit_failure') . $this->pages_model->error, 'error');
            }
        } else if (isset($_POST['delete'])) {
            $this->auth->restrict('Pages.Master.Delete');

            if ($this->pages_model->delete($id)) {
                // Log the activity
                $this->activity_model->log_activity($this->current_user->id, lang('bf_common_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'pages');

                Template::set_message(lang('bf_common_delete_success'), 'success');

                redirect(SITE_AREA . '/master/pages');
            } else {
                Template::set_message(lang('bf_common_delete_failure') . $this->pages_model->error, 'error');
            }
        }
        Template::set('pages', $this->pages_model->find($id));
        //Assets::add_module_js('pages', 'pages.js');
        Template::set('toolbar_title', 'Edit Pages');
        Template::render();
    }

    //--------------------------------------------------------------------
    //--------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------

    /*
      Method: save_pages()

      Does the actual validation and saving of form data.

      Parameters:
      $type	- Either "insert" or "update"
      $id		- The ID of the record to update. Not needed for inserts.

      Returns:
      An INT id for successful inserts. If updating, returns TRUE on success.
      Otherwise, returns FALSE.
     */
    private function save_pages($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        $this->form_validation->set_rules('page_title', 'Page Title', 'required|max_length[100]');
        if ($type == "insert") {
            $this->form_validation->set_rules('page_slug', 'Page Slug', 'required|is_unique[pages.page_slug]|max_length[100]');
        } else {
            $this->form_validation->set_rules('page_slug', 'Page Slug', 'required|unique[pages.page_slug,pages.id]|max_length[100]');
        }
        $this->form_validation->set_rules('page_content', 'Page Content', '');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() === FALSE) {
            return FALSE;
        }

        // make sure we only pass in the fields we want

        $data = array();
        $data['page_title'] = $this->input->post('page_title');
        $data['page_slug'] = $this->input->post('page_slug');
        $data['page_content'] = $this->input->post('page_content');
        $data['status'] = $this->input->post('status');

        if ($type == 'insert') {


            $id = $this->pages_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            } else {
                $return = FALSE;
            }
        } else if ($type == 'update') {
            $return = $this->pages_model->update($id, $data);
        }

        return $return;
    }

    //--------------------------------------------------------------------
}