<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Attributes extends CI_Migration
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function up()
	{
		//Get the name of custom fields to add
		$this->db->select('value');
		$this->db->from('app_config');
		$this->db->where_in('key', array(
			'custom1_name',
			'custom2_name',
			'custom3_name',
			'custom4_name',
			'custom5_name',
			'custom6_name',
			'custom7_name',
			'custom8_name',
			'custom9_name',
			'custom10_name'
		));
		
		$custom_fields = array();
		
		$results = $this->db->get()->result_array();
		
		foreach($results as $result)
		{
			$custom_fields[] = 'attribute_' . $result['value'];
		}
		
		$custom_fields = array_filter($custom_fields);
		
		if(count($custom_fields) > 0)
		{
			add_import_file_columns($custom_fields, '../import_items.csv');
		}
		
		execute_script(APPPATH . 'migrations/sqlscripts/attributes.sql');
	}
	
	public function down()
	{
		
	}
}
?>