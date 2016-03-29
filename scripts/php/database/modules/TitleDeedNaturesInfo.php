<?php class TitleDeedNaturesInfo{

	private $build;
	private $client;
	private $action;
	private $title_deed_natures;
	private $table = 'title_deed_natures';
	/**
	 * TitleDeedNaturesInfo
	 * 
	 * Class to get all the title_deed_natures Information from the title_deed_natures table 
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

		include 'C:\xampp\htdocs\titledeeds\scripts\php\database\crud\TitleDeedNatures.class.php';
		
		$this->title_deed_natures = new $TABLE_CLASS( $action, $client );

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
	* Inserts data into the table[title_deed_natures] in the order below
	* array ('id_title_deed','title_deed_nature','posted_date')
	* is mappped into 
	* array ($id_title_deed,$title_deed_nature,$posted_date)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert($id_title_deed,$title_deed_nature,$posted_date,$redundancy_check= false, $printSQL = false) {
		$columns = array('id_title_deed','title_deed_nature','posted_date');
		$records = array($$id_title_deed,$title_deed_nature,$posted_date);
		return $this->title_deed_natures->insert_prepared_records($$id_title_deed,$title_deed_nature,$posted_date,$redundancy_check,$printSQL );
	}


	public function query($distinct,$extraSQL=""){

		$columns = $records = array ();
		$queried_title_deed_natures = $this->title_deed_natures->fetch_assoc_in_title_deed_natures ($distinct, $columns, $records,$extraSQL );

		if($this->build = ENG_BUILD){
			return $this->query_eng_build($queried_title_deed_natures);
		}
		if($this->build = USER_BUILD){
			return $this->query_user_build($queried_title_deed_natures);
		}
	}

	public function query_eng_build($queried_title_deed_natures){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_title_deed_natures);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_title_deed_natures);
		}
	}
	public function query_user_build(){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_title_deed_natures);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_title_deed_natures);
		}
	}
	private function export_query_json($queried_title_deed_natures){
		$query_json = json_encode($queried_title_deed_natures);
		return $query_json;
	}
	private function export_query_html($queried_title_deed_natures){
		$query_html = "";
		foreach ( $queried_title_deed_natures as $title_deed_natures_row_items ) {
			$query_html .= $this->process_query_for_html_export ( $title_deed_natures_row_items );
		}
		return $query_html;
	}

	private function process_query_for_html_export ( $title_deed_natures_row_items ){
		$html_export ='<div style="padding:10px;margin:10px;border:2px solid black;"><h3>'  .$this->table.  '</h3>';
		
		$id_title_deed = $title_deed_natures_row_items ['id_title_deed'];
	if ($id_title_deed  != null) {
	$html_export .= $this->parseHtmlExport ( 'id_title_deed', $id_title_deed  );
}
$title_deed_nature = $title_deed_natures_row_items ['title_deed_nature'];
	if ($title_deed_nature  != null) {
	$html_export .= $this->parseHtmlExport ( 'title_deed_nature', $title_deed_nature  );
}
$posted_date = $title_deed_natures_row_items ['posted_date'];
	if ($posted_date  != null) {
	$html_export .= $this->parseHtmlExport ( 'posted_date', $posted_date  );
}

		
		return $html_export .='</div>';
	}

	private function parseHtmlExport($title,$message){
		return '<div style="width:400px;"><h4>' . $title . '</h4><hr /><p>' . $message . '</p></div>';
	}
} ?>
