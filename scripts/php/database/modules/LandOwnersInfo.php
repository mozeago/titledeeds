<?php class LandOwnersInfo{

	private $build;
	private $client;
	private $action;
	private $land_owners;
	private $table = 'land_owners';
	/**
	 * LandOwnersInfo
	 * 
	 * Class to get all the land_owners Information from the land_owners table 
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

		include 'C:\xampp\htdocs\titledeeds\scripts\php\database\crud\LandOwners.class.php';
		
		$this->land_owners = new $TABLE_CLASS( $action, $client );

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
	* Inserts data into the table[land_owners] in the order below
	* array ('firstname','middlename','lastname','idnumber','passport','date_of_birth','address')
	* is mappped into 
	* array ($firstname,$middlename,$lastname,$idnumber,$passport,$date_of_birth,$address)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert($firstname,$middlename,$lastname,$idnumber,$passport,$date_of_birth,$address,$redundancy_check= false, $printSQL = false) {
		$columns = array('firstname','middlename','lastname','idnumber','passport','date_of_birth','address');
		$records = array($$firstname,$middlename,$lastname,$idnumber,$passport,$date_of_birth,$address);
		return $this->land_owners->insert_prepared_records($$firstname,$middlename,$lastname,$idnumber,$passport,$date_of_birth,$address,$redundancy_check,$printSQL );
	}


	public function query($distinct,$extraSQL=""){

		$columns = $records = array ();
		$queried_land_owners = $this->land_owners->fetch_assoc_in_land_owners ($distinct, $columns, $records,$extraSQL );

		if($this->build = ENG_BUILD){
			return $this->query_eng_build($queried_land_owners);
		}
		if($this->build = USER_BUILD){
			return $this->query_user_build($queried_land_owners);
		}
	}

	public function query_eng_build($queried_land_owners){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_land_owners);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_land_owners);
		}
	}
	public function query_user_build(){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_land_owners);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_land_owners);
		}
	}
	private function export_query_json($queried_land_owners){
		$query_json = json_encode($queried_land_owners);
		return $query_json;
	}
	private function export_query_html($queried_land_owners){
		$query_html = "";
		foreach ( $queried_land_owners as $land_owners_row_items ) {
			$query_html .= $this->process_query_for_html_export ( $land_owners_row_items );
		}
		return $query_html;
	}

	private function process_query_for_html_export ( $land_owners_row_items ){
		$html_export ='<div style="padding:10px;margin:10px;border:2px solid black;"><h3>'  .$this->table.  '</h3>';
		
		$firstname = $land_owners_row_items ['firstname'];
	if ($firstname  != null) {
	$html_export .= $this->parseHtmlExport ( 'firstname', $firstname  );
}
$middlename = $land_owners_row_items ['middlename'];
	if ($middlename  != null) {
	$html_export .= $this->parseHtmlExport ( 'middlename', $middlename  );
}
$lastname = $land_owners_row_items ['lastname'];
	if ($lastname  != null) {
	$html_export .= $this->parseHtmlExport ( 'lastname', $lastname  );
}
$idnumber = $land_owners_row_items ['idnumber'];
	if ($idnumber  != null) {
	$html_export .= $this->parseHtmlExport ( 'idnumber', $idnumber  );
}
$passport = $land_owners_row_items ['passport'];
	if ($passport  != null) {
	$html_export .= $this->parseHtmlExport ( 'passport', $passport  );
}
$date_of_birth = $land_owners_row_items ['date_of_birth'];
	if ($date_of_birth  != null) {
	$html_export .= $this->parseHtmlExport ( 'date_of_birth', $date_of_birth  );
}
$address = $land_owners_row_items ['address'];
	if ($address  != null) {
	$html_export .= $this->parseHtmlExport ( 'address', $address  );
}

		
		return $html_export .='</div>';
	}

	private function parseHtmlExport($title,$message){
		return '<div style="width:400px;"><h4>' . $title . '</h4><hr /><p>' . $message . '</p></div>';
	}
} ?>
