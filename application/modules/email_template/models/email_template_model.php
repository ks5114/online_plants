<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_template_model extends BF_Model
{

    protected $table_name = "email_template";
    protected $key = "id";
    protected $soft_deletes = false;
    protected $date_format = "datetime";
    protected $set_created = true;
    protected $set_modified = true;
    protected $created_field = "created_on";
    protected $modified_field = "modified_on";
    protected $status_field = "status";

    const ID = "id";
    const EMAIL_TEMPLATES_TITLE = "title";
    const EMAIL_TEMPLATES_LABEL = "label";
    const EMAIL_TEMPLATES_CONTENT = "content";
    const EMAIL_TEMPLATES_STATUS = "status";
    const CREATED_ON = "created_on";
    const MODIFIED_ON = "modified_on";

    public function __construct()
    {
        parent::__construct();
        $config = array(
            "table" => $this->table_name,
            "status_field" => $this->status_field,
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

    public function replacer($textBeingReplaced, $arrayToReplace)
    {
        return strtr($textBeingReplaced, $arrayToReplace);
    }

    public function send_mail($template_label, $data, $mail_config)
    {
        if (!empty($template_label) && !empty($data) && isset($mail_config['to'])) {

//Initialization...
            $this->load->library('emailer/emailer');

            $template = $this->find_by(array("label" => $template_label, "status" => 1));

            if ($template) {
                $subject = $template->title;
                $message = html_entity_decode($this->replacer($template->content, $data));

                $option = array(
                    'to' => $mail_config['to'],
                    'subject' => $subject,
                    'message' => $message
                );
                return $this->emailer->send($option);
            }
        }

        return FALSE;
    }
    public function readPageData($arrayOfSpec = NULL) {
        $messages = "";
        $resultSet = NULL;
        $arrayOfData = NULl;
        $is_search = FALSE;
        $is_sortby = FALSE;
        $arrayToSelect = array(
            self::ID,
            self::EMAIL_TEMPLATES_TITLE,
            self::EMAIL_TEMPLATES_LABEL,
            self::EMAIL_TEMPLATES_STATUS,
            self::CREATED_ON,
            self::MODIFIED_ON
        );

        if ($arrayOfSpec != NULL) {
//                    showArray($arrayOfSpec);
            if (isset($arrayOfSpec['category']) && !empty($arrayOfSpec['category'])) {
                $act = $this->db->escape_str($arrayOfSpec['category']);
                $arrayOfData['category'] = $act;
            } else {
                $act = 'all';
                $arrayOfData['category'] = $act;
            }

            if (isset($arrayOfSpec['page']) && !empty($arrayOfSpec['page'])) {
                $page = (int) $this->db->escape_str($arrayOfSpec['page']);
            } else {
                $page = 1;
            }

            if (isset($arrayOfSpec['sortby']) && !empty($arrayOfSpec['sortby'])) {
                if (isset($arrayOfSpec['order']) && !empty($arrayOfSpec['order'])) {
                    $is_sortby = TRUE;
                    $arrayOfData['sortby'] = $arrayOfSpec['sortby'];
                    $arrayOfData['order'] = $arrayOfSpec['order'];
                }
            }

            if (isset($arrayOfSpec['search']) && !empty($arrayOfSpec['search'])) {
                if (isset($arrayOfSpec['search_filter']) && !empty($arrayOfSpec['search_filter'])) {
                    $is_search = TRUE;
                    $arrayOfData['search_filter'] = $this->db->escape_str($arrayOfSpec['search_filter']);
                    $arrayOfData['search'] = $this->db->escape_str($arrayOfSpec['search']);
                }
            }

            if (isset($arrayOfSpec['action']) && !empty($arrayOfSpec['action'])) {

                if (isset($arrayOfSpec['admin_status'])) {
                    $admin_status = (int) $this->db->escape_str($arrayOfSpec['admin_status']);
//                    echo " this status is defined ".$admin_status;
                }

                if (isset($arrayOfSpec['admin_id']) && !empty($arrayOfSpec['admin_id'])) {
                    $admin_id = (int) $this->db->escape_str($arrayOfSpec['admin_id']);
//                    echo " this id is defined ".$admin_id;
                }

                if (isset($arrayOfSpec['current_page']) && !empty($arrayOfSpec['current_page'])) {
                    $page = (int) $this->db->escape_str($arrayOfSpec['current_page']);
                    $arrayOfData['current_page'] = (int) $this->db->escape_str($arrayOfSpec['current_page']);
                }

                if ($arrayOfSpec['action'] == "ban") {
                    //ban the user...
                    if ($this->banUser($admin_id, $admin_status)) {
                        $messages = "Admin Status Successfully Updated";
                    }
                }

                if ($arrayOfSpec['action'] == "delete") {
                    if ($this->deleteUser($admin_id)) {
                        $messages = "Admin Successfully deleted";
                    }
                }

                if($arrayOfSpec['action'] == "deleteSelected"){
                    if(isset($arrayOfSpec['checked'])){
                        if($this->deleteSelectedTemplates($arrayOfSpec['checked'])){
                            $messages = "Selected Admin deleted successfully";
                        } else {
                            $messages = "Selected Admin not deleted successfully";
                        }
                    }
                }
            }
        } else {
            $act = 'all';
            $page = 1;
        }

        $this->load->library('pagination_extended');
        $this->pagination_extended->setCurrentPage($page);

        if (isset($act)) {
            if ($act == 'all') {
                // in the all category...
                //set the pagination obj...
                if ($is_search === TRUE) {
                    $this->db->select();
                    $this->db->like($arrayOfData['search_filter'], $arrayOfData['search'] );
                } else {
//                    $this->db->where($arrayOfWhereCond);
                }

            } else if ($act == 'active') {
                //in the active category...
                //set the pagination obj...
                $arrayOfWhereCond = array(self::EMAIL_TEMPLATES_STATUS, 1);
                if ($is_search === TRUE) {
                    $this->db->where(self::EMAIL_TEMPLATES_STATUS, 1);
                    $this->db->like($arrayOfData['search_filter'], $arrayOfData['search'] );
                } else {
                    $this->db->where(self::EMAIL_TEMPLATES_STATUS, 1);
                }
            } else if ($act == 'inactive') {
                //in the inactive category...
                //set the pagination obj...
                $arrayOfWhereCond = array(self::EMAIL_TEMPLATES_STATUS, 0);
                if ($is_search === TRUE) {
                    $this->db->where(self::EMAIL_TEMPLATES_STATUS, 0);
                    $this->db->like($arrayOfData['search_filter'], $arrayOfData['search'] );
                } else {
                    $this->db->where(self::EMAIL_TEMPLATES_STATUS, 0);
                }
            } else if ($act == 'newest') {
                //in the newest category...
                //set the array to sort...
                $arrayToSort = array(self::CREATED_ON, "DESC");
                if ($is_search === TRUE) {
                    $this->db->like($arrayOfData['search_filter'], $arrayOfData['search'] );
                    $this->db->order_by(self::CREATED_ON, "DESC");
                } else {
                    //set the pagination obj...
                    $this->db->order_by(self::CREATED_ON, "DESC");
                }
            } else if ($act == 'oldest') {
                //in the oldest category
                //set the array to sort...
                $arrayToSort = array(self::CREATED_ON, "ASC");
                if ($is_search === TRUE) {
                    $this->db->like($arrayOfData['search_filter'], $arrayOfData['search'] );
                    $this->db->order_by(self::CREATED_ON, "ASC");
                } else {
                    //set the pagination obj...
                    $this->db->order_by(self::CREATED_ON, "DESC");
                }
            } else {
                //do nothing...
                echo "not in the condition..";
            }
//            showArray($this->pagination);
//            echo $this->pagination->next_page();
//            echo $this->pagination->previous_page();

            $totalCounts = $this->db->count_all_results($this->table_name);
            $query = $this->db->last_query();
            $arrayOfData['query'] = $query;
            $this->pagination_extended->setTotalCounts($totalCounts);

            if ($is_search === TRUE) {
//                $resultSet = $this->search($arrayToSearch, $arrayToSelect, (isset($arrayToSort)) ? $arrayToSort : NULL, $this->pagination->per_page, $this->pagination->offset(), Db_table::ANDD);
                $this->db->select($arrayToSelect);
                if(isset($arrayOfWhereCond) && !empty($arrayOfWhereCond)){
                    $this->db->where($arrayOfWhereCond[0], $arrayOfWhereCond[1] );
                }
                if($is_search === TRUE){
                    $this->db->like($arrayOfData['search_filter'], $arrayOfData['search'] );
                }
                if($is_sortby === TRUE){
                    $this->db->order_by($arrayOfData['sortby'], $arrayOfData['order']);
                }
                if(isset($arrayToSort) && !empty($arrayToSort)){
                    $this->db->order_by($arrayToSort[0], $arrayToSort[1]);
                }
                $this->db->limit($this->pagination_extended->per_page);
                $this->db->offset($this->pagination_extended->offset());
                $resultSet = $this->db->get($this->table_name);

            } else {
//                $resultSet = $this->read($arrayToSelect, $arrayOfWhereCond, (isset($arrayToSort)) ? $arrayToSort : NULL, $this->pagination->per_page, $this->pagination->offset());
                $this->db->select($arrayToSelect);
                if (isset($arrayOfWhereCond) && !empty($arrayOfWhereCond)) {
                    $this->db->where($arrayOfWhereCond[0], $arrayOfWhereCond[1]);
                }
                if($is_sortby === TRUE){
                    $this->db->order_by($arrayOfData['sortby'], $arrayOfData['order']);
                }
                if(isset($arrayToSort) && !empty($arrayToSort)){
                    $this->db->order_by($arrayToSort[0], $arrayToSort[1]);
                }
                $this->db->limit($this->pagination_extended->per_page);
                $this->db->offset($this->pagination_extended->offset());
                $resultSet = $this->db->get($this->table_name);
            }

            if ($resultSet->num_rows() != 0) {
                $result['records'] = $resultSet->result();
                $result['pagination'] = $this->pagination_extended->printPaginationBar(SITE_AREA."/settings/email_templates/index", isset($arrayOfData) ? $arrayOfData : NULL);
                $result['data'] = $arrayOfData;
                $result['message'] = $messages;
                $result['current_page'] = $page;
                $result['total_pages'] = $this->pagination_extended->total_pages();
                $result['offset'] = $this->pagination_extended->offset();
                $result['last_query'] = $this->db->last_query();
                $result['totalCounts'] = $totalCounts;


                return $result;
            } else {
                //resultSet is empty...
                $result['data'] = $arrayOfData;
                return $result;
            }
        }
    }
    public function deleteSelectedTemplates($arrayOfId) {
        if ($arrayOfId != NULL) {
            $i = 1;
            foreach ($arrayOfId as $value) {
                $this->db->where(self::ID , $value);
                if ($this->db->delete($this->table_name)) {
                    $i++;
                }
            }
            if ($i == count($arrayOfId)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    public function getEmailTemplateByLabel($label) {

//        --------START------------METHOD FOR SEND MAIL----------START------------
//        $userdata=$this->user_model->select('email')->find($orderinfo->user_id);
//        //testdata($email);
//        $this->load->library('emailer/emailer');
//        $this->load->model("email_template/email_template_model");
//        if($type=='insert')
//        {
//            $template = $this->email_template_model->getEmailTemplateByLabel("pick_up_set");
//        }
//        else
//        {
//            $template = $this->email_template_model->getEmailTemplateByLabel("pick_up_set_update");
//        }
//
//        $arrayToReplace = array(
//            "[USER_NAME]"=>$username,
//            "[SITE_NAME]" => $this->settings_lib->item('site.title'),
//            "[SITE_URL]" => '<a href="'.site_url().'" target="_blank">'.site_url().'</a>',
//            "[ADDRESS]"=>$address,
//            "[ORDER_STATUS]"=>$orderstatus->name,
//            "[PICKUP_DATE]"=>$orderinfo->pickup_date,
//            "[PICKUP_TIME]"=>$orderinfo->pickup_time_from . ' to ' .$orderinfo->pickup_time_to,
//            "[DATE]"=> date('d/m/y'),
//            "[ORDER_ID]"=>$order_id
//        );
////testdata($arrayToReplace);
//        $subject = html_entity_decode($this->email_template_model->replacer($template->content, $arrayToReplace));
//        $emailData = array(
//            "subject" => html_entity_decode($this->email_template_model->replacer($template->title, array('[SITE_TITLE]'=>$this->settings_lib->item('site.title')))),
//            "message" => $subject,
//            "to" => $userdata->email,
//            "from" => $this->settings_lib->item('site.system_email')
//        );
//        //  testdata($emailData);
//        $reg_success_email = $this->emailer->send($emailData);
//        if($reg_success_email)
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//      ------END--------METHOD FOR SEND MAIL--------END-----------
        if(empty($label)){
            return FALSE;
        }

        $query = $this->db->select("*")
            ->where(self::EMAIL_TEMPLATES_LABEL, $label)
            ->where(self::EMAIL_TEMPLATES_STATUS, "1")
            ->limit(1)
            ->get($this->table_name);
        if($query->num_rows() == 0){
            return FALSE;
        } else {
            return array_shift($query->result());
        }

    }

    public function sendEmail($emailData){
        $this->load->library('emailer/emailer');
        if ($this->emailer->send($emailData)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
