<?php
class Utils {
	public function readFile($filename) {
		$file = fopen($filename, "r");
		$reader = fread($file, filesize($filename));
		fclose($file);
		return $reader;
	}
}

?>