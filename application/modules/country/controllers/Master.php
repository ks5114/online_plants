<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Master controller
 */
class Master extends Admin_Controller
{
    protected $permissionCreate = 'Country.Master.Create';
    protected $permissionDelete = 'Country.Master.Delete';
    protected $permissionEdit   = 'Country.Master.Edit';
    protected $permissionView   = 'Country.Master.View';

    /**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
        $this->auth->restrict($this->permissionView);
		$this->load->model('country/country_model');
        $this->lang->load('country');
		
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
		Template::set_block('sub_nav', 'master/_sub_nav');

		Assets::add_module_js('country', 'country.js');
	}

	/**
	 * Display a list of Country data.
	 *
	 * @return void
	 */
	public function index($offset = 0)
	{
        $result = $this->country_model->read($this->input->post());
        if ($this->input->is_ajax_request()) {
            Template::set("ajax", TRUE);
            Template::set('req_data', (isset($result['data']) && !empty($result['data'])) ? $result['data'] : "" );
        }
        // $pagerUriSegment = 5;
        // $pagerBaseUrl = site_url(SITE_AREA . '/master/country/index') . '/';
        
        // $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        // $this->load->library('pagination');
        // $pager['base_url']    = $pagerBaseUrl;
        // $pager['total_rows']  = $this->country_model->count_all();
        // $pager['per_page']    = $limit;
        // $pager['uri_segment'] = $pagerUriSegment;

        // $this->pagination->initialize($pager);
        // $this->country_model->limit($limit, $offset);
        
		$records = $this->country_model->find_all();

		Template::set('records', $records);
        Template::set('records', (isset($result['result']) && !empty($result['result'])) ? $result['result'] : '' );
        Template::set('pagination', (isset($result['pagination']) && !empty($result['pagination'])) ? $result['pagination'] : '' );
		Assets::add_js('grid.js');
        
    Template::set('toolbar_title', lang('country_manage'));

		Template::render();
	}
    
    /**
	 * Create a Country object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict($this->permissionCreate);
        
		if (isset($_POST['save'])) {
			if ($insert_id = $this->save_country()) {
				log_activity($this->auth->user_id(), lang('country_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'country');
				Template::set_message(lang('country_create_success'), 'success');

				redirect(SITE_AREA . '/master/country');
			}

            // Not validation error
			if ( ! empty($this->country_model->error)) {
				Template::set_message(lang('country_create_failure') . $this->country_model->error, 'error');
            }
		}

		Template::set('toolbar_title', lang('country_action_create'));

		Template::render();
	}
	/**
	 * Allows editing of Country data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);
		if (empty($id)) {
			Template::set_message(lang('country_invalid_id'), 'error');

			redirect(SITE_AREA . '/master/country');
		}
        
		if (isset($_POST['save'])) {
			$this->auth->restrict($this->permissionEdit);

			if ($this->save_country('update', $id)) {
				log_activity($this->auth->user_id(), lang('country_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'country');
				Template::set_message(lang('country_edit_success'), 'success');
				redirect(SITE_AREA . '/master/country');
			}

            // Not validation error
            if ( ! empty($this->country_model->error)) {
                Template::set_message(lang('country_edit_failure') . $this->country_model->error, 'error');
			}
		}
        
		elseif (isset($_POST['delete'])) {
			$this->auth->restrict($this->permissionDelete);

			if ($this->country_model->delete($id)) {
				log_activity($this->auth->user_id(), lang('country_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'country');
				Template::set_message(lang('country_delete_success'), 'success');

				redirect(SITE_AREA . '/master/country');
			}

            Template::set_message(lang('country_delete_failure') . $this->country_model->error, 'error');
		}
        
        Template::set('country', $this->country_model->find($id));

		Template::set('toolbar_title', lang('country_edit_heading'));
		Template::render();
	}

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Save the data.
	 *
	 * @param string $type Either 'insert' or 'update'.
	 * @param int	 $id	The ID of the record to update, ignored on inserts.
	 *
	 * @return bool|int An int ID for successful inserts, true for successful
     * updates, else false.
	 */
	private function save_country($type = 'insert', $id = 0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

        // Validate the data
        $this->form_validation->set_rules($this->country_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

		// Make sure we only pass in the fields we want
		
		$data = $this->country_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        
		$data['status']        = $this->input->post('status');

        $return = false;
		if ($type == 'insert') {
		    
			$id = $this->country_model->insert($data);

			if (is_numeric($id)) {
				$return = $id;
			}
		} elseif ($type == 'update') {
			$return = $this->country_model->update($id, $data);
		}

		return $return;
	}
}