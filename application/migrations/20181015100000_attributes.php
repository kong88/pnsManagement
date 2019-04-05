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
		$this->db->where_in('key', array('custom1_name', 'custom2_name', 'custom3_name', 'custom4_name', 'custom5_name', 'custom6_name', 'custom7_name', 'custom8_name', 'custom9_name', 'custom10_name'));
		
		$custom_fields = array();
		
		$results = $this->db->get()->result_array();
		
		foreach($results as $result)
		{
			$custom_fields[] = $result['value'];
		}
		
		$custom_fields = array_filter($custom_fields);
		
		if(count($custom_fields) > 0)
		{
			$this->add_import_file_columns($custom_fields);
		}
		
		execute_script(APPPATH . 'migrations/sqlscripts/attributes.sql');
	}
	
	public function down()
	{
		
	}
	
	private function add_import_file_columns($columns)
	{
		$success = FALSE;
		$import_file_name	= '../import_items.csv';
		
		if(file_exists($import_file_name))
		{
			$line_array = $this->get_csv_file($import_file_name);
			
			if($line_array !== FALSE)
			{
				//Add the columns to the end of the array
				$line_array[0] = array_merge($line_array[0], $columns);
				log_message('ERROR',"columns: ". var_dump($line_array[0]));
				//Write out the new contents
				$success = $this->put_csv_file($import_file_name,$line_array);
			}
		}
		
		return $success;
	}
	
	private function get_csv_file($file_name)
	{
		ini_set("auto_detect_line_endings", true);
		
		if(($csv_file = fopen($file_name,'r')) !== FALSE)
		{
			while (($data = fgetcsv($csv_file)) !== FALSE)
			{
				$line_array[] = $data;
			}
		}
		else
		{
			return FALSE;
		}
		
		return $line_array;
	}
	
	private function put_csv_file($file_name, $file_array)
	{
		ini_set("auto_detect_line_endings", true);
		$success = FALSE;
		
		//Open for writing (truncates file)
		if(($csv_file = fopen($file_name,'w')) !== FALSE)
		{
			foreach($file_array as $line)
			{
				if(fputcsv($csv_file,$line) === FALSE)
				{
					return FALSE;
				}
			}
			
			$success = TRUE;
		}
		
		return $success;
	}
	
}
?>