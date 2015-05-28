<?php
	class DB_ini {
		public static function connect() {
//			$conn = OCILogon("mis","takuro","(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=oracle.uis.edu)(PORT=1521))(CONNECT_DATA=(SID=oracle)))");
			$conn = oci_connect('mis', 'takuro', 'localhost/XE');
			if (!$conn) {
				$e = oci_error();
				return json_encode(array("error" => $e['message']));
				//  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			}	
			return $conn;
		}
	}

?>