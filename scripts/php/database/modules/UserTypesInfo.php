<?php class UserTypesInfo{

	private $build;
	private $client;
	private $action;
	private $user_types;
	private $table = 'user_types';
	/**
	 * UserTypesInfo
	 * 
	 * Class to get all the user_types Information from the user_types table 
	 * @param String $action
	 * @param String $client
	 * @param String $build
	 * 
	 * @author Victor Mwenda
	 * Email : vmwenda.vm@gmail.com
	 * Phone : +254718034449
	 */
	public function __construct($action, $client,$build) {

		$this->client = $client;
		$this->action = $action;
		$this->build = $build;

		include 'C:\xampp\htdocs\titledeeds\scripts\php\database\crud\UserTypes.class.php';
		
		$this->user_types = new $TABLE_CLASS( $action, $client );

	}

	public function init(){

		if($this->action == ACTION_INSERT){
				
		}
		if($this->action == ACTION_QUERY){
			return $this->query();
		}
		if($this->action == ACTION_UPDATE){
				
		}
		if($this->action == ACTION_DELETE){
				
		}

	}

		/**
	* Inserts data into the table[user_types] in the order below
	* array ('id_persmission_group','posted_time')
	* is mappped into 
	* array ($id_persmission_group,$posted_time)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert($id_persmission_group,$posted_time,$redundancy_check= false, $printSQL = false) {
		$columns = array('id_persmission_group','posted_time');
		$records = array($$id_persmission_group,$posted_time);
		return $this->user_types->insert_prepared_records($$id_persmission_group,$posted_time,$redundancy_check,$printSQL );
	}


	public function query($distinct,$extraSQL=""){

		$columns = $records = array ();
		$queried_user_types = $this->user_types->fetch_assoc_in_user_types ($distinct, $columns, $records,$extraSQL );

		if($this->build = ENG_BUILD){
			return $this->query_eng_build($queried_user_types);
		}
		if($this->build = USER_BUILD){
			return $this->query_user_build($queried_user_types);
		}
	}

	public function query_eng_build($queried_user_types){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_user_types);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_user_types);
		}
	}
	public function query_user_build(){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_user_types);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_user_types);
		}
	}
	private function export_query_json($queried_user_types){
		$query_json = json_encode($queried_user_types);
		return $query_json;
	}
	private function export_query_html($queried_user_types){
		$query_html = "";
		foreach ( $queried_user_types as $user_types_row_items ) {
			$query_html .= $this->process_query_for_html_export ( $user_types_row_items );
		}
		return $query_html;
	}

	private function process_query_for_html_export ( $user_types_row_items ){
		$html_export ='<div style="padding:10px;margin:10px;border:2px solid black;"><h3>'  .$this->table.  '</h3>';
		
		$id_persmission_group = $user_types_row_items ['id_persmission_group'];
	if ($id_persmission_group  != null) {
	$html_export .= $this->parseHtmlExport ( 'id_persmission_group', $id_persmission_group  );
}
$posted_time = $user_types_row_items ['posted_time'];
	if ($posted_time  != null) {
	$html_export .= $this->parseHtmlExport ( 'posted_time', $posted_time  );
}

		
		return $html_export .='</div>';
	}

	private function parseHtmlExport($title,$message){
		return '<div style="width:400px;"><h4>' . $title . '</h4><hr /><p>' . $message . '</p></div>';
	}
} ?>
