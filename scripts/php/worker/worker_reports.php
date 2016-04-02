<?php
if (isset ( $_POST ['title_deed'] )) {
	session_start ();
	$_SESSION ['title_deed'] = $_POST ['title_deed'];
}

?>