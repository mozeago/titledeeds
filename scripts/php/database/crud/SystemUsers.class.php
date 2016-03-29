<?php

	/**
	* THIS SOURCE CODE WAS AUTOMATICALLY GENERATED ON Wed 08:30:08  23/03/2016
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

	
class SystemUsers {

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
	* private class variable email
	*/
	private $_email;
	
	/**
	* returns the value of email
	*/
	public function _get_email() {
		return $this->_email;
	}
	
	/**
	* sets the value of email
	*/
	public function set_email($email) {
		$this->_email = email;
	}
	
	
	/**
	* private class variable phonenumber
	*/
	private $_phonenumber;
	
	/**
	* returns the value of phonenumber
	*/
	public function _get_phonenumber() {
		return $this->_phonenumber;
	}
	
	/**
	* sets the value of phonenumber
	*/
	public function set_phonenumber($phonenumber) {
		$this->_phonenumber = phonenumber;
	}
	
	
	/**
	* private class variable username
	*/
	private $_username;
	
	/**
	* returns the value of username
	*/
	public function _get_username() {
		return $this->_username;
	}
	
	/**
	* sets the value of username
	*/
	public function set_username($username) {
		$this->_username = username;
	}
	
	
	/**
	* private class variable password
	*/
	private $_password;
	
	/**
	* returns the value of password
	*/
	public function _get_password() {
		return $this->_password;
	}
	
	/**
	* sets the value of password
	*/
	public function set_password($password) {
		$this->_password = password;
	}
	
	
	/**
	* private class variable account_status
	*/
	private $_account_status;
	
	/**
	* returns the value of account_status
	*/
	public function _get_account_status() {
		return $this->_account_status;
	}
	
	/**
	* sets the value of account_status
	*/
	public function set_account_status($account_status) {
		$this->_account_status = account_status;
	}
	

		
		
	/**
	* Performs a database query and returns the value of id_system_user 
	* based on the value of $firstname,$lastname,$email,$phonenumber,$username,$password,$account_status passed to the function
	*/
	public function get_id_system_user($firstname,$lastname,$email,$phonenumber,$username,$password,$account_status) {
		$columns = array ('firstname','lastname','email','phonenumber','username','password','account_status');
		$records = array ($firstname,$lastname,$email,$phonenumber,$username,$password,$account_status);
		$id_system_user_ = $this->query_from_system_users ( $columns, $records );
		return count($id_system_user_)>0 ? $id_system_user_ [0] ['id_system_user'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of firstname 
	* based on the value of $id_system_user passed to the function
	*/
	public function get_firstname($id_system_user) {
		$columns = array ('id_system_user');
		$records = array ($id_system_user);
		$firstname_ = $this->query_from_system_users ( $columns, $records );
		return count($firstname_)>0 ? $firstname_ [0] ['firstname'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of lastname 
	* based on the value of $id_system_user passed to the function
	*/
	public function get_lastname($id_system_user) {
		$columns = array ('id_system_user');
		$records = array ($id_system_user);
		$lastname_ = $this->query_from_system_users ( $columns, $records );
		return count($lastname_)>0 ? $lastname_ [0] ['lastname'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of email 
	* based on the value of $id_system_user passed to the function
	*/
	public function get_email($id_system_user) {
		$columns = array ('id_system_user');
		$records = array ($id_system_user);
		$email_ = $this->query_from_system_users ( $columns, $records );
		return count($email_)>0 ? $email_ [0] ['email'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of phonenumber 
	* based on the value of $id_system_user passed to the function
	*/
	public function get_phonenumber($id_system_user) {
		$columns = array ('id_system_user');
		$records = array ($id_system_user);
		$phonenumber_ = $this->query_from_system_users ( $columns, $records );
		return count($phonenumber_)>0 ? $phonenumber_ [0] ['phonenumber'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of username 
	* based on the value of $id_system_user passed to the function
	*/
	public function get_username($id_system_user) {
		$columns = array ('id_system_user');
		$records = array ($id_system_user);
		$username_ = $this->query_from_system_users ( $columns, $records );
		return count($username_)>0 ? $username_ [0] ['username'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of password 
	* based on the value of $id_system_user passed to the function
	*/
	public function get_password($id_system_user) {
		$columns = array ('id_system_user');
		$records = array ($id_system_user);
		$password_ = $this->query_from_system_users ( $columns, $records );
		return count($password_)>0 ? $password_ [0] ['password'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of account_status 
	* based on the value of $id_system_user passed to the function
	*/
	public function get_account_status($id_system_user) {
		$columns = array ('id_system_user');
		$records = array ($id_system_user);
		$account_status_ = $this->query_from_system_users ( $columns, $records );
		return count($account_status_)>0 ? $account_status_ [0] ['account_status'] : null;
	}
	

	
	/**
	* Inserts data into the table[system_users] in the order below
	* array ('firstname','lastname','email','phonenumber','username','password','account_status')
	* is mappped into 
	* array ($firstname,$lastname,$email,$phonenumber,$username,$password,$account_status)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert_prepared_records($firstname,$lastname,$email,$phonenumber,$username,$password,$account_status,$redundancy_check= false, $printSQL = false) {
		$columns = array('firstname','lastname','email','phonenumber','username','password','account_status');
		$records = array($firstname,$lastname,$email,$phonenumber,$username,$password,$account_status);
		return $this->insert_records_to_system_users ( $columns, $records,$redundancy_check, $printSQL );
	}

	
	/**
	* Returns the table name. This is the owner of these crud functions.
	* The various crud functions directly affect this table
	* @return Table Name [system_users] 
	*/
	public static function get_table() {
		return 'system_users';
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
	* Used  to calculate the number of times a record exists in the table [system_users]
	*
	* @return the number of times a record exists exists in the table [system_users]
	*/
	public function is_exists(Array $columns, Array $records, $printSQL = false) {
		return $this->get_database_utils ()->is_exists ( $this->get_table (), $columns, $records, $printSQL );
	}
	
	/**
	* Inserts data into the table[system_users]
	*
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert_records_to_system_users(Array $columns, Array $records,$redundancy_check = false, $printSQL = false) {
		return $this->insert_records ( $this->get_table (), $columns, $records,$redundancy_check, $printSQL );
	}
	
	/**
	* Deletes all the records that meets the passed criteria from the table [system_users]
	*  
	* @return number of deleted rows
	*/
	public function delete_record_from_system_users(Array $columns, Array $records, $printSQL = false) {
		return $this->delete_record ( $this->get_table (), $columns, $records, $printSQL );
	}
	
	/**
	* updates all the records that meets the passed criteria from the table [system_users]
	*  
	* @return number of updated rows
	*/
	public function update_record_in_system_users(Array $columns, Array $records, Array $where_columns, Array $where_records, $printSQL = false) {
		return $this->update_record ( $this->get_table (), $columns, $records, $where_columns, $where_records, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [system_users] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function fetch_assoc_in_system_users($distinct, Array $columns, Array $records, $extraSQL="", $printSQL = false) {
		return $this->fetch_assoc ( $distinct, $this->get_table (),$columns, $records, $extraSQL , $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [system_users] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_from_system_users(Array $columns, Array $records,$extraSQL="",  $printSQL = false) {
		return $this->query ( $this->get_table (), $columns, $records,$extraSQL,$printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [system_users] that meets the passed distinct criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_distinct_from_system_users(Array $columns, Array $records,$extraSQL="",  $printSQL = false) {
		return $this->query_distinct ( $this->get_table (), $columns, $records,$extraSQL,$printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [system_users] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function search_in_system_users(Array $columns, Array $records,$extraSQL="", $printSQL = false) {
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
	* Deletes all the records that meets the passed criteria from the table [system_users]
	*  
	* @return number of deleted rows
	*/
	private function delete_record($table, Array $columns, Array $records, $printSQL = false) {
		return $this->get_database_utils ()->delete_record ( $table, $columns, $records, $printSQL );
	}
	
	
	/**
	* Inserts data into the table[system_users]
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
	* updates all the records that meets the passed criteria from the table [system_users]
	*  
	* @return number of updated rows
	*/
	private function update_record($table, Array $columns, Array $records, Array $where_columns, Array $where_records, $printSQL = false) {
		return $this->get_database_utils ()->update_record ( $table, $columns, $records, $where_columns, $where_records, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [system_users] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	private function fetch_assoc($distinct, $table, Array $columns, Array $records, $extraSQL="", $printSQL = false) {
		return $this->get_database_utils ()->fetch_assoc ( $distinct, $table, $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [system_users] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query($table, Array $columns, Array $records,$extraSQL="",$printSQL = false) {
		return $this->get_database_utils ()->query ( $table, $columns, $records,$extraSQL, $printSQL );
	}
	/**
	* Gets an Associative array of the records in the table [system_users] that meets the distinct passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_distinct($table, Array $columns, Array $records,$extraSQL="",$printSQL = false) {
		return $this->get_database_utils ()->query_distinct ( $table, $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [system_users] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	private function search($table, Array $columns, Array $records,$extraSQL="", $printSQL = false) {
		return $this->get_database_utils ()->search ( $table, $columns, $records, $extraSQL, $printSQL );
	}
}
?>
