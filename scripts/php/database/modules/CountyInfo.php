<?php class CountyInfo{

	private $build;
	private $client;
	private $action;
	private $county;
	private $table = 'county';
	/**
	 * CountyInfo
	 * 
	 * Class to get all the county Information from the county table 
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

		include 'C:\xampp\htdocs\titledeeds\scripts\php\database\crud\County.class.php';
		
		$this->county = new $TABLE_CLASS( $action, $client );

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
	* Inserts data into the table[county] in the order below
	* array ('county_name','county_headquarters','trashed','deleted','first_created','last_modified')
	* is mappped into 
	* array ($county_name,$county_headquarters,$trashed,$deleted,$first_created,$last_modified)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert($county_name,$county_headquarters,$trashed,$deleted,$first_created,$last_modified,$redundancy_check= false, $printSQL = false) {
		$columns = array('county_name','county_headquarters','trashed','deleted','first_created','last_modified');
		$records = array($$county_name,$county_headquarters,$trashed,$deleted,$first_created,$last_modified);
		return $this->county->insert_prepared_records($$county_name,$county_headquarters,$trashed,$deleted,$first_created,$last_modified,$redundancy_check,$printSQL );
	}


	public function query(){

		$columns = $records = array ();
		$queried_county = $this->county->fetch_assoc_in_county ( $columns, $records );

		if($this->build = ENG_BUILD){
			return $this->query_eng_build($queried_county);
		}
		if($this->build = USER_BUILD){
			return $this->query_user_build($queried_county);
		}
	}

	public function query_eng_build($queried_county){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_county);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_county);
		}
	}
	public function query_user_build(){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_county);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_county);
		}
	}
	private function export_query_json($queried_county){
		$query_json = json_encode($queried_county);
		return $query_json;
	}
	private function export_query_html($queried_county){
		$query_html = "";
		foreach ( $queried_county as $county_row_items ) {
			$query_html .= $this->process_query_for_html_export ( $county_row_items );
		}
		return $query_html;
	}

	private function process_query_for_html_export ( $county_row_items ){
		$html_export ='<div style="padding:10px;margin:10px;border:2px solid black;"><h3>'  .$this->table.  '</h3>';
		
		$county_name = $county_row_items ['county_name'];
	if ($county_name  != null) {
	$html_export .= $this->parseHtmlExport ( 'county_name', $county_name  );
}
$county_headquarters = $county_row_items ['county_headquarters'];
	if ($county_headquarters  != null) {
	$html_export .= $this->parseHtmlExport ( 'county_headquarters', $county_headquarters  );
}
$trashed = $county_row_items ['trashed'];
	if ($trashed  != null) {
	$html_export .= $this->parseHtmlExport ( 'trashed', $trashed  );
}
$deleted = $county_row_items ['deleted'];
	if ($deleted  != null) {
	$html_export .= $this->parseHtmlExport ( 'deleted', $deleted  );
}
$first_created = $county_row_items ['first_created'];
	if ($first_created  != null) {
	$html_export .= $this->parseHtmlExport ( 'first_created', $first_created  );
}
$last_modified = $county_row_items ['last_modified'];
	if ($last_modified  != null) {
	$html_export .= $this->parseHtmlExport ( 'last_modified', $last_modified  );
}

		
		return $html_export .='</div>';
	}

	private function parseHtmlExport($title,$message){
		return '<div style="width:400px;"><h4>' . $title . '</h4><hr /><p>' . $message . '</p></div>';
	}
} ?>
