<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages_model extends BF_Model
{

    protected $table_name = "pages";
    protected $key = "id";
    protected $soft_deletes = false;
    protected $date_format = "datetime";
    protected $set_created = true;
    protected $set_modified = true;
    protected $created_field = "created_on";
    protected $modified_field = "modified_on";
    protected $status_field = "status";
    protected $position_field = "page_title";

    public function __construct()
    {
        parent::__construct();
        $config = array(
            "table" => "{$this->table_name}",
            "status_field" => $this->status_field,
            "order" => array(
                "sortby" => $this->table_name . "." . $this->position_field,
                "order" => "ASC")
        );
        $this->load->library("CH_Grid_generator", $config, "grid");
    }

    public function read($req_data)
    {
        $this->grid->initialize(array(
            "req_data" => $req_data
        ));
        return $this->grid->get_result();
    }

    public function get_data($req_data)
    {
        $query = $this->db->query("select * from bf_pages ORDER BY page_title ASC");
        return $query->result();
    }
}
