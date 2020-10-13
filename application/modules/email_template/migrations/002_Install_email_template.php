<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_email_template extends Migration {

	public function up()
	{
		$prefix = $this->db->dbprefix;

		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE,
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				
			),
			'label' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				
			),
			'content' => array(
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
		$this->dbforge->create_table('email_template');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('email_template');

	}

	//--------------------------------------------------------------------

}