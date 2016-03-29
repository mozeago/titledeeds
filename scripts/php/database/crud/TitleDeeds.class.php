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

	
class TitleDeeds {

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
	* private class variable approximate_area
	*/
	private $_approximate_area;
	
	/**
	* returns the value of approximate_area
	*/
	public function _get_approximate_area() {
		return $this->_approximate_area;
	}
	
	/**
	* sets the value of approximate_area
	*/
	public function set_approximate_area($approximate_area) {
		$this->_approximate_area = approximate_area;
	}
	
	
	/**
	* private class variable land_owner
	*/
	private $_land_owner;
	
	/**
	* returns the value of land_owner
	*/
	public function _get_land_owner() {
		return $this->_land_owner;
	}
	
	/**
	* sets the value of land_owner
	*/
	public function set_land_owner($land_owner) {
		$this->_land_owner = land_owner;
	}
	
	
	/**
	* private class variable edition
	*/
	private $_edition;
	
	/**
	* returns the value of edition
	*/
	public function _get_edition() {
		return $this->_edition;
	}
	
	/**
	* sets the value of edition
	*/
	public function set_edition($edition) {
		$this->_edition = edition;
	}
	
	
	/**
	* private class variable opened
	*/
	private $_opened;
	
	/**
	* returns the value of opened
	*/
	public function _get_opened() {
		return $this->_opened;
	}
	
	/**
	* sets the value of opened
	*/
	public function set_opened($opened) {
		$this->_opened = opened;
	}
	
	
	/**
	* private class variable registration_section
	*/
	private $_registration_section;
	
	/**
	* returns the value of registration_section
	*/
	public function _get_registration_section() {
		return $this->_registration_section;
	}
	
	/**
	* sets the value of registration_section
	*/
	public function set_registration_section($registration_section) {
		$this->_registration_section = registration_section;
	}
	
	
	/**
	* private class variable parcel_number
	*/
	private $_parcel_number;
	
	/**
	* returns the value of parcel_number
	*/
	public function _get_parcel_number() {
		return $this->_parcel_number;
	}
	
	/**
	* sets the value of parcel_number
	*/
	public function set_parcel_number($parcel_number) {
		$this->_parcel_number = parcel_number;
	}
	
	
	/**
	* private class variable plot_number
	*/
	private $_plot_number;
	
	/**
	* returns the value of plot_number
	*/
	public function _get_plot_number() {
		return $this->_plot_number;
	}
	
	/**
	* sets the value of plot_number
	*/
	public function set_plot_number($plot_number) {
		$this->_plot_number = plot_number;
	}
	
	
	/**
	* private class variable registy_map_sheet_number
	*/
	private $_registy_map_sheet_number;
	
	/**
	* returns the value of registy_map_sheet_number
	*/
	public function _get_registy_map_sheet_number() {
		return $this->_registy_map_sheet_number;
	}
	
	/**
	* sets the value of registy_map_sheet_number
	*/
	public function set_registy_map_sheet_number($registy_map_sheet_number) {
		$this->_registy_map_sheet_number = registy_map_sheet_number;
	}
	

		
		
	/**
	* Performs a database query and returns the value of id_title_deed 
	* based on the value of $approximate_area,$land_owner,$edition,$opened,$registration_section,$parcel_number,$plot_number,$registy_map_sheet_number passed to the function
	*/
	public function get_id_title_deed($approximate_area,$land_owner,$edition,$opened,$registration_section,$parcel_number,$plot_number,$registy_map_sheet_number) {
		$columns = array ('approximate_area','land_owner','edition','opened','registration_section','parcel_number','plot_number','registy_map_sheet_number');
		$records = array ($approximate_area,$land_owner,$edition,$opened,$registration_section,$parcel_number,$plot_number,$registy_map_sheet_number);
		$id_title_deed_ = $this->query_from_title_deeds ( $columns, $records );
		return count($id_title_deed_)>0 ? $id_title_deed_ [0] ['id_title_deed'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of approximate_area 
	* based on the value of $id_title_deed passed to the function
	*/
	public function get_approximate_area($id_title_deed) {
		$columns = array ('id_title_deed');
		$records = array ($id_title_deed);
		$approximate_area_ = $this->query_from_title_deeds ( $columns, $records );
		return count($approximate_area_)>0 ? $approximate_area_ [0] ['approximate_area'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of land_owner 
	* based on the value of $id_title_deed passed to the function
	*/
	public function get_land_owner($id_title_deed) {
		$columns = array ('id_title_deed');
		$records = array ($id_title_deed);
		$land_owner_ = $this->query_from_title_deeds ( $columns, $records );
		return count($land_owner_)>0 ? $land_owner_ [0] ['land_owner'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of edition 
	* based on the value of $id_title_deed passed to the function
	*/
	public function get_edition($id_title_deed) {
		$columns = array ('id_title_deed');
		$records = array ($id_title_deed);
		$edition_ = $this->query_from_title_deeds ( $columns, $records );
		return count($edition_)>0 ? $edition_ [0] ['edition'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of opened 
	* based on the value of $id_title_deed passed to the function
	*/
	public function get_opened($id_title_deed) {
		$columns = array ('id_title_deed');
		$records = array ($id_title_deed);
		$opened_ = $this->query_from_title_deeds ( $columns, $records );
		return count($opened_)>0 ? $opened_ [0] ['opened'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of registration_section 
	* based on the value of $id_title_deed passed to the function
	*/
	public function get_registration_section($id_title_deed) {
		$columns = array ('id_title_deed');
		$records = array ($id_title_deed);
		$registration_section_ = $this->query_from_title_deeds ( $columns, $records );
		return count($registration_section_)>0 ? $registration_section_ [0] ['registration_section'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of parcel_number 
	* based on the value of $id_title_deed passed to the function
	*/
	public function get_parcel_number($id_title_deed) {
		$columns = array ('id_title_deed');
		$records = array ($id_title_deed);
		$parcel_number_ = $this->query_from_title_deeds ( $columns, $records );
		return count($parcel_number_)>0 ? $parcel_number_ [0] ['parcel_number'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of plot_number 
	* based on the value of $id_title_deed passed to the function
	*/
	public function get_plot_number($id_title_deed) {
		$columns = array ('id_title_deed');
		$records = array ($id_title_deed);
		$plot_number_ = $this->query_from_title_deeds ( $columns, $records );
		return count($plot_number_)>0 ? $plot_number_ [0] ['plot_number'] : null;
	}
	
	
	/**
	* Performs a database query and returns the value of registy_map_sheet_number 
	* based on the value of $id_title_deed passed to the function
	*/
	public function get_registy_map_sheet_number($id_title_deed) {
		$columns = array ('id_title_deed');
		$records = array ($id_title_deed);
		$registy_map_sheet_number_ = $this->query_from_title_deeds ( $columns, $records );
		return count($registy_map_sheet_number_)>0 ? $registy_map_sheet_number_ [0] ['registy_map_sheet_number'] : null;
	}
	

	
	/**
	* Inserts data into the table[title_deeds] in the order below
	* array ('approximate_area','land_owner','edition','opened','registration_section','parcel_number','plot_number','registy_map_sheet_number')
	* is mappped into 
	* array ($approximate_area,$land_owner,$edition,$opened,$registration_section,$parcel_number,$plot_number,$registy_map_sheet_number)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert_prepared_records($approximate_area,$land_owner,$edition,$opened,$registration_section,$parcel_number,$plot_number,$registy_map_sheet_number,$redundancy_check= false, $printSQL = false) {
		$columns = array('approximate_area','land_owner','edition','opened','registration_section','parcel_number','plot_number','registy_map_sheet_number');
		$records = array($approximate_area,$land_owner,$edition,$opened,$registration_section,$parcel_number,$plot_number,$registy_map_sheet_number);
		return $this->insert_records_to_title_deeds ( $columns, $records,$redundancy_check, $printSQL );
	}

	
	/**
	* Returns the table name. This is the owner of these crud functions.
	* The various crud functions directly affect this table
	* @return Table Name [title_deeds] 
	*/
	public static function get_table() {
		return 'title_deeds';
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
	* Used  to calculate the number of times a record exists in the table [title_deeds]
	*
	* @return the number of times a record exists exists in the table [title_deeds]
	*/
	public function is_exists(Array $columns, Array $records, $printSQL = false) {
		return $this->get_database_utils ()->is_exists ( $this->get_table (), $columns, $records, $printSQL );
	}
	
	/**
	* Inserts data into the table[title_deeds]
	*
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert_records_to_title_deeds(Array $columns, Array $records,$redundancy_check = false, $printSQL = false) {
		return $this->insert_records ( $this->get_table (), $columns, $records,$redundancy_check, $printSQL );
	}
	
	/**
	* Deletes all the records that meets the passed criteria from the table [title_deeds]
	*  
	* @return number of deleted rows
	*/
	public function delete_record_from_title_deeds(Array $columns, Array $records, $printSQL = false) {
		return $this->delete_record ( $this->get_table (), $columns, $records, $printSQL );
	}
	
	/**
	* updates all the records that meets the passed criteria from the table [title_deeds]
	*  
	* @return number of updated rows
	*/
	public function update_record_in_title_deeds(Array $columns, Array $records, Array $where_columns, Array $where_records, $printSQL = false) {
		return $this->update_record ( $this->get_table (), $columns, $records, $where_columns, $where_records, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [title_deeds] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function fetch_assoc_in_title_deeds($distinct, Array $columns, Array $records, $extraSQL="", $printSQL = false) {
		return $this->fetch_assoc ( $distinct, $this->get_table (),$columns, $records, $extraSQL , $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [title_deeds] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_from_title_deeds(Array $columns, Array $records,$extraSQL="",  $printSQL = false) {
		return $this->query ( $this->get_table (), $columns, $records,$extraSQL,$printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [title_deeds] that meets the passed distinct criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_distinct_from_title_deeds(Array $columns, Array $records,$extraSQL="",  $printSQL = false) {
		return $this->query_distinct ( $this->get_table (), $columns, $records,$extraSQL,$printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [title_deeds] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function search_in_title_deeds(Array $columns, Array $records,$extraSQL="", $printSQL = false) {
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
	* Deletes all the records that meets the passed criteria from the table [title_deeds]
	*  
	* @return number of deleted rows
	*/
	private function delete_record($table, Array $columns, Array $records, $printSQL = false) {
		return $this->get_database_utils ()->delete_record ( $table, $columns, $records, $printSQL );
	}
	
	
	/**
	* Inserts data into the table[title_deeds]
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
	* updates all the records that meets the passed criteria from the table [title_deeds]
	*  
	* @return number of updated rows
	*/
	private function update_record($table, Array $columns, Array $records, Array $where_columns, Array $where_records, $printSQL = false) {
		return $this->get_database_utils ()->update_record ( $table, $columns, $records, $where_columns, $where_records, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [title_deeds] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	private function fetch_assoc($distinct, $table, Array $columns, Array $records, $extraSQL="", $printSQL = false) {
		return $this->get_database_utils ()->fetch_assoc ( $distinct, $table, $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [title_deeds] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query($table, Array $columns, Array $records,$extraSQL="",$printSQL = false) {
		return $this->get_database_utils ()->query ( $table, $columns, $records,$extraSQL, $printSQL );
	}
	/**
	* Gets an Associative array of the records in the table [title_deeds] that meets the distinct passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	public function query_distinct($table, Array $columns, Array $records,$extraSQL="",$printSQL = false) {
		return $this->get_database_utils ()->query_distinct ( $table, $columns, $records,$extraSQL, $printSQL );
	}
	
	/**
	* Gets an Associative array of the records in the table [title_deeds] that meets the passed criteria
	*  
	* @return associative array of the records that are found after performing the query
	*/
	private function search($table, Array $columns, Array $records,$extraSQL="", $printSQL = false) {
		return $this->get_database_utils ()->search ( $table, $columns, $records, $extraSQL, $printSQL );
	}
}
?>
