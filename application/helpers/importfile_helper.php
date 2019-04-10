<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Renames a column in a given CSV import file to a new name
 * 
 * @param	string	$from_column_name	Name of the old column name.
 * @param	string	$to_column_name		Name of the new column name.
 * @param	string	$import_file_name	Name of the file to modify.
 * @return	boolean						TRUE on success; FALSE on failure.
 */
function rename_import_file_column($from_column_name, $to_column_name, $import_file_name)
{
	$success			= FALSE;
	
	if(file_exists($import_file_name))
	{
		$line_array = get_csv_file($import_file_name);
		
		if($line_array != FALSE)
		{
			//Find the column to rename and rename it in the array
			$index = array_search($from_column_name,$line_array[0]);
			array_splice($line_array[0],$index,1,$to_column_name);
			
			//Write out the new contents
			$success = put_csv_file($import_file_name,$line_array);
		}
	}
	
	return $success;
}

/**
 * Deletes a column from a given import file.
 * 
 * @param	string	$column_name		Name of the column to delete
 * @param	string	$import_file_name	Name of the file to modify
 * @return	boolean						TRUE on success; FALSE on failure
 */
function delete_import_file_column($column_name, $import_file_name)
{
	$success 			= FALSE;
	
	if(file_exists($import_file_name))
	{
		$line_array = get_csv_file($import_file_name);
		
		if($line_array !== FALSE)
		{
			//Find the column to remove and remove it from the array
			$index = array_search($column_name,$line_array[0]);
			array_splice($line_array[0],$index,1);
			
			//Write out the new contents
			$success = put_csv_file($import_file_name,$line_array);
		}
	}
	
	return $success;
}

/**
 * Adds a column to a given import file.
 * 
 * @param 	string	$column_name		Name of the column to add
 * @param 	string	$import_file_name	Name of the file to modify
 * @return	boolean						TRUE on success; FALSE on failure
 */
function add_import_file_column($column_name, $import_file_name)
{
	$success = FALSE;
	
	if(file_exists($import_file_name))
	{
		$line_array = get_csv_file($import_file_name);
		
		if($line_array !== FALSE)
		{
			//Add the column to the end of the array
			$line_array[0][] = $column_name;
			
			//Write out the new contents
			$success = put_csv_file($import_file_name,$line_array);
		}
	}
	
	return $success;
}

/**
 * Read the contents of a given CSV formatted file into a two-dimensional array
 * 
 * @param	string				$file_name	Name of the file to read.
 * @return	boolean|array[][]				two-dimensional array with the file contents or FALSE on failure.
 */
function get_csv_file($file_name)
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

/**
 * Write the contents of a given two-dimensional array to a given file in CSV format.
 * 
 * @param	string		$file_name	Name of the file to write.  If the file exists all current content will be lost.
 * @param	array[][]	$file_array	A two-dimensional array containing the contents of the file to write.
 * @return	boolean					TRUE on success; FALSE on failure.
 */
function put_csv_file($file_name, $file_array)
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

?>