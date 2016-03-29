<?php class WardsInfo{

	private $build;
	private $client;
	private $action;
	private $wards;
	private $table = 'wards';
	/**
	 * WardsInfo
	 * 
	 * Class to get all the wards Information from the wards table 
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

		include 'C:\xampp\htdocs\titledeeds\scripts\php\database\crud\Wards.class.php';
		
		$this->wards = new $TABLE_CLASS( $action, $client );

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
	* Inserts data into the table[wards] in the order below
	* array ('id_county','ward_name','ward_headquarters','trashed','deleted','first_created','last_modified')
	* is mappped into 
	* array ($id_county,$ward_name,$ward_headquarters,$trashed,$deleted,$first_created,$last_modified)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert($id_county,$ward_name,$ward_headquarters,$trashed,$deleted,$first_created,$last_modified,$redundancy_check= false, $printSQL = false) {
		$columns = array('id_county','ward_name','ward_headquarters','trashed','deleted','first_created','last_modified');
		$records = array($$id_county,$ward_name,$ward_headquarters,$trashed,$deleted,$first_created,$last_modified);
		return $this->wards->insert_prepared_records($$id_county,$ward_name,$ward_headquarters,$trashed,$deleted,$first_created,$last_modified,$redundancy_check,$printSQL );
	}


	public function query($distinct,$extraSQL=""){

		$columns = $records = array ();
		$queried_wards = $this->wards->fetch_assoc_in_wards ($distinct, $columns, $records,$extraSQL );

		if($this->build = ENG_BUILD){
			return $this->query_eng_build($queried_wards);
		}
		if($this->build = USER_BUILD){
			return $this->query_user_build($queried_wards);
		}
	}

	public function query_eng_build($queried_wards){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_wards);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_wards);
		}
	}
	public function query_user_build(){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_wards);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_wards);
		}
	}
	private function export_query_json($queried_wards){
		$query_json = json_encode($queried_wards);
		return $query_json;
	}
	private function export_query_html($queried_wards){
		$query_html = "";
		foreach ( $queried_wards as $wards_row_items ) {
			$query_html .= $this->process_query_for_html_export ( $wards_row_items );
		}
		return $query_html;
	}

	private function process_query_for_html_export ( $wards_row_items ){
		$html_export ='<div style="padding:10px;margin:10px;border:2px solid black;"><h3>'  .$this->table.  '</h3>';
		
		$id_county = $wards_row_items ['id_county'];
	if ($id_county  != null) {
	$html_export .= $this->parseHtmlExport ( 'id_county', $id_county  );
}
$ward_name = $wards_row_items ['ward_name'];
	if ($ward_name  != null) {
	$html_export .= $this->parseHtmlExport ( 'ward_name', $ward_name  );
}
$ward_headquarters = $wards_row_items ['ward_headquarters'];
	if ($ward_headquarters  != null) {
	$html_export .= $this->parseHtmlExport ( 'ward_headquarters', $ward_headquarters  );
}
$trashed = $wards_row_items ['trashed'];
	if ($trashed  != null) {
	$html_export .= $this->parseHtmlExport ( 'trashed', $trashed  );
}
$deleted = $wards_row_items ['deleted'];
	if ($deleted  != null) {
	$html_export .= $this->parseHtmlExport ( 'deleted', $deleted  );
}
$first_created = $wards_row_items ['first_created'];
	if ($first_created  != null) {
	$html_export .= $this->parseHtmlExport ( 'first_created', $first_created  );
}
$last_modified = $wards_row_items ['last_modified'];
	if ($last_modified  != null) {
	$html_export .= $this->parseHtmlExport ( 'last_modified', $last_modified  );
}

		
		return $html_export .='</div>';
	}

	private function parseHtmlExport($title,$message){
		return '<div style="width:400px;"><h4>' . $title . '</h4><hr /><p>' . $message . '</p></div>';
	}
} ?>
