<?php

	/**
	* THIS SOURCE CODE WAS AUTOMATICALLY GENERATED ON Wed 03:50:31  30/03/2016
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

	
class LandOwners {

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
	* private class variable firstname
	*/
	private $_firstname;
	
	/**
	* returns the value of firstname
	*/
	public function _get_firstname() {
		return $this->_firstname;
	}
	
	/**
	* sets the value of firstname
	*/
	public function set_firstname($firstname) {
		$this->_firstname = firstname;
	}
	
	
	/**
	* private class variable middlename
	*/
	private $_middlename;
	
	/**
	* returns the value of middlename
	*/
	public function _get_middlename() {
		return $this->_middlename;
	}
	
	/**
	* sets the value of middlename
	*/
	public function set_middlename($middlename) {
		$this->_middlename = middlename;
	}
	
	
	/**
	* private class variable lastname
	*/
	private $_lastname;
	
	/**
	* returns the value of lastname
	*/
	public function _get_lastname() {
		return $this->_lastname;
	}
	
	/**
	* sets the value of lastname
	*/
	public function set_lastname($lastname) {
		$this->_lastname = lastname;
	}
	
	
	/**
	* private class variable idnumber
	*/
	private $_idnumber;
	
	/**
	* returns the value of idnumber
	*/
	public function _get_idnumber() {
		return $this->_idnumber;
	}
	
	/**
	* sets the value of idnumber
	*/
	public function set_idnumber($idnumber) {
		$this->_idnumber = idnumber;
	}
	
	
	/**
	* private class variable passport
	*/
	private $_passport;
	
	/**
	* returns the value of passport
	*/
	public function _get_passport() {
		return $this->_passport;
	}
	
	/**
	* sets the value of passport
	*/
	public function set_passport($passport) {
		$this->_passport = passport;
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
	* private class variable address
	*/
	private $_address;
	
	/**
	* returns the value of address
	*/
	public function _get_address() {
		return $this->_address;
	}
	
	/**
	* sets the value of address
	*/
	public function set_address($address) {
		$this->_address = address;
	}
	

		
		
	/**
	* Performs a database query and returns the value of id_land_owner 
	* based on the value of $firstname,$middlename,$lastname,$idnumber,$passport,$date_of_birth,$address passed to the function
	*/
	public function get_id_land_owner($firstname,$middlename,$lastname,$idnumber,$passport,$date_of_birth,$address) {
		$columns = array ('firstname','middlename','lastname','idnumber','passport','date_of_birth','address');
		$records = array ($firstname,$middlename,$lastname,$idnumber,$passport,$date_of_birth,$address);
		$id_land_owner_ = $this->query_from_land_owners ( $columns, $records );
		return count($id_land_owner_)>0 ? $id_land_owner_ [0] ['id_land_owner'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of firstname 
	* based on the value of $id_land_owner passed to the function
	*/
	public function get_firstname($id_land_owner) {
		$columns = array ('id_land_owner');
		$records = array ($id_land_owner);
		$firstname_ = $this->query_from_land_owners ( $columns, $records );
		return count($firstname_)>0 ? $firstname_ [0] ['firstname'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of middlename 
	* based on the value of $id_land_owner passed to the function
	*/
	public function get_middlename($id_land_owner) {
		$columns = array ('id_land_owner');
		$records = array ($id_land_owner);
		$middlename_ = $this->query_from_land_owners ( $columns, $records );
		return count($middlename_)>0 ? $middlename_ [0] ['middlename'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of lastname 
	* based on the value of $id_land_owner passed to the function
	*/
	public function get_lastname($id_land_owner) {
		$columns = array ('id_land_owner');
		$records = array ($id_land_owner);
		$lastname_ = $this->query_from_land_owners ( $columns, $records );
		return count($lastname_)>0 ? $lastname_ [0] ['lastname'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of idnumber 
	* based on the value of $id_land_owner passed to the function
	*/
	public function get_idnumber($id_land_owner) {
		$columns = array ('id_land_owner');
		$records = array ($id_land_owner);
		$idnumber_ = $this->query_from_land_owners ( $columns, $records );
		return count($idnumber_)>0 ? $idnumber_ [0] ['idnumber'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of passport 
	* based on the value of $id_land_owner passed to the function
	*/
	public function get_passport($id_land_owner) {
		$columns = array ('id_land_owner');
		$records = array ($id_land_owner);
		$passport_ = $this->query_from_land_owners ( $columns, $records );
		return count($passport_)>0 ? $passport_ [0] ['passport'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of date_of_birth 
	* based on the value of $id_land_owner passed to the function
	*/
	public function get_date_of_birth($id_land_owner) {
		$columns = array ('id_land_owner');
		$records = array ($id_land_owner);
		$date_of_birth_ = $this->query_from_land_owners ( $columns, $records );
		return count($date_of_birth_)>0 ? $date_of_birth_ [0] ['date_of_birth'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of address 
	* based on the value of $id_land_owner passed to the function
	*/
	public function get_address($id_land_owner) {
		$columns = array ('id_land_owner');
		$records = array ($id_land_owner);
		$address_ = $this->query_from_land_owners ( $columns, $records );
		return count($address_)>0 ? $address_ [0] ['address'] : null;
	}
	

	
	/**
	* Inserts data into the table[land_owners] in the order below
	* array ('firstname','middlename','lastname','idnumber','passport','date_of_birth','address')
	* is mappped into 
	* array ($firstname,$middlename,$lastname,$idnumber,$passport,$date_of_birth,$address)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert_prepared_records($firstname,$middlename,$lastname,$idnumber,$passport,$date_of_birth,$address,$redundancy_check= false, $printSQL = false) {
		$columns = array('firstname','middlename','lastname','idnumber','passport','date_of_birth','address');
		$records = array($firstname,$middlename,$lastname,$idnumber,$passport,$date_of_birth,$address);
		return $this->insert_records_to_land_owners ( $columns, $records,$redundancy_check, $printSQL );
	}

	
	/**
	* Returns the table name. This is the owner of these crud functions.
	* The various crud functions directly affect this table
	* @return Table Name [land_owners] 
	*/
	public static function get_table() {
		return 'land_owners';
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
	* Used  to calculate the number of times a record exists in the table [land_owners]
	*
	* @return the number of times a record exists exists in the table [land_owners]
	*/
	public function is_exists(Array $columns, Array $records, $printSQL = false) {
		return $this->get_database_utils ()->is_exists ( $this->get_table (), $columns, $records, $printSQL );
	}
	
	/**
	* Inserts data into the table[land_owners]
	*
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert_records_to_land_owners(Array $columns, Array $records,$redundancy_check = false, $printSQL = false) {
		return $this->insert_records ( $this->get_table (), $columns, $records,$redundancy_check, $printSQL );
	}
	
	/**
	* Deletes all the records that meets the passed criteria from the table [land_owners]
	*  
	* @return number of deleted rows
	*/
	public function delete_record_from_land_owners(Array $columns, Array $records, $printSQL = false) {
		return $this->delete_record ( $this->get_table (), $columns, $records, $printSQL );
	}
	
	/**
	* updates all the records that meets the passed criteria from the table [land_owners]
	*  
	* @return number of updated rows
	*/
	public function update_record_in_land_owners(Array $columns, Array $records, Array $where_columns, Array $where_records, $printSQL = false) {
		return $this->update_record ( $this->get_table (), $columns, $records, $where_columns, $where_records, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [land_owners] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function fetch_assoc_in_land_owners($distinct, Array $columns, Array $records, $extraSQL="", $printSQL = false) {
		return $this->fetch_assoc ( $distinct, $this->get_table (),$columns, $records, $extraSQL , $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [land_owners] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_from_land_owners(Array $columns, Array $records,$extraSQL="",  $printSQL = false) {
		return $this->query ( $this->get_table (), $columns, $records,$extraSQL,$printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [land_owners] that meets the passed distinct criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_distinct_from_land_owners(Array $columns, Array $records,$extraSQL="",  $printSQL = false) {
		return $this->query_distinct ( $this->get_table (), $columns, $records,$extraSQL,$printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [land_owners] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function search_in_land_owners(Array $columns, Array $records,$extraSQL="", $printSQL = false) {
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
	* Deletes all the records that meets the passed criteria from the table [land_owners]
	*  
	* @return number of deleted rows
	*/
	private function delete_record($table, Array $columns, Array $records, $printSQL = false) {
		return $this->get_database_utils ()->delete_record ( $table, $columns, $records, $printSQL );
	}
	
	
	/**
	* Inserts data into the table[land_owners]
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
	* updates all the records that meets the passed criteria from the table [land_owners]
	*  
	* @return number of updated rows
	*/
	private function update_record($table, Array $columns, Array $records, Array $where_columns, Array $where_records, $printSQL = false) {
		return $this->get_database_utils ()->update_record ( $table, $columns, $records, $where_columns, $where_records, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [land_owners] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	private function fetch_assoc($distinct, $table, Array $columns, Array $records, $extraSQL="", $printSQL = false) {
		return $this->get_database_utils ()->fetch_assoc ( $distinct, $table, $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [land_owners] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query($table, Array $columns, Array $records,$extraSQL="",$printSQL = false) {
		return $this->get_database_utils ()->query ( $table, $columns, $records,$extraSQL, $printSQL );
	}
	/**
	* Gets an Associative array of the records in the table [land_owners] that meets the distinct passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_distinct($table, Array $columns, Array $records,$extraSQL="",$printSQL = false) {
		return $this->get_database_utils ()->query_distinct ( $table, $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [land_owners] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	private function search($table, Array $columns, Array $records,$extraSQL="", $printSQL = false) {
		return $this->get_database_utils ()->search ( $table, $columns, $records, $extraSQL, $printSQL );
	}
}
?>
