<?php class LocationInfo{

	private $build;
	private $client;
	private $action;
	private $location;
	private $table = 'location';
	/**
	 * LocationInfo
	 * 
	 * Class to get all the location Information from the location table 
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

		include 'C:\xampp\htdocs\titledeeds\scripts\php\database\crud\Location.class.php';
		
		$this->location = new $TABLE_CLASS( $action, $client );

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
	* Inserts data into the table[location] in the order below
	* array ('id_division','sublocation_name','location_headquarters','trashed','deleted','first_created','last_modified')
	* is mappped into 
	* array ($id_division,$sublocation_name,$location_headquarters,$trashed,$deleted,$first_created,$last_modified)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert($id_division,$sublocation_name,$location_headquarters,$trashed,$deleted,$first_created,$last_modified,$redundancy_check= false, $printSQL = false) {
		$columns = array('id_division','sublocation_name','location_headquarters','trashed','deleted','first_created','last_modified');
		$records = array($$id_division,$sublocation_name,$location_headquarters,$trashed,$deleted,$first_created,$last_modified);
		return $this->location->insert_prepared_records($$id_division,$sublocation_name,$location_headquarters,$trashed,$deleted,$first_created,$last_modified,$redundancy_check,$printSQL );
	}


	public function query($distinct,$extraSQL=""){

		$columns = $records = array ();
		$queried_location = $this->location->fetch_assoc_in_location ($distinct, $columns, $records,$extraSQL );

		if($this->build = ENG_BUILD){
			return $this->query_eng_build($queried_location);
		}
		if($this->build = USER_BUILD){
			return $this->query_user_build($queried_location);
		}
	}

	public function query_eng_build($queried_location){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_location);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_location);
		}
	}
	public function query_user_build(){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_location);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_location);
		}
	}
	private function export_query_json($queried_location){
		$query_json = json_encode($queried_location);
		return $query_json;
	}
	private function export_query_html($queried_location){
		$query_html = "";
		foreach ( $queried_location as $location_row_items ) {
			$query_html .= $this->process_query_for_html_export ( $location_row_items );
		}
		return $query_html;
	}

	private function process_query_for_html_export ( $location_row_items ){
		$html_export ='<div style="padding:10px;margin:10px;border:2px solid black;"><h3>'  .$this->table.  '</h3>';
		
		$id_division = $location_row_items ['id_division'];
	if ($id_division  != null) {
	$html_export .= $this->parseHtmlExport ( 'id_division', $id_division  );
}
$sublocation_name = $location_row_items ['sublocation_name'];
	if ($sublocation_name  != null) {
	$html_export .= $this->parseHtmlExport ( 'sublocation_name', $sublocation_name  );
}
$location_headquarters = $location_row_items ['location_headquarters'];
	if ($location_headquarters  != null) {
	$html_export .= $this->parseHtmlExport ( 'location_headquarters', $location_headquarters  );
}
$trashed = $location_row_items ['trashed'];
	if ($trashed  != null) {
	$html_export .= $this->parseHtmlExport ( 'trashed', $trashed  );
}
$deleted = $location_row_items ['deleted'];
	if ($deleted  != null) {
	$html_export .= $this->parseHtmlExport ( 'deleted', $deleted  );
}
$first_created = $location_row_items ['first_created'];
	if ($first_created  != null) {
	$html_export .= $this->parseHtmlExport ( 'first_created', $first_created  );
}
$last_modified = $location_row_items ['last_modified'];
	if ($last_modified  != null) {
	$html_export .= $this->parseHtmlExport ( 'last_modified', $last_modified  );
}

		
		return $html_export .='</div>';
	}

	private function parseHtmlExport($title,$message){
		return '<div style="width:400px;"><h4>' . $title . '</h4><hr /><p>' . $message . '</p></div>';
	}
} ?>
