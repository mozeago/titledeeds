<?php class SystemUsersInfo{

	private $build;
	private $client;
	private $action;
	private $system_users;
	private $table = 'system_users';
	/**
	 * SystemUsersInfo
	 * 
	 * Class to get all the system_users Information from the system_users table 
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

		include 'C:\xampp\htdocs\titledeeds\scripts\php\database\crud\SystemUsers.class.php';
		
		$this->system_users = new $TABLE_CLASS( $action, $client );

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
	* Inserts data into the table[system_users] in the order below
	* array ('firstname','lastname','email','phonenumber','username','password','account_status')
	* is mappped into 
	* array ($firstname,$lastname,$email,$phonenumber,$username,$password,$account_status)
	* @return 1 if data was inserted,0 otherwise
	* if redundancy check is true, it inserts if the record if it never existed else.
	* if the record exists, it returns the number of times the record exists on the relation
	*/
	public function insert($firstname,$lastname,$email,$phonenumber,$username,$password,$account_status,$redundancy_check= false, $printSQL = false) {
		$columns = array('firstname','lastname','email','phonenumber','username','password','account_status');
		$records = array($$firstname,$lastname,$email,$phonenumber,$username,$password,$account_status);
		return $this->system_users->insert_prepared_records($$firstname,$lastname,$email,$phonenumber,$username,$password,$account_status,$redundancy_check,$printSQL );
	}


	public function query($distinct,$extraSQL=""){

		$columns = $records = array ();
		$queried_system_users = $this->system_users->fetch_assoc_in_system_users ($distinct, $columns, $records,$extraSQL );

		if($this->build = ENG_BUILD){
			return $this->query_eng_build($queried_system_users);
		}
		if($this->build = USER_BUILD){
			return $this->query_user_build($queried_system_users);
		}
	}

	public function query_eng_build($queried_system_users){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_system_users);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_system_users);
		}
	}
	public function query_user_build(){
		if($this->client == POST_CLIENT_DESKTOP){
			return $this->export_query_html($queried_system_users);
		}
		if($this->client == POST_CLIENT_MOBILE_ANDROID){
			return $this->export_query_json($queried_system_users);
		}
	}
	private function export_query_json($queried_system_users){
		$query_json = json_encode($queried_system_users);
		return $query_json;
	}
	private function export_query_html($queried_system_users){
		$query_html = "";
		foreach ( $queried_system_users as $system_users_row_items ) {
			$query_html .= $this->process_query_for_html_export ( $system_users_row_items );
		}
		return $query_html;
	}

	private function process_query_for_html_export ( $system_users_row_items ){
		$html_export ='<div style="padding:10px;margin:10px;border:2px solid black;"><h3>'  .$this->table.  '</h3>';
		
		$firstname = $system_users_row_items ['firstname'];
	if ($firstname  != null) {
	$html_export .= $this->parseHtmlExport ( 'firstname', $firstname  );
}
$lastname = $system_users_row_items ['lastname'];
	if ($lastname  != null) {
	$html_export .= $this->parseHtmlExport ( 'lastname', $lastname  );
}
$email = $system_users_row_items ['email'];
	if ($email  != null) {
	$html_export .= $this->parseHtmlExport ( 'email', $email  );
}
$phonenumber = $system_users_row_items ['phonenumber'];
	if ($phonenumber  != null) {
	$html_export .= $this->parseHtmlExport ( 'phonenumber', $phonenumber  );
}
$username = $system_users_row_items ['username'];
	if ($username  != null) {
	$html_export .= $this->parseHtmlExport ( 'username', $username  );
}
$password = $system_users_row_items ['password'];
	if ($password  != null) {
	$html_export .= $this->parseHtmlExport ( 'password', $password  );
}
$account_status = $system_users_row_items ['account_status'];
	if ($account_status  != null) {
	$html_export .= $this->parseHtmlExport ( 'account_status', $account_status  );
}

		
		return $html_export .='</div>';
	}

	private function parseHtmlExport($title,$message){
		return '<div style="width:400px;"><h4>' . $title . '</h4><hr /><p>' . $message . '</p></div>';
	}
} ?>
