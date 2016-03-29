<?php class SublocationInfo{

	private $build;
	private $client;
	private $action;
	private $sublocation;
	private $table = 'sublocation';
	/**
	 * SublocationInfo
	 * 
	 * Class to get all the sublocation Information from the sublocation table 
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

		include 'C:\xampp\htdocs\titledeeds\scripts\php\database\crud\Sublocation.class.php';
		
		$this->sublocation = new $TABLE_CLASS( $action, $client );

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
	* Inserts data into the table[sublocation] in the order below
	* array ('id_location','sublocation_name','sub_location_headquarters','trashed','deleted','first_created','last_modified')
	* is mappped into 
	* array ($id_location,$sublocation_name,$sub_location_headquarters,$trashed,$deleted,$first_created,$last_modified)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert($id_location,$sublocation_name,$sub_location_headquarters,$trashed,$deleted,$first_created,$last_modified,$redundancy_check= false, $printSQL = false) {
		$columns = array('id_location','sublocation_name','sub_location_headquarters','trashed','deleted','first_created','last_modified');
		$records = array($$id_location,$sublocation_name,$sub_location_headquarters,$trashed,$deleted,$first_created,$last_modified);
		return $this->sublocation->insert_prepared_records($$id_location,$sublocation_name,$sub_location_headquarters,$trashed,$deleted,$first_created,$last_modified,$redundancy_check,$printSQL );
	}


	public function query($distinct,$extraSQL=""){

		$columns = $records = array ();
		$queried_sublocation = $this->sublocation->fetch_assoc_in_sublocation ($distinct, $columns, $records,$extraSQL );

		if($this->build = ENG_BUILD){
			return $this->query_eng_build($queried_sublocation);
		}
		if($this->build = USER_BUILD){
			return $this->query_user_build($queried_sublocation);
		}
	}

	public function query_eng_build($queried_sublocation){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_sublocation);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_sublocation);
		}
	}
	public function query_user_build(){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_sublocation);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_sublocation);
		}
	}
	private function export_query_json($queried_sublocation){
		$query_json = json_encode($queried_sublocation);
		return $query_json;
	}
	private function export_query_html($queried_sublocation){
		$query_html = "";
		foreach ( $queried_sublocation as $sublocation_row_items ) {
			$query_html .= $this->process_query_for_html_export ( $sublocation_row_items );
		}
		return $query_html;
	}

	private function process_query_for_html_export ( $sublocation_row_items ){
		$html_export ='<div style="padding:10px;margin:10px;border:2px solid black;"><h3>'  .$this->table.  '</h3>';
		
		$id_location = $sublocation_row_items ['id_location'];
	if ($id_location  != null) {
	$html_export .= $this->parseHtmlExport ( 'id_location', $id_location  );
}
$sublocation_name = $sublocation_row_items ['sublocation_name'];
	if ($sublocation_name  != null) {
	$html_export .= $this->parseHtmlExport ( 'sublocation_name', $sublocation_name  );
}
$sub_location_headquarters = $sublocation_row_items ['sub_location_headquarters'];
	if ($sub_location_headquarters  != null) {
	$html_export .= $this->parseHtmlExport ( 'sub_location_headquarters', $sub_location_headquarters  );
}
$trashed = $sublocation_row_items ['trashed'];
	if ($trashed  != null) {
	$html_export .= $this->parseHtmlExport ( 'trashed', $trashed  );
}
$deleted = $sublocation_row_items ['deleted'];
	if ($deleted  != null) {
	$html_export .= $this->parseHtmlExport ( 'deleted', $deleted  );
}
$first_created = $sublocation_row_items ['first_created'];
	if ($first_created  != null) {
	$html_export .= $this->parseHtmlExport ( 'first_created', $first_created  );
}
$last_modified = $sublocation_row_items ['last_modified'];
	if ($last_modified  != null) {
	$html_export .= $this->parseHtmlExport ( 'last_modified', $last_modified  );
}

		
		return $html_export .='</div>';
	}

	private function parseHtmlExport($title,$message){
		return '<div style="width:400px;"><h4>' . $title . '</h4><hr /><p>' . $message . '</p></div>';
	}
} ?>
