<?php class TitleDeedsInfo{

	private $build;
	private $client;
	private $action;
	private $title_deeds;
	private $table = 'title_deeds';
	/**
	 * TitleDeedsInfo
	 * 
	 * Class to get all the title_deeds Information from the title_deeds table 
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

		include 'C:\xampp\htdocs\titledeeds\scripts\php\database\crud\TitleDeeds.class.php';
		
		$this->title_deeds = new $TABLE_CLASS( $action, $client );

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
	* Inserts data into the table[title_deeds] in the order below
	* array ('approximate_area','area_units','land_owner','edition','opened','registration_section','parcel_number','plot_number','registy_map_sheet_number')
	* is mappped into 
	* array ($approximate_area,$area_units,$land_owner,$edition,$opened,$registration_section,$parcel_number,$plot_number,$registy_map_sheet_number)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert($approximate_area,$area_units,$land_owner,$edition,$opened,$registration_section,$parcel_number,$plot_number,$registy_map_sheet_number,$redundancy_check= false, $printSQL = false) {
		$columns = array('approximate_area','area_units','land_owner','edition','opened','registration_section','parcel_number','plot_number','registy_map_sheet_number');
		$records = array($$approximate_area,$area_units,$land_owner,$edition,$opened,$registration_section,$parcel_number,$plot_number,$registy_map_sheet_number);
		return $this->title_deeds->insert_prepared_records($$approximate_area,$area_units,$land_owner,$edition,$opened,$registration_section,$parcel_number,$plot_number,$registy_map_sheet_number,$redundancy_check,$printSQL );
	}


	public function query($distinct,$extraSQL=""){

		$columns = $records = array ();
		$queried_title_deeds = $this->title_deeds->fetch_assoc_in_title_deeds ($distinct, $columns, $records,$extraSQL );

		if($this->build = ENG_BUILD){
			return $this->query_eng_build($queried_title_deeds);
		}
		if($this->build = USER_BUILD){
			return $this->query_user_build($queried_title_deeds);
		}
	}

	public function query_eng_build($queried_title_deeds){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_title_deeds);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_title_deeds);
		}
	}
	public function query_user_build(){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_title_deeds);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_title_deeds);
		}
	}
	private function export_query_json($queried_title_deeds){
		$query_json = json_encode($queried_title_deeds);
		return $query_json;
	}
	private function export_query_html($queried_title_deeds){
		$query_html = "";
		foreach ( $queried_title_deeds as $title_deeds_row_items ) {
			$query_html .= $this->process_query_for_html_export ( $title_deeds_row_items );
		}
		return $query_html;
	}

	private function process_query_for_html_export ( $title_deeds_row_items ){
		$html_export ='<div style="padding:10px;margin:10px;border:2px solid black;"><h3>'  .$this->table.  '</h3>';
		
		$approximate_area = $title_deeds_row_items ['approximate_area'];
	if ($approximate_area  != null) {
	$html_export .= $this->parseHtmlExport ( 'approximate_area', $approximate_area  );
}
$area_units = $title_deeds_row_items ['area_units'];
	if ($area_units  != null) {
	$html_export .= $this->parseHtmlExport ( 'area_units', $area_units  );
}
$land_owner = $title_deeds_row_items ['land_owner'];
	if ($land_owner  != null) {
	$html_export .= $this->parseHtmlExport ( 'land_owner', $land_owner  );
}
$edition = $title_deeds_row_items ['edition'];
	if ($edition  != null) {
	$html_export .= $this->parseHtmlExport ( 'edition', $edition  );
}
$opened = $title_deeds_row_items ['opened'];
	if ($opened  != null) {
	$html_export .= $this->parseHtmlExport ( 'opened', $opened  );
}
$registration_section = $title_deeds_row_items ['registration_section'];
	if ($registration_section  != null) {
	$html_export .= $this->parseHtmlExport ( 'registration_section', $registration_section  );
}
$parcel_number = $title_deeds_row_items ['parcel_number'];
	if ($parcel_number  != null) {
	$html_export .= $this->parseHtmlExport ( 'parcel_number', $parcel_number  );
}
$plot_number = $title_deeds_row_items ['plot_number'];
	if ($plot_number  != null) {
	$html_export .= $this->parseHtmlExport ( 'plot_number', $plot_number  );
}
$registy_map_sheet_number = $title_deeds_row_items ['registy_map_sheet_number'];
	if ($registy_map_sheet_number  != null) {
	$html_export .= $this->parseHtmlExport ( 'registy_map_sheet_number', $registy_map_sheet_number  );
}

		
		return $html_export .='</div>';
	}

	private function parseHtmlExport($title,$message){
		return '<div style="width:400px;"><h4>' . $title . '</h4><hr /><p>' . $message . '</p></div>';
	}
} ?>
