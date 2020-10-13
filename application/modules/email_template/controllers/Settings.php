<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class settings extends Admin_Controller {

    //--------------------------------------------------------------------


    public function __construct() {
        parent::__construct();

        $this->auth->restrict('Email_Template.Settings.View');
        $this->load->model('email_template_model', null, true);
        $this->lang->load('email_template');

        Assets::add_js('js/ckeditor/ckeditor.js');
        Template::set_block('sub_nav', 'settings/_sub_nav');
    }

    //--------------------------------------------------------------------



    /*
      Method: index()

      Displays a list of form data.
     */
    public function index() {
        $result = $this->email_template_model->read($this->input->post());

        if ($this->input->is_ajax_request()) {
            Template::set("ajax", TRUE);
            Template::set('req_data', (isset($result['data']) && !empty($result['data'])) ? $result['data'] : "" );
        }
        Template::set('records', (isset($result['result']) && !empty($result['result'])) ? $result['result'] : '' );
        Template::set('pagination', (isset($result['pagination']) && !empty($result['pagination'])) ? $result['pagination'] : '' );
        Assets::add_js('grid.js');
        Template::set('toolbar_title', 'Manage Email Template');
        Template::render();
    }

    //--------------------------------------------------------------------



    /*
      Method: create()

      Creates a Email Template object.
     */
    public function create() {
        $this->auth->restrict('Email_Template.Settings.Create');

        if ($this->input->post('save')) {
            if ($insert_id = $this->save_email_template()) {
                // Log the activity
                $this->activity_model->log_activity($this->current_user->id, lang('bf_common_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'email_template');

                Template::set_message(lang('email_template_create_success'), 'success');
                Template::redirect(SITE_AREA . '/settings/email_template');
            } else {
                Template::set_message(lang('email_template_create_failure') . $this->email_template_model->error, 'error');
            }
        }
        Assets::add_module_js('email_template', 'email_template.js');

        Template::set('toolbar_title', 'Create Email Template');
        Template::render();
    }

    //--------------------------------------------------------------------



    /*
      Method: edit()

      Allows editing of Email Template data.
     */
    public function edit() {
        $id = $this->uri->segment(5);

        if (empty($id)) {
            Template::set_message(lang('email_template_invalid_id'), 'error');
            redirect(SITE_AREA . '/settings/email_template');
        }

        if (isset($_POST['save'])) {
            $this->auth->restrict('Email_Template.Settings.Edit');

            if ($this->save_email_template('update', $id)) {
                // Log the activity
                $this->activity_model->log_activity($this->current_user->id, lang('bf_common_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'email_template');

                Template::set_message(lang('email_template_edit_success'), 'success');
            } else {
                Template::set_message(lang('email_template_edit_failure') . $this->email_template_model->error, 'error');
            }
        } else if (isset($_POST['delete'])) {
            $this->auth->restrict('Email_Template.Settings.Delete');

            if ($this->email_template_model->delete($id)) {
                // Log the activity
                $this->activity_model->log_activity($this->current_user->id, lang('bf_common_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'email_template');

                Template::set_message(lang('bf_common_delete_success'), 'success');

                redirect(SITE_AREA . '/settings/email_template');
            } else {
                Template::set_message(lang('bf_common_delete_failure') . $this->email_template_model->error, 'error');
            }
        }
        Template::set('email_template', $this->email_template_model->find($id));
        Assets::add_module_js('email_template', 'email_template.js');

        Template::set('toolbar_title','Edit Email Template');
        Template::render();
    }

    //--------------------------------------------------------------------
    //--------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------

    /*
      Method: save_email_template()

      Does the actual validation and saving of form data.

      Parameters:
      $type	- Either "insert" or "update"
      $id		- The ID of the record to update. Not needed for inserts.

      Returns:
      An INT id for successful inserts. If updating, returns TRUE on success.
      Otherwise, returns FALSE.
     */
    private function save_email_template($type = 'insert', $id = 0) {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }


        $this->form_validation->set_rules('title', 'Title', 'required|max_length[255]');
        if ($type == 'insert') {
            $this->form_validation->set_rules('label', 'Label', 'required|max_length[255]|is_unique[email_template.label]');
        }
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() === FALSE) {
            return FALSE;
        }

        // make sure we only pass in the fields we want

        $data = array();
        $data['title'] = $this->input->post('title');
        $data['label'] = $this->input->post('label');
        $data['content'] = $this->input->post('content');
        $data['status'] = $this->input->post('status');

        if ($type == 'insert') {



            $id = $this->email_template_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            } else {
                $return = FALSE;
            }
        } else if ($type == 'update') {
            $return = $this->email_template_model->update($id, $data);
        }

        return $return;
    }

    //--------------------------------------------------------------------
}