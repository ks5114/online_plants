<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_pages extends Migration {

	public function up()
	{
		$prefix = $this->db->dbprefix;

		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE,
			),
			'page_title' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				
			),
			'page_slug' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				
			),
			'page_content' => array(
				'type' => 'TEXT',
				
			),
			'created_on' => array(
				'type' => 'datetime',
				'default' => '0000-00-00 00:00:00',
			),
			'modified_on' => array(
				'type' => 'datetime',
				'default' => '0000-00-00 00:00:00',
			),
			'status' => array(
				'type' => 'TINYINT',
				'default' => 1,
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('pages');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('pages');

	}

	//--------------------------------------------------------------------

}