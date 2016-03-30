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

	
class TitleDeedComments {

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
	* private class variable id_title_deed
	*/
	private $_id_title_deed;
	
	/**
	* returns the value of id_title_deed
	*/
	public function _get_id_title_deed() {
		return $this->_id_title_deed;
	}
	
	/**
	* sets the value of id_title_deed
	*/
	public function set_id_title_deed($id_title_deed) {
		$this->_id_title_deed = id_title_deed;
	}
	
	
	/**
	* private class variable title_deed_comments
	*/
	private $_title_deed_comments;
	
	/**
	* returns the value of title_deed_comments
	*/
	public function _get_title_deed_comments() {
		return $this->_title_deed_comments;
	}
	
	/**
	* sets the value of title_deed_comments
	*/
	public function set_title_deed_comments($title_deed_comments) {
		$this->_title_deed_comments = title_deed_comments;
	}
	
	
	/**
	* private class variable posted_date
	*/
	private $_posted_date;
	
	/**
	* returns the value of posted_date
	*/
	public function _get_posted_date() {
		return $this->_posted_date;
	}
	
	/**
	* sets the value of posted_date
	*/
	public function set_posted_date($posted_date) {
		$this->_posted_date = posted_date;
	}
	

		
		
	/**
	* Performs a database query and returns the value of id_title_deed_comment 
	* based on the value of $id_title_deed,$title_deed_comments,$posted_date passed to the function
	*/
	public function get_id_title_deed_comment($id_title_deed,$title_deed_comments,$posted_date) {
		$columns = array ('id_title_deed','title_deed_comments','posted_date');
		$records = array ($id_title_deed,$title_deed_comments,$posted_date);
		$id_title_deed_comment_ = $this->query_from_title_deed_comments ( $columns, $records );
		return count($id_title_deed_comment_)>0 ? $id_title_deed_comment_ [0] ['id_title_deed_comment'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of id_title_deed 
	* based on the value of $id_title_deed_comment passed to the function
	*/
	public function get_id_title_deed($id_title_deed_comment) {
		$columns = array ('id_title_deed_comment');
		$records = array ($id_title_deed_comment);
		$id_title_deed_ = $this->query_from_title_deed_comments ( $columns, $records );
		return count($id_title_deed_)>0 ? $id_title_deed_ [0] ['id_title_deed'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of title_deed_comments 
	* based on the value of $id_title_deed_comment passed to the function
	*/
	public function get_title_deed_comments($id_title_deed_comment) {
		$columns = array ('id_title_deed_comment');
		$records = array ($id_title_deed_comment);
		$title_deed_comments_ = $this->query_from_title_deed_comments ( $columns, $records );
		return count($title_deed_comments_)>0 ? $title_deed_comments_ [0] ['title_deed_comments'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of posted_date 
	* based on the value of $id_title_deed_comment passed to the function
	*/
	public function get_posted_date($id_title_deed_comment) {
		$columns = array ('id_title_deed_comment');
		$records = array ($id_title_deed_comment);
		$posted_date_ = $this->query_from_title_deed_comments ( $columns, $records );
		return count($posted_date_)>0 ? $posted_date_ [0] ['posted_date'] : null;
	}
	

	
	/**
	* Inserts data into the table[title_deed_comments] in the order below
	* array ('id_title_deed','title_deed_comments','posted_date')
	* is mappped into 
	* array ($id_title_deed,$title_deed_comments,$posted_date)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert_prepared_records($id_title_deed,$title_deed_comments,$posted_date,$redundancy_check= false, $printSQL = false) {
		$columns = array('id_title_deed','title_deed_comments','posted_date');
		$records = array($id_title_deed,$title_deed_comments,$posted_date);
		return $this->insert_records_to_title_deed_comments ( $columns, $records,$redundancy_check, $printSQL );
	}

	
	/**
	* Returns the table name. This is the owner of these crud functions.
	* The various crud functions directly affect this table
	* @return Table Name [title_deed_comments] 
	*/
	public static function get_table() {
		return 'title_deed_comments';
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
	* Used  to calculate the number of times a record exists in the table [title_deed_comments]
	*
	* @return the number of times a record exists exists in the table [title_deed_comments]
	*/
	public function is_exists(Array $columns, Array $records, $printSQL = false) {
		return $this->get_database_utils ()->is_exists ( $this->get_table (), $columns, $records, $printSQL );
	}
	
	/**
	* Inserts data into the table[title_deed_comments]
	*
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert_records_to_title_deed_comments(Array $columns, Array $records,$redundancy_check = false, $printSQL = false) {
		return $this->insert_records ( $this->get_table (), $columns, $records,$redundancy_check, $printSQL );
	}
	
	/**
	* Deletes all the records that meets the passed criteria from the table [title_deed_comments]
	*  
	* @return number of deleted rows
	*/
	public function delete_record_from_title_deed_comments(Array $columns, Array $records, $printSQL = false) {
		return $this->delete_record ( $this->get_table (), $columns, $records, $printSQL );
	}
	
	/**
	* updates all the records that meets the passed criteria from the table [title_deed_comments]
	*  
	* @return number of updated rows
	*/
	public function update_record_in_title_deed_comments(Array $columns, Array $records, Array $where_columns, Array $where_records, $printSQL = false) {
		return $this->update_record ( $this->get_table (), $columns, $records, $where_columns, $where_records, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [title_deed_comments] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function fetch_assoc_in_title_deed_comments($distinct, Array $columns, Array $records, $extraSQL="", $printSQL = false) {
		return $this->fetch_assoc ( $distinct, $this->get_table (),$columns, $records, $extraSQL , $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [title_deed_comments] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_from_title_deed_comments(Array $columns, Array $records,$extraSQL="",  $printSQL = false) {
		return $this->query ( $this->get_table (), $columns, $records,$extraSQL,$printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [title_deed_comments] that meets the passed distinct criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_distinct_from_title_deed_comments(Array $columns, Array $records,$extraSQL="",  $printSQL = false) {
		return $this->query_distinct ( $this->get_table (), $columns, $records,$extraSQL,$printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [title_deed_comments] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function search_in_title_deed_comments(Array $columns, Array $records,$extraSQL="", $printSQL = false) {
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
	* Deletes all the records that meets the passed criteria from the table [title_deed_comments]
	*  
	* @return number of deleted rows
	*/
	private function delete_record($table, Array $columns, Array $records, $printSQL = false) {
		return $this->get_database_utils ()->delete_record ( $table, $columns, $records, $printSQL );
	}
	
	
	/**
	* Inserts data into the table[title_deed_comments]
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
	* updates all the records that meets the passed criteria from the table [title_deed_comments]
	*  
	* @return number of updated rows
	*/
	private function update_record($table, Array $columns, Array $records, Array $where_columns, Array $where_records, $printSQL = false) {
		return $this->get_database_utils ()->update_record ( $table, $columns, $records, $where_columns, $where_records, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [title_deed_comments] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	private function fetch_assoc($distinct, $table, Array $columns, Array $records, $extraSQL="", $printSQL = false) {
		return $this->get_database_utils ()->fetch_assoc ( $distinct, $table, $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [title_deed_comments] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query($table, Array $columns, Array $records,$extraSQL="",$printSQL = false) {
		return $this->get_database_utils ()->query ( $table, $columns, $records,$extraSQL, $printSQL );
	}
	/**
	* Gets an Associative array of the records in the table [title_deed_comments] that meets the distinct passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_distinct($table, Array $columns, Array $records,$extraSQL="",$printSQL = false) {
		return $this->get_database_utils ()->query_distinct ( $table, $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [title_deed_comments] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	private function search($table, Array $columns, Array $records,$extraSQL="", $printSQL = false) {
		return $this->get_database_utils ()->search ( $table, $columns, $records, $extraSQL, $printSQL );
	}
}
?>
