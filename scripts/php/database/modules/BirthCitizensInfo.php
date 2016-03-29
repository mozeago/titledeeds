<?php class BirthCitizensInfo{

	private $build;
	private $client;
	private $action;
	private $birth_citizens;
	private $table = 'birth_citizens';
	/**
	 * BirthCitizensInfo
	 * 
	 * Class to get all the birth_citizens Information from the birth_citizens table 
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

		include 'C:\xampp\htdocs\titledeeds\scripts\php\database\crud\BirthCitizens.class.php';
		
		$this->birth_citizens = new $TABLE_CLASS( $action, $client );

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
	* Inserts data into the table[birth_citizens] in the order below
	* array ('first_name','last_name','surname','id_number','sex','district_of_birth','home_district','home_division','home_location','home_sublocation','date_of_birth','trashed','deleted','first_created','last_modified')
	* is mappped into 
	* array ($first_name,$last_name,$surname,$id_number,$sex,$district_of_birth,$home_district,$home_division,$home_location,$home_sublocation,$date_of_birth,$trashed,$deleted,$first_created,$last_modified)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert($first_name,$last_name,$surname,$id_number,$sex,$district_of_birth,$home_district,$home_division,$home_location,$home_sublocation,$date_of_birth,$trashed,$deleted,$first_created,$last_modified,$redundancy_check= false, $printSQL = false) {
		$columns = array('first_name','last_name','surname','id_number','sex','district_of_birth','home_district','home_division','home_location','home_sublocation','date_of_birth','trashed','deleted','first_created','last_modified');
		$records = array($$first_name,$last_name,$surname,$id_number,$sex,$district_of_birth,$home_district,$home_division,$home_location,$home_sublocation,$date_of_birth,$trashed,$deleted,$first_created,$last_modified);
		return $this->birth_citizens->insert_prepared_records($$first_name,$last_name,$surname,$id_number,$sex,$district_of_birth,$home_district,$home_division,$home_location,$home_sublocation,$date_of_birth,$trashed,$deleted,$first_created,$last_modified,$redundancy_check,$printSQL );
	}


	public function query($distinct,$extraSQL=""){

		$columns = $records = array ();
		$queried_birth_citizens = $this->birth_citizens->fetch_assoc_in_birth_citizens ($distinct, $columns, $records,$extraSQL );

		if($this->build = ENG_BUILD){
			return $this->query_eng_build($queried_birth_citizens);
		}
		if($this->build = USER_BUILD){
			return $this->query_user_build($queried_birth_citizens);
		}
	}

	public function query_eng_build($queried_birth_citizens){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_birth_citizens);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_birth_citizens);
		}
	}
	public function query_user_build(){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_birth_citizens);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_birth_citizens);
		}
	}
	private function export_query_json($queried_birth_citizens){
		$query_json = json_encode($queried_birth_citizens);
		return $query_json;
	}
	private function export_query_html($queried_birth_citizens){
		$query_html = "";
		foreach ( $queried_birth_citizens as $birth_citizens_row_items ) {
			$query_html .= $this->process_query_for_html_export ( $birth_citizens_row_items );
		}
		return $query_html;
	}

	private function process_query_for_html_export ( $birth_citizens_row_items ){
		$html_export ='<div style="padding:10px;margin:10px;border:2px solid black;"><h3>'  .$this->table.  '</h3>';
		
		$first_name = $birth_citizens_row_items ['first_name'];
	if ($first_name  != null) {
	$html_export .= $this->parseHtmlExport ( 'first_name', $first_name  );
}
$last_name = $birth_citizens_row_items ['last_name'];
	if ($last_name  != null) {
	$html_export .= $this->parseHtmlExport ( 'last_name', $last_name  );
}
$surname = $birth_citizens_row_items ['surname'];
	if ($surname  != null) {
	$html_export .= $this->parseHtmlExport ( 'surname', $surname  );
}
$id_number = $birth_citizens_row_items ['id_number'];
	if ($id_number  != null) {
	$html_export .= $this->parseHtmlExport ( 'id_number', $id_number  );
}
$sex = $birth_citizens_row_items ['sex'];
	if ($sex  != null) {
	$html_export .= $this->parseHtmlExport ( 'sex', $sex  );
}
$district_of_birth = $birth_citizens_row_items ['district_of_birth'];
	if ($district_of_birth  != null) {
	$html_export .= $this->parseHtmlExport ( 'district_of_birth', $district_of_birth  );
}
$home_district = $birth_citizens_row_items ['home_district'];
	if ($home_district  != null) {
	$html_export .= $this->parseHtmlExport ( 'home_district', $home_district  );
}
$home_division = $birth_citizens_row_items ['home_division'];
	if ($home_division  != null) {
	$html_export .= $this->parseHtmlExport ( 'home_division', $home_division  );
}
$home_location = $birth_citizens_row_items ['home_location'];
	if ($home_location  != null) {
	$html_export .= $this->parseHtmlExport ( 'home_location', $home_location  );
}
$home_sublocation = $birth_citizens_row_items ['home_sublocation'];
	if ($home_sublocation  != null) {
	$html_export .= $this->parseHtmlExport ( 'home_sublocation', $home_sublocation  );
}
$date_of_birth = $birth_citizens_row_items ['date_of_birth'];
	if ($date_of_birth  != null) {
	$html_export .= $this->parseHtmlExport ( 'date_of_birth', $date_of_birth  );
}
$trashed = $birth_citizens_row_items ['trashed'];
	if ($trashed  != null) {
	$html_export .= $this->parseHtmlExport ( 'trashed', $trashed  );
}
$deleted = $birth_citizens_row_items ['deleted'];
	if ($deleted  != null) {
	$html_export .= $this->parseHtmlExport ( 'deleted', $deleted  );
}
$first_created = $birth_citizens_row_items ['first_created'];
	if ($first_created  != null) {
	$html_export .= $this->parseHtmlExport ( 'first_created', $first_created  );
}
$last_modified = $birth_citizens_row_items ['last_modified'];
	if ($last_modified  != null) {
	$html_export .= $this->parseHtmlExport ( 'last_modified', $last_modified  );
}

		
		return $html_export .='</div>';
	}

	private function parseHtmlExport($title,$message){
		return '<div style="width:400px;"><h4>' . $title . '</h4><hr /><p>' . $message . '</p></div>';
	}
} ?>
