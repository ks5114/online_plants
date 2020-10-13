<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Country controller
 */
class Country extends Front_Controller
{
    protected $permissionCreate = 'Country.Country.Create';
    protected $permissionDelete = 'Country.Country.Delete';
    protected $permissionEdit   = 'Country.Country.Edit';
    protected $permissionView   = 'Country.Country.View';

    /**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('country/country_model');
        $this->lang->load('country');
		
        

		Assets::add_module_js('country', 'country.js');
	}

	/**
	 * Display a list of Country data.
	 *
	 * @return void
	 */
	public function index($offset = 0)
	{
        
        $pagerUriSegment = 3;
        $pagerBaseUrl = site_url('country/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->country_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->country_model->limit($limit, $offset);
        

        // Don't display soft-deleted records
        $this->country_model->where($this->country_model->get_deleted_field(), 0);
		$records = $this->country_model->find_all();

		Template::set('records', $records);
        Template::set('records', (isset($result['result']) && !empty($result['result'])) ? $result['result'] : '' );
        Template::set('pagination', (isset($result['pagination']) && !empty($result['pagination'])) ? $result['pagination'] : '' );
		Assets::add_js('grid.js');
        

		Template::render();
	}
    
}