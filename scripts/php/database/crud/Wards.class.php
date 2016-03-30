<?php

	/**
	* THIS SOURCE CODE WAS AUTOMATICALLY GENERATED ON Wed 04:26:20  30/03/2016
	* 
	*
	* DATABASE CRUD GENERATOR IS AN OPEN SOURCE PROJECT. TO IMPROVE ON THIS PROJECT BY
	* ADDING MODULES, FIXING BUGS e.t.c GET THE SOURCE CODE FROM GIT (https://github.com/marviktintor/dbcrudgen/)
	* 
	* DATABASE CRUD GENERATOR INFO:
	* 
	* DEVELOPER : VICTOR MWENDA
	* VERSION : DEVELOPER PREVIEW 0.1
	* SUPPORTED LANGUAGES : PHP
	* DEVELOPER EMAIL : vmwenda.vm@gmail.com
	* 
	*/

	
class Wards {

	private $databaseUtils;
	private $action;
	private $client;
	
	public function __construct($action, $client) {
	
		//Data Actions script file - It contains all the various data actions that can be performed on data.
		require_once 'C:\xampp\htdocs\titledeeds\scripts\php\database\core-apis\DatabaseActions.class.inc.php';
		
		//Database Utils Script - It contains all the MYSQL API's for performing CRUD transactions
		require_once 'C:\xampp\htdocs\titledeeds\scripts\php\database\core-apis\DatabaseUtils.class.inc.php';
		
		$this->init(true);
		
	}
	
	//Initializes
	public function init($execute = false) {
		
		//Init
		$this->databaseUtils = new DatabaseUtils ();
		
		//Ensure that the POST_CLIENT was posted before trying to get it
		if(!empty($_POST [POST_CLIENT])){
			$this->client = $_POST [POST_CLIENT];
		}
		
		//Ensure that the POST_ACTION was posted before trying to get it
		if(!empty($_POST [POST_ACTION])){
			$this->action = $_POST [POST_ACTION];
		}
		
		
		
		if ($execute) {
			
			if ($this->get_action() == ACTION_INSERT) {
			
			}
			
			if ($this->get_action() == ACTION_UPDATE) {
			
			}
			
			if ($this->get_action() == ACTION_QUERY) {
			
			}
			
			if ($this->get_action() == ACTION_DELETE) {
			
			}
		}
	}
	
		
	/**
	* private class variable id_county
	*/
	private $_id_county;
	
	/**
	* returns the value of id_county
	*/
	public function _get_id_county() {
		return $this->_id_county;
	}
	
	/**
	* sets the value of id_county
	*/
	public function set_id_county($id_county) {
		$this->_id_county = id_county;
	}
	
	
	/**
	* private class variable ward_name
	*/
	private $_ward_name;
	
	/**
	* returns the value of ward_name
	*/
	public function _get_ward_name() {
		return $this->_ward_name;
	}
	
	/**
	* sets the value of ward_name
	*/
	public function set_ward_name($ward_name) {
		$this->_ward_name = ward_name;
	}
	
	
	/**
	* private class variable ward_headquarters
	*/
	private $_ward_headquarters;
	
	/**
	* returns the value of ward_headquarters
	*/
	public function _get_ward_headquarters() {
		return $this->_ward_headquarters;
	}
	
	/**
	* sets the value of ward_headquarters
	*/
	public function set_ward_headquarters($ward_headquarters) {
		$this->_ward_headquarters = ward_headquarters;
	}
	
	
	/**
	* private class variable trashed
	*/
	private $_trashed;
	
	/**
	* returns the value of trashed
	*/
	public function _get_trashed() {
		return $this->_trashed;
	}
	
	/**
	* sets the value of trashed
	*/
	public function set_trashed($trashed) {
		$this->_trashed = trashed;
	}
	
	
	/**
	* private class variable deleted
	*/
	private $_deleted;
	
	/**
	* returns the value of deleted
	*/
	public function _get_deleted() {
		return $this->_deleted;
	}
	
	/**
	* sets the value of deleted
	*/
	public function set_deleted($deleted) {
		$this->_deleted = deleted;
	}
	
	
	/**
	* private class variable first_created
	*/
	private $_first_created;
	
	/**
	* returns the value of first_created
	*/
	public function _get_first_created() {
		return $this->_first_created;
	}
	
	/**
	* sets the value of first_created
	*/
	public function set_first_created($first_created) {
		$this->_first_created = first_created;
	}
	
	
	/**
	* private class variable last_modified
	*/
	private $_last_modified;
	
	/**
	* returns the value of last_modified
	*/
	public function _get_last_modified() {
		return $this->_last_modified;
	}
	
	/**
	* sets the value of last_modified
	*/
	public function set_last_modified($last_modified) {
		$this->_last_modified = last_modified;
	}
	

		
		
	/**
	* Performs a database query and returns the value of id_ward 
	* based on the value of $id_county,$ward_name,$ward_headquarters,$trashed,$deleted,$first_created,$last_modified passed to the function
	*/
	public function get_id_ward($id_county,$ward_name,$ward_headquarters,$trashed,$deleted,$first_created,$last_modified) {
		$columns = array ('id_county','ward_name','ward_headquarters','trashed','deleted','first_created','last_modified');
		$records = array ($id_county,$ward_name,$ward_headquarters,$trashed,$deleted,$first_created,$last_modified);
		$id_ward_ = $this->query_from_wards ( $columns, $records );
		return count($id_ward_)>0 ? $id_ward_ [0] ['id_ward'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of id_county 
	* based on the value of $id_ward passed to the function
	*/
	public function get_id_county($id_ward) {
		$columns = array ('id_ward');
		$records = array ($id_ward);
		$id_county_ = $this->query_from_wards ( $columns, $records );
		return count($id_county_)>0 ? $id_county_ [0] ['id_county'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of ward_name 
	* based on the value of $id_ward passed to the function
	*/
	public function get_ward_name($id_ward) {
		$columns = array ('id_ward');
		$records = array ($id_ward);
		$ward_name_ = $this->query_from_wards ( $columns, $records );
		return count($ward_name_)>0 ? $ward_name_ [0] ['ward_name'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of ward_headquarters 
	* based on the value of $id_ward passed to the function
	*/
	public function get_ward_headquarters($id_ward) {
		$columns = array ('id_ward');
		$records = array ($id_ward);
		$ward_headquarters_ = $this->query_from_wards ( $columns, $records );
		return count($ward_headquarters_)>0 ? $ward_headquarters_ [0] ['ward_headquarters'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of trashed 
	* based on the value of $id_ward passed to the function
	*/
	public function get_trashed($id_ward) {
		$columns = array ('id_ward');
		$records = array ($id_ward);
		$trashed_ = $this->query_from_wards ( $columns, $records );
		return count($trashed_)>0 ? $trashed_ [0] ['trashed'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of deleted 
	* based on the value of $id_ward passed to the function
	*/
	public function get_deleted($id_ward) {
		$columns = array ('id_ward');
		$records = array ($id_ward);
		$deleted_ = $this->query_from_wards ( $columns, $records );
		return count($deleted_)>0 ? $deleted_ [0] ['deleted'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of first_created 
	* based on the value of $id_ward passed to the function
	*/
	public function get_first_created($id_ward) {
		$columns = array ('id_ward');
		$records = array ($id_ward);
		$first_created_ = $this->query_from_wards ( $columns, $records );
		return count($first_created_)>0 ? $first_created_ [0] ['first_created'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of last_modified 
	* based on the value of $id_ward passed to the function
	*/
	public function get_last_modified($id_ward) {
		$columns = array ('id_ward');
		$records = array ($id_ward);
		$last_modified_ = $this->query_from_wards ( $columns, $records );
		return count($last_modified_)>0 ? $last_modified_ [0] ['last_modified'] : null;
	}
	

	
	/**
	* Inserts data into the table[wards] in the order below
	* array ('id_county','ward_name','ward_headquarters','trashed','deleted','first_created','last_modified')
	* is mappped into 
	* array ($id_county,$ward_name,$ward_headquarters,$trashed,$deleted,$first_created,$last_modified)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert_prepared_records($id_county,$ward_name,$ward_headquarters,$trashed,$deleted,$first_created,$last_modified,$redundancy_check= false, $printSQL = false) {
		$columns = array('id_county','ward_name','ward_headquarters','trashed','deleted','first_created','last_modified');
		$records = array($id_county,$ward_name,$ward_headquarters,$trashed,$deleted,$first_created,$last_modified);
		return $this->insert_records_to_wards ( $columns, $records,$redundancy_check, $printSQL );
	}

	
	/**
	* Returns the table name. This is the owner of these crud functions.
	* The various crud functions directly affect this table
	* @return Table Name [wards] 
	*/
	public static function get_table() {
		return 'wards';
	}
	
	/**
	* This action represents the intended database transaction
	*
	* @return the set action.
	*/
	private function get_action() {
		return $this->action;
	}
	
	/**
	* Returns the client doing transactions
	*
	* @return the client
	*/
	private function get_client() {
		return $this->client;
	}
	
	/**
	* Used  to calculate the number of times a record exists in the table [wards]
	*
	* @return the number of times a record exists exists in the table [wards]
	*/
	public function is_exists(Array $columns, Array $records, $printSQL = false) {
		return $this->get_database_utils ()->is_exists ( $this->get_table (), $columns, $records, $printSQL );
	}
	
	/**
	* Inserts data into the table[wards]
	*
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert_records_to_wards(Array $columns, Array $records,$redundancy_check = false, $printSQL = false) {
		return $this->insert_records ( $this->get_table (), $columns, $records,$redundancy_check, $printSQL );
	}
	
	/**
	* Deletes all the records that meets the passed criteria from the table [wards]
	*  
	* @return number of deleted rows
	*/
	public function delete_record_from_wards(Array $columns, Array $records, $printSQL = false) {
		return $this->delete_record ( $this->get_table (), $columns, $records, $printSQL );
	}
	
	/**
	* updates all the records that meets the passed criteria from the table [wards]
	*  
	* @return number of updated rows
	*/
	public function update_record_in_wards(Array $columns, Array $records, Array $where_columns, Array $where_records, $printSQL = false) {
		return $this->update_record ( $this->get_table (), $columns, $records, $where_columns, $where_records, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [wards] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function fetch_assoc_in_wards($distinct, Array $columns, Array $records, $extraSQL="", $printSQL = false) {
		return $this->fetch_assoc ( $distinct, $this->get_table (),$columns, $records, $extraSQL , $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [wards] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_from_wards(Array $columns, Array $records,$extraSQL="",  $printSQL = false) {
		return $this->query ( $this->get_table (), $columns, $records,$extraSQL,$printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [wards] that meets the passed distinct criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_distinct_from_wards(Array $columns, Array $records,$extraSQL="",  $printSQL = false) {
		return $this->query_distinct ( $this->get_table (), $columns, $records,$extraSQL,$printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [wards] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function search_in_wards(Array $columns, Array $records,$extraSQL="", $printSQL = false) {
		return $this->search ( $this->get_table (), $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Get Database Utils
	*  
	* @return an object of database utils
	*/
	public function get_database_utils() {
		return $this->databaseUtils;
	}
	
	/**
	* Deletes all the records that meets the passed criteria from the table [wards]
	*  
	* @return number of deleted rows
	*/
	private function delete_record($table, Array $columns, Array $records, $printSQL = false) {
		return $this->get_database_utils ()->delete_record ( $table, $columns, $records, $printSQL );
	}
	
	
	/**
	* Inserts data into the table[wards]
	*
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	
	private function insert_records($table, Array $columns, Array $records,$redundancy_check = false, $printSQL = false) {
		if($redundancy_check){
			if($this->is_exists($columns, $records) == 0){
				return $this->get_database_utils ()->insert_records ( $table, $columns, $records, $printSQL );
			} else return $this->is_exists($columns, $records);
		}else{
			return $this->get_database_utils ()->insert_records ( $table, $columns, $records, $printSQL );
		}
		
	}
	
	/**
	* updates all the records that meets the passed criteria from the table [wards]
	*  
	* @return number of updated rows
	*/
	private function update_record($table, Array $columns, Array $records, Array $where_columns, Array $where_records, $printSQL = false) {
		return $this->get_database_utils ()->update_record ( $table, $columns, $records, $where_columns, $where_records, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [wards] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	private function fetch_assoc($distinct, $table, Array $columns, Array $records, $extraSQL="", $printSQL = false) {
		return $this->get_database_utils ()->fetch_assoc ( $distinct, $table, $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [wards] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query($table, Array $columns, Array $records,$extraSQL="",$printSQL = false) {
		return $this->get_database_utils ()->query ( $table, $columns, $records,$extraSQL, $printSQL );
	}
	/**
	* Gets an Associative array of the records in the table [wards] that meets the distinct passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_distinct($table, Array $columns, Array $records,$extraSQL="",$printSQL = false) {
		return $this->get_database_utils ()->query_distinct ( $table, $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [wards] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	private function search($table, Array $columns, Array $records,$extraSQL="", $printSQL = false) {
		return $this->get_database_utils ()->search ( $table, $columns, $records, $extraSQL, $printSQL );
	}
}
?>
