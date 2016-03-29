<?php

	/**
	* THIS SOURCE CODE WAS AUTOMATICALLY GENERATED ON Wed 08:30:07  23/03/2016
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

	
class BirthCitizens {

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
	* private class variable first_name
	*/
	private $_first_name;
	
	/**
	* returns the value of first_name
	*/
	public function _get_first_name() {
		return $this->_first_name;
	}
	
	/**
	* sets the value of first_name
	*/
	public function set_first_name($first_name) {
		$this->_first_name = first_name;
	}
	
	
	/**
	* private class variable last_name
	*/
	private $_last_name;
	
	/**
	* returns the value of last_name
	*/
	public function _get_last_name() {
		return $this->_last_name;
	}
	
	/**
	* sets the value of last_name
	*/
	public function set_last_name($last_name) {
		$this->_last_name = last_name;
	}
	
	
	/**
	* private class variable surname
	*/
	private $_surname;
	
	/**
	* returns the value of surname
	*/
	public function _get_surname() {
		return $this->_surname;
	}
	
	/**
	* sets the value of surname
	*/
	public function set_surname($surname) {
		$this->_surname = surname;
	}
	
	
	/**
	* private class variable id_number
	*/
	private $_id_number;
	
	/**
	* returns the value of id_number
	*/
	public function _get_id_number() {
		return $this->_id_number;
	}
	
	/**
	* sets the value of id_number
	*/
	public function set_id_number($id_number) {
		$this->_id_number = id_number;
	}
	
	
	/**
	* private class variable sex
	*/
	private $_sex;
	
	/**
	* returns the value of sex
	*/
	public function _get_sex() {
		return $this->_sex;
	}
	
	/**
	* sets the value of sex
	*/
	public function set_sex($sex) {
		$this->_sex = sex;
	}
	
	
	/**
	* private class variable district_of_birth
	*/
	private $_district_of_birth;
	
	/**
	* returns the value of district_of_birth
	*/
	public function _get_district_of_birth() {
		return $this->_district_of_birth;
	}
	
	/**
	* sets the value of district_of_birth
	*/
	public function set_district_of_birth($district_of_birth) {
		$this->_district_of_birth = district_of_birth;
	}
	
	
	/**
	* private class variable home_district
	*/
	private $_home_district;
	
	/**
	* returns the value of home_district
	*/
	public function _get_home_district() {
		return $this->_home_district;
	}
	
	/**
	* sets the value of home_district
	*/
	public function set_home_district($home_district) {
		$this->_home_district = home_district;
	}
	
	
	/**
	* private class variable home_division
	*/
	private $_home_division;
	
	/**
	* returns the value of home_division
	*/
	public function _get_home_division() {
		return $this->_home_division;
	}
	
	/**
	* sets the value of home_division
	*/
	public function set_home_division($home_division) {
		$this->_home_division = home_division;
	}
	
	
	/**
	* private class variable home_location
	*/
	private $_home_location;
	
	/**
	* returns the value of home_location
	*/
	public function _get_home_location() {
		return $this->_home_location;
	}
	
	/**
	* sets the value of home_location
	*/
	public function set_home_location($home_location) {
		$this->_home_location = home_location;
	}
	
	
	/**
	* private class variable home_sublocation
	*/
	private $_home_sublocation;
	
	/**
	* returns the value of home_sublocation
	*/
	public function _get_home_sublocation() {
		return $this->_home_sublocation;
	}
	
	/**
	* sets the value of home_sublocation
	*/
	public function set_home_sublocation($home_sublocation) {
		$this->_home_sublocation = home_sublocation;
	}
	
	
	/**
	* private class variable date_of_birth
	*/
	private $_date_of_birth;
	
	/**
	* returns the value of date_of_birth
	*/
	public function _get_date_of_birth() {
		return $this->_date_of_birth;
	}
	
	/**
	* sets the value of date_of_birth
	*/
	public function set_date_of_birth($date_of_birth) {
		$this->_date_of_birth = date_of_birth;
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
	* Performs a database query and returns the value of id_citizen 
	* based on the value of $first_name,$last_name,$surname,$id_number,$sex,$district_of_birth,$home_district,$home_division,$home_location,$home_sublocation,$date_of_birth,$trashed,$deleted,$first_created,$last_modified passed to the function
	*/
	public function get_id_citizen($first_name,$last_name,$surname,$id_number,$sex,$district_of_birth,$home_district,$home_division,$home_location,$home_sublocation,$date_of_birth,$trashed,$deleted,$first_created,$last_modified) {
		$columns = array ('first_name','last_name','surname','id_number','sex','district_of_birth','home_district','home_division','home_location','home_sublocation','date_of_birth','trashed','deleted','first_created','last_modified');
		$records = array ($first_name,$last_name,$surname,$id_number,$sex,$district_of_birth,$home_district,$home_division,$home_location,$home_sublocation,$date_of_birth,$trashed,$deleted,$first_created,$last_modified);
		$id_citizen_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($id_citizen_)>0 ? $id_citizen_ [0] ['id_citizen'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of first_name 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_first_name($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$first_name_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($first_name_)>0 ? $first_name_ [0] ['first_name'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of last_name 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_last_name($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$last_name_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($last_name_)>0 ? $last_name_ [0] ['last_name'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of surname 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_surname($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$surname_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($surname_)>0 ? $surname_ [0] ['surname'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of id_number 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_id_number($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$id_number_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($id_number_)>0 ? $id_number_ [0] ['id_number'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of sex 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_sex($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$sex_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($sex_)>0 ? $sex_ [0] ['sex'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of district_of_birth 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_district_of_birth($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$district_of_birth_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($district_of_birth_)>0 ? $district_of_birth_ [0] ['district_of_birth'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of home_district 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_home_district($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$home_district_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($home_district_)>0 ? $home_district_ [0] ['home_district'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of home_division 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_home_division($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$home_division_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($home_division_)>0 ? $home_division_ [0] ['home_division'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of home_location 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_home_location($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$home_location_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($home_location_)>0 ? $home_location_ [0] ['home_location'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of home_sublocation 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_home_sublocation($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$home_sublocation_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($home_sublocation_)>0 ? $home_sublocation_ [0] ['home_sublocation'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of date_of_birth 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_date_of_birth($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$date_of_birth_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($date_of_birth_)>0 ? $date_of_birth_ [0] ['date_of_birth'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of trashed 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_trashed($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$trashed_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($trashed_)>0 ? $trashed_ [0] ['trashed'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of deleted 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_deleted($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$deleted_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($deleted_)>0 ? $deleted_ [0] ['deleted'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of first_created 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_first_created($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$first_created_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($first_created_)>0 ? $first_created_ [0] ['first_created'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of last_modified 
	* based on the value of $id_citizen passed to the function
	*/
	public function get_last_modified($id_citizen) {
		$columns = array ('id_citizen');
		$records = array ($id_citizen);
		$last_modified_ = $this->query_from_birth_citizens ( $columns, $records );
		return count($last_modified_)>0 ? $last_modified_ [0] ['last_modified'] : null;
	}
	

	
	/**
	* Inserts data into the table[birth_citizens] in the order below
	* array ('first_name','last_name','surname','id_number','sex','district_of_birth','home_district','home_division','home_location','home_sublocation','date_of_birth','trashed','deleted','first_created','last_modified')
	* is mappped into 
	* array ($first_name,$last_name,$surname,$id_number,$sex,$district_of_birth,$home_district,$home_division,$home_location,$home_sublocation,$date_of_birth,$trashed,$deleted,$first_created,$last_modified)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert_prepared_records($first_name,$last_name,$surname,$id_number,$sex,$district_of_birth,$home_district,$home_division,$home_location,$home_sublocation,$date_of_birth,$trashed,$deleted,$first_created,$last_modified,$redundancy_check= false, $printSQL = false) {
		$columns = array('first_name','last_name','surname','id_number','sex','district_of_birth','home_district','home_division','home_location','home_sublocation','date_of_birth','trashed','deleted','first_created','last_modified');
		$records = array($first_name,$last_name,$surname,$id_number,$sex,$district_of_birth,$home_district,$home_division,$home_location,$home_sublocation,$date_of_birth,$trashed,$deleted,$first_created,$last_modified);
		return $this->insert_records_to_birth_citizens ( $columns, $records,$redundancy_check, $printSQL );
	}

	
	/**
	* Returns the table name. This is the owner of these crud functions.
	* The various crud functions directly affect this table
	* @return Table Name [birth_citizens] 
	*/
	public static function get_table() {
		return 'birth_citizens';
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
	* Used  to calculate the number of times a record exists in the table [birth_citizens]
	*
	* @return the number of times a record exists exists in the table [birth_citizens]
	*/
	public function is_exists(Array $columns, Array $records, $printSQL = false) {
		return $this->get_database_utils ()->is_exists ( $this->get_table (), $columns, $records, $printSQL );
	}
	
	/**
	* Inserts data into the table[birth_citizens]
	*
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert_records_to_birth_citizens(Array $columns, Array $records,$redundancy_check = false, $printSQL = false) {
		return $this->insert_records ( $this->get_table (), $columns, $records,$redundancy_check, $printSQL );
	}
	
	/**
	* Deletes all the records that meets the passed criteria from the table [birth_citizens]
	*  
	* @return number of deleted rows
	*/
	public function delete_record_from_birth_citizens(Array $columns, Array $records, $printSQL = false) {
		return $this->delete_record ( $this->get_table (), $columns, $records, $printSQL );
	}
	
	/**
	* updates all the records that meets the passed criteria from the table [birth_citizens]
	*  
	* @return number of updated rows
	*/
	public function update_record_in_birth_citizens(Array $columns, Array $records, Array $where_columns, Array $where_records, $printSQL = false) {
		return $this->update_record ( $this->get_table (), $columns, $records, $where_columns, $where_records, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [birth_citizens] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function fetch_assoc_in_birth_citizens($distinct, Array $columns, Array $records, $extraSQL="", $printSQL = false) {
		return $this->fetch_assoc ( $distinct, $this->get_table (),$columns, $records, $extraSQL , $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [birth_citizens] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_from_birth_citizens(Array $columns, Array $records,$extraSQL="",  $printSQL = false) {
		return $this->query ( $this->get_table (), $columns, $records,$extraSQL,$printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [birth_citizens] that meets the passed distinct criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_distinct_from_birth_citizens(Array $columns, Array $records,$extraSQL="",  $printSQL = false) {
		return $this->query_distinct ( $this->get_table (), $columns, $records,$extraSQL,$printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [birth_citizens] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function search_in_birth_citizens(Array $columns, Array $records,$extraSQL="", $printSQL = false) {
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
	* Deletes all the records that meets the passed criteria from the table [birth_citizens]
	*  
	* @return number of deleted rows
	*/
	private function delete_record($table, Array $columns, Array $records, $printSQL = false) {
		return $this->get_database_utils ()->delete_record ( $table, $columns, $records, $printSQL );
	}
	
	
	/**
	* Inserts data into the table[birth_citizens]
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
	* updates all the records that meets the passed criteria from the table [birth_citizens]
	*  
	* @return number of updated rows
	*/
	private function update_record($table, Array $columns, Array $records, Array $where_columns, Array $where_records, $printSQL = false) {
		return $this->get_database_utils ()->update_record ( $table, $columns, $records, $where_columns, $where_records, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [birth_citizens] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	private function fetch_assoc($distinct, $table, Array $columns, Array $records, $extraSQL="", $printSQL = false) {
		return $this->get_database_utils ()->fetch_assoc ( $distinct, $table, $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [birth_citizens] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query($table, Array $columns, Array $records,$extraSQL="",$printSQL = false) {
		return $this->get_database_utils ()->query ( $table, $columns, $records,$extraSQL, $printSQL );
	}
	/**
	* Gets an Associative array of the records in the table [birth_citizens] that meets the distinct passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_distinct($table, Array $columns, Array $records,$extraSQL="",$printSQL = false) {
		return $this->get_database_utils ()->query_distinct ( $table, $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [birth_citizens] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	private function search($table, Array $columns, Array $records,$extraSQL="", $printSQL = false) {
		return $this->get_database_utils ()->search ( $table, $columns, $records, $extraSQL, $printSQL );
	}
}
?>
