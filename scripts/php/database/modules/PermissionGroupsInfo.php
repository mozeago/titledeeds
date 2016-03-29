<?php class PermissionGroupsInfo{

	private $build;
	private $client;
	private $action;
	private $permission_groups;
	private $table = 'permission_groups';
	/**
	 * PermissionGroupsInfo
	 * 
	 * Class to get all the permission_groups Information from the permission_groups table 
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

		include 'C:\xampp\htdocs\titledeeds\scripts\php\database\crud\PermissionGroups.class.php';
		
		$this->permission_groups = new $TABLE_CLASS( $action, $client );

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
	* Inserts data into the table[permission_groups] in the order below
	* array ('permission_group_crud','land_owners_crud','title_deeds_crud','title_deed_comments_crud','title_deed_natures_crud','title_deed_easements_crud','title_deed_proprietorship_crud','system_users_crud','user_types_crud')
	* is mappped into 
	* array ($permission_group_crud,$land_owners_crud,$title_deeds_crud,$title_deed_comments_crud,$title_deed_natures_crud,$title_deed_easements_crud,$title_deed_proprietorship_crud,$system_users_crud,$user_types_crud)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert($permission_group_crud,$land_owners_crud,$title_deeds_crud,$title_deed_comments_crud,$title_deed_natures_crud,$title_deed_easements_crud,$title_deed_proprietorship_crud,$system_users_crud,$user_types_crud,$redundancy_check= false, $printSQL = false) {
		$columns = array('permission_group_crud','land_owners_crud','title_deeds_crud','title_deed_comments_crud','title_deed_natures_crud','title_deed_easements_crud','title_deed_proprietorship_crud','system_users_crud','user_types_crud');
		$records = array($$permission_group_crud,$land_owners_crud,$title_deeds_crud,$title_deed_comments_crud,$title_deed_natures_crud,$title_deed_easements_crud,$title_deed_proprietorship_crud,$system_users_crud,$user_types_crud);
		return $this->permission_groups->insert_prepared_records($$permission_group_crud,$land_owners_crud,$title_deeds_crud,$title_deed_comments_crud,$title_deed_natures_crud,$title_deed_easements_crud,$title_deed_proprietorship_crud,$system_users_crud,$user_types_crud,$redundancy_check,$printSQL );
	}


	public function query($distinct,$extraSQL=""){

		$columns = $records = array ();
		$queried_permission_groups = $this->permission_groups->fetch_assoc_in_permission_groups ($distinct, $columns, $records,$extraSQL );

		if($this->build = ENG_BUILD){
			return $this->query_eng_build($queried_permission_groups);
		}
		if($this->build = USER_BUILD){
			return $this->query_user_build($queried_permission_groups);
		}
	}

	public function query_eng_build($queried_permission_groups){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_permission_groups);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_permission_groups);
		}
	}
	public function query_user_build(){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_permission_groups);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_permission_groups);
		}
	}
	private function export_query_json($queried_permission_groups){
		$query_json = json_encode($queried_permission_groups);
		return $query_json;
	}
	private function export_query_html($queried_permission_groups){
		$query_html = "";
		foreach ( $queried_permission_groups as $permission_groups_row_items ) {
			$query_html .= $this->process_query_for_html_export ( $permission_groups_row_items );
		}
		return $query_html;
	}

	private function process_query_for_html_export ( $permission_groups_row_items ){
		$html_export ='<div style="padding:10px;margin:10px;border:2px solid black;"><h3>'  .$this->table.  '</h3>';
		
		$permission_group_crud = $permission_groups_row_items ['permission_group_crud'];
	if ($permission_group_crud  != null) {
	$html_export .= $this->parseHtmlExport ( 'permission_group_crud', $permission_group_crud  );
}
$land_owners_crud = $permission_groups_row_items ['land_owners_crud'];
	if ($land_owners_crud  != null) {
	$html_export .= $this->parseHtmlExport ( 'land_owners_crud', $land_owners_crud  );
}
$title_deeds_crud = $permission_groups_row_items ['title_deeds_crud'];
	if ($title_deeds_crud  != null) {
	$html_export .= $this->parseHtmlExport ( 'title_deeds_crud', $title_deeds_crud  );
}
$title_deed_comments_crud = $permission_groups_row_items ['title_deed_comments_crud'];
	if ($title_deed_comments_crud  != null) {
	$html_export .= $this->parseHtmlExport ( 'title_deed_comments_crud', $title_deed_comments_crud  );
}
$title_deed_natures_crud = $permission_groups_row_items ['title_deed_natures_crud'];
	if ($title_deed_natures_crud  != null) {
	$html_export .= $this->parseHtmlExport ( 'title_deed_natures_crud', $title_deed_natures_crud  );
}
$title_deed_easements_crud = $permission_groups_row_items ['title_deed_easements_crud'];
	if ($title_deed_easements_crud  != null) {
	$html_export .= $this->parseHtmlExport ( 'title_deed_easements_crud', $title_deed_easements_crud  );
}
$title_deed_proprietorship_crud = $permission_groups_row_items ['title_deed_proprietorship_crud'];
	if ($title_deed_proprietorship_crud  != null) {
	$html_export .= $this->parseHtmlExport ( 'title_deed_proprietorship_crud', $title_deed_proprietorship_crud  );
}
$system_users_crud = $permission_groups_row_items ['system_users_crud'];
	if ($system_users_crud  != null) {
	$html_export .= $this->parseHtmlExport ( 'system_users_crud', $system_users_crud  );
}
$user_types_crud = $permission_groups_row_items ['user_types_crud'];
	if ($user_types_crud  != null) {
	$html_export .= $this->parseHtmlExport ( 'user_types_crud', $user_types_crud  );
}

		
		return $html_export .='</div>';
	}

	private function parseHtmlExport($title,$message){
		return '<div style="width:400px;"><h4>' . $title . '</h4><hr /><p>' . $message . '</p></div>';
	}
} ?>
