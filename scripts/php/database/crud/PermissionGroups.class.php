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

	
class PermissionGroups {

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
	* private class variable permission_group_crud
	*/
	private $_permission_group_crud;
	
	/**
	* returns the value of permission_group_crud
	*/
	public function _get_permission_group_crud() {
		return $this->_permission_group_crud;
	}
	
	/**
	* sets the value of permission_group_crud
	*/
	public function set_permission_group_crud($permission_group_crud) {
		$this->_permission_group_crud = permission_group_crud;
	}
	
	
	/**
	* private class variable land_owners_crud
	*/
	private $_land_owners_crud;
	
	/**
	* returns the value of land_owners_crud
	*/
	public function _get_land_owners_crud() {
		return $this->_land_owners_crud;
	}
	
	/**
	* sets the value of land_owners_crud
	*/
	public function set_land_owners_crud($land_owners_crud) {
		$this->_land_owners_crud = land_owners_crud;
	}
	
	
	/**
	* private class variable title_deeds_crud
	*/
	private $_title_deeds_crud;
	
	/**
	* returns the value of title_deeds_crud
	*/
	public function _get_title_deeds_crud() {
		return $this->_title_deeds_crud;
	}
	
	/**
	* sets the value of title_deeds_crud
	*/
	public function set_title_deeds_crud($title_deeds_crud) {
		$this->_title_deeds_crud = title_deeds_crud;
	}
	
	
	/**
	* private class variable title_deed_comments_crud
	*/
	private $_title_deed_comments_crud;
	
	/**
	* returns the value of title_deed_comments_crud
	*/
	public function _get_title_deed_comments_crud() {
		return $this->_title_deed_comments_crud;
	}
	
	/**
	* sets the value of title_deed_comments_crud
	*/
	public function set_title_deed_comments_crud($title_deed_comments_crud) {
		$this->_title_deed_comments_crud = title_deed_comments_crud;
	}
	
	
	/**
	* private class variable title_deed_natures_crud
	*/
	private $_title_deed_natures_crud;
	
	/**
	* returns the value of title_deed_natures_crud
	*/
	public function _get_title_deed_natures_crud() {
		return $this->_title_deed_natures_crud;
	}
	
	/**
	* sets the value of title_deed_natures_crud
	*/
	public function set_title_deed_natures_crud($title_deed_natures_crud) {
		$this->_title_deed_natures_crud = title_deed_natures_crud;
	}
	
	
	/**
	* private class variable title_deed_easements_crud
	*/
	private $_title_deed_easements_crud;
	
	/**
	* returns the value of title_deed_easements_crud
	*/
	public function _get_title_deed_easements_crud() {
		return $this->_title_deed_easements_crud;
	}
	
	/**
	* sets the value of title_deed_easements_crud
	*/
	public function set_title_deed_easements_crud($title_deed_easements_crud) {
		$this->_title_deed_easements_crud = title_deed_easements_crud;
	}
	
	
	/**
	* private class variable title_deed_proprietorship_crud
	*/
	private $_title_deed_proprietorship_crud;
	
	/**
	* returns the value of title_deed_proprietorship_crud
	*/
	public function _get_title_deed_proprietorship_crud() {
		return $this->_title_deed_proprietorship_crud;
	}
	
	/**
	* sets the value of title_deed_proprietorship_crud
	*/
	public function set_title_deed_proprietorship_crud($title_deed_proprietorship_crud) {
		$this->_title_deed_proprietorship_crud = title_deed_proprietorship_crud;
	}
	
	
	/**
	* private class variable system_users_crud
	*/
	private $_system_users_crud;
	
	/**
	* returns the value of system_users_crud
	*/
	public function _get_system_users_crud() {
		return $this->_system_users_crud;
	}
	
	/**
	* sets the value of system_users_crud
	*/
	public function set_system_users_crud($system_users_crud) {
		$this->_system_users_crud = system_users_crud;
	}
	
	
	/**
	* private class variable user_types_crud
	*/
	private $_user_types_crud;
	
	/**
	* returns the value of user_types_crud
	*/
	public function _get_user_types_crud() {
		return $this->_user_types_crud;
	}
	
	/**
	* sets the value of user_types_crud
	*/
	public function set_user_types_crud($user_types_crud) {
		$this->_user_types_crud = user_types_crud;
	}
	

		
		
	/**
	* Performs a database query and returns the value of id_permission_group 
	* based on the value of $permission_group_crud,$land_owners_crud,$title_deeds_crud,$title_deed_comments_crud,$title_deed_natures_crud,$title_deed_easements_crud,$title_deed_proprietorship_crud,$system_users_crud,$user_types_crud passed to the function
	*/
	public function get_id_permission_group($permission_group_crud,$land_owners_crud,$title_deeds_crud,$title_deed_comments_crud,$title_deed_natures_crud,$title_deed_easements_crud,$title_deed_proprietorship_crud,$system_users_crud,$user_types_crud) {
		$columns = array ('permission_group_crud','land_owners_crud','title_deeds_crud','title_deed_comments_crud','title_deed_natures_crud','title_deed_easements_crud','title_deed_proprietorship_crud','system_users_crud','user_types_crud');
		$records = array ($permission_group_crud,$land_owners_crud,$title_deeds_crud,$title_deed_comments_crud,$title_deed_natures_crud,$title_deed_easements_crud,$title_deed_proprietorship_crud,$system_users_crud,$user_types_crud);
		$id_permission_group_ = $this->query_from_permission_groups ( $columns, $records );
		return count($id_permission_group_)>0 ? $id_permission_group_ [0] ['id_permission_group'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of permission_group_crud 
	* based on the value of $id_permission_group passed to the function
	*/
	public function get_permission_group_crud($id_permission_group) {
		$columns = array ('id_permission_group');
		$records = array ($id_permission_group);
		$permission_group_crud_ = $this->query_from_permission_groups ( $columns, $records );
		return count($permission_group_crud_)>0 ? $permission_group_crud_ [0] ['permission_group_crud'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of land_owners_crud 
	* based on the value of $id_permission_group passed to the function
	*/
	public function get_land_owners_crud($id_permission_group) {
		$columns = array ('id_permission_group');
		$records = array ($id_permission_group);
		$land_owners_crud_ = $this->query_from_permission_groups ( $columns, $records );
		return count($land_owners_crud_)>0 ? $land_owners_crud_ [0] ['land_owners_crud'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of title_deeds_crud 
	* based on the value of $id_permission_group passed to the function
	*/
	public function get_title_deeds_crud($id_permission_group) {
		$columns = array ('id_permission_group');
		$records = array ($id_permission_group);
		$title_deeds_crud_ = $this->query_from_permission_groups ( $columns, $records );
		return count($title_deeds_crud_)>0 ? $title_deeds_crud_ [0] ['title_deeds_crud'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of title_deed_comments_crud 
	* based on the value of $id_permission_group passed to the function
	*/
	public function get_title_deed_comments_crud($id_permission_group) {
		$columns = array ('id_permission_group');
		$records = array ($id_permission_group);
		$title_deed_comments_crud_ = $this->query_from_permission_groups ( $columns, $records );
		return count($title_deed_comments_crud_)>0 ? $title_deed_comments_crud_ [0] ['title_deed_comments_crud'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of title_deed_natures_crud 
	* based on the value of $id_permission_group passed to the function
	*/
	public function get_title_deed_natures_crud($id_permission_group) {
		$columns = array ('id_permission_group');
		$records = array ($id_permission_group);
		$title_deed_natures_crud_ = $this->query_from_permission_groups ( $columns, $records );
		return count($title_deed_natures_crud_)>0 ? $title_deed_natures_crud_ [0] ['title_deed_natures_crud'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of title_deed_easements_crud 
	* based on the value of $id_permission_group passed to the function
	*/
	public function get_title_deed_easements_crud($id_permission_group) {
		$columns = array ('id_permission_group');
		$records = array ($id_permission_group);
		$title_deed_easements_crud_ = $this->query_from_permission_groups ( $columns, $records );
		return count($title_deed_easements_crud_)>0 ? $title_deed_easements_crud_ [0] ['title_deed_easements_crud'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of title_deed_proprietorship_crud 
	* based on the value of $id_permission_group passed to the function
	*/
	public function get_title_deed_proprietorship_crud($id_permission_group) {
		$columns = array ('id_permission_group');
		$records = array ($id_permission_group);
		$title_deed_proprietorship_crud_ = $this->query_from_permission_groups ( $columns, $records );
		return count($title_deed_proprietorship_crud_)>0 ? $title_deed_proprietorship_crud_ [0] ['title_deed_proprietorship_crud'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of system_users_crud 
	* based on the value of $id_permission_group passed to the function
	*/
	public function get_system_users_crud($id_permission_group) {
		$columns = array ('id_permission_group');
		$records = array ($id_permission_group);
		$system_users_crud_ = $this->query_from_permission_groups ( $columns, $records );
		return count($system_users_crud_)>0 ? $system_users_crud_ [0] ['system_users_crud'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of user_types_crud 
	* based on the value of $id_permission_group passed to the function
	*/
	public function get_user_types_crud($id_permission_group) {
		$columns = array ('id_permission_group');
		$records = array ($id_permission_group);
		$user_types_crud_ = $this->query_from_permission_groups ( $columns, $records );
		return count($user_types_crud_)>0 ? $user_types_crud_ [0] ['user_types_crud'] : null;
	}
	

	
	/**
	* Inserts data into the table[permission_groups] in the order below
	* array ('permission_group_crud','land_owners_crud','title_deeds_crud','title_deed_comments_crud','title_deed_natures_crud','title_deed_easements_crud','title_deed_proprietorship_crud','system_users_crud','user_types_crud')
	* is mappped into 
	* array ($permission_group_crud,$land_owners_crud,$title_deeds_crud,$title_deed_comments_crud,$title_deed_natures_crud,$title_deed_easements_crud,$title_deed_proprietorship_crud,$system_users_crud,$user_types_crud)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert_prepared_records($permission_group_crud,$land_owners_crud,$title_deeds_crud,$title_deed_comments_crud,$title_deed_natures_crud,$title_deed_easements_crud,$title_deed_proprietorship_crud,$system_users_crud,$user_types_crud,$redundancy_check= false, $printSQL = false) {
		$columns = array('permission_group_crud','land_owners_crud','title_deeds_crud','title_deed_comments_crud','title_deed_natures_crud','title_deed_easements_crud','title_deed_proprietorship_crud','system_users_crud','user_types_crud');
		$records = array($permission_group_crud,$land_owners_crud,$title_deeds_crud,$title_deed_comments_crud,$title_deed_natures_crud,$title_deed_easements_crud,$title_deed_proprietorship_crud,$system_users_crud,$user_types_crud);
		return $this->insert_records_to_permission_groups ( $columns, $records,$redundancy_check, $printSQL );
	}

	
	/**
	* Returns the table name. This is the owner of these crud functions.
	* The various crud functions directly affect this table
	* @return Table Name [permission_groups] 
	*/
	public static function get_table() {
		return 'permission_groups';
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
	* Used  to calculate the number of times a record exists in the table [permission_groups]
	*
	* @return the number of times a record exists exists in the table [permission_groups]
	*/
	public function is_exists(Array $columns, Array $records, $printSQL = false) {
		return $this->get_database_utils ()->is_exists ( $this->get_table (), $columns, $records, $printSQL );
	}
	
	/**
	* Inserts data into the table[permission_groups]
	*
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert_records_to_permission_groups(Array $columns, Array $records,$redundancy_check = false, $printSQL = false) {
		return $this->insert_records ( $this->get_table (), $columns, $records,$redundancy_check, $printSQL );
	}
	
	/**
	* Deletes all the records that meets the passed criteria from the table [permission_groups]
	*  
	* @return number of deleted rows
	*/
	public function delete_record_from_permission_groups(Array $columns, Array $records, $printSQL = false) {
		return $this->delete_record ( $this->get_table (), $columns, $records, $printSQL );
	}
	
	/**
	* updates all the records that meets the passed criteria from the table [permission_groups]
	*  
	* @return number of updated rows
	*/
	public function update_record_in_permission_groups(Array $columns, Array $records, Array $where_columns, Array $where_records, $printSQL = false) {
		return $this->update_record ( $this->get_table (), $columns, $records, $where_columns, $where_records, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [permission_groups] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function fetch_assoc_in_permission_groups($distinct, Array $columns, Array $records, $extraSQL="", $printSQL = false) {
		return $this->fetch_assoc ( $distinct, $this->get_table (),$columns, $records, $extraSQL , $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [permission_groups] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_from_permission_groups(Array $columns, Array $records,$extraSQL="",  $printSQL = false) {
		return $this->query ( $this->get_table (), $columns, $records,$extraSQL,$printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [permission_groups] that meets the passed distinct criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_distinct_from_permission_groups(Array $columns, Array $records,$extraSQL="",  $printSQL = false) {
		return $this->query_distinct ( $this->get_table (), $columns, $records,$extraSQL,$printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [permission_groups] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function search_in_permission_groups(Array $columns, Array $records,$extraSQL="", $printSQL = false) {
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
	* Deletes all the records that meets the passed criteria from the table [permission_groups]
	*  
	* @return number of deleted rows
	*/
	private function delete_record($table, Array $columns, Array $records, $printSQL = false) {
		return $this->get_database_utils ()->delete_record ( $table, $columns, $records, $printSQL );
	}
	
	
	/**
	* Inserts data into the table[permission_groups]
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
	* updates all the records that meets the passed criteria from the table [permission_groups]
	*  
	* @return number of updated rows
	*/
	private function update_record($table, Array $columns, Array $records, Array $where_columns, Array $where_records, $printSQL = false) {
		return $this->get_database_utils ()->update_record ( $table, $columns, $records, $where_columns, $where_records, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [permission_groups] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	private function fetch_assoc($distinct, $table, Array $columns, Array $records, $extraSQL="", $printSQL = false) {
		return $this->get_database_utils ()->fetch_assoc ( $distinct, $table, $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [permission_groups] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query($table, Array $columns, Array $records,$extraSQL="",$printSQL = false) {
		return $this->get_database_utils ()->query ( $table, $columns, $records,$extraSQL, $printSQL );
	}
	/**
	* Gets an Associative array of the records in the table [permission_groups] that meets the distinct passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_distinct($table, Array $columns, Array $records,$extraSQL="",$printSQL = false) {
		return $this->get_database_utils ()->query_distinct ( $table, $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [permission_groups] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	private function search($table, Array $columns, Array $records,$extraSQL="", $printSQL = false) {
		return $this->get_database_utils ()->search ( $table, $columns, $records, $extraSQL, $printSQL );
	}
}
?>
