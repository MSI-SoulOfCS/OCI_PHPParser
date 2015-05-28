<?php

include("db.ini.php");

	$conn = DB_ini::connect();
	$stid = oci_parse($conn, "begin InitDB; end;");
	$r = oci_execute($stid);
	if(!$r) {
		$e = oci_error($stid);
		echo $e['message'];
	}
	$stid = oci_parse($conn, "create or replace trigger site_location_insert_trig before insert on site_location for each row begin select site_location_id_seq.nextval into :new.id from dual; end; ");
	$r = oci_execute($stid);
	if(!$r) {
		$e = oci_error($stid);
		echo $e['message'];
	}	
	$stid = oci_parse($conn, "create or replace trigger ticket_insert_trig before insert on ticket for each row begin select ticket_id_seq.nextval into :new.id from dual; end; ");
	$r = oci_execute($stid);
	if(!$r) {
		$e = oci_error($stid);
		echo $e['message'];
	}
	$stid = oci_parse($conn, "create or replace trigger history_insert_trig before insert on history for each row begin select history_id_seq.nextval into :new.id from dual; end; ");
	$r = oci_execute($stid);
	if(!$r) {
		$e = oci_error($stid);
		echo $e['message'];
	}

	echo "-------------------------------------------------------";	
	
	$row = 1;
	if (($handle = fopen("./db_data/station.txt", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			echo "<p> $num fields in line $row: <br /></p>\n";
			$row++;
			for ($c=0; $c < $num; $c++) {
				echo $data[$c] . "<br />\n";
			}
			$conn = DB_ini::connect();
			$sql = oci_parse($conn, "insert into site_location (state,city,station) values (:state,:city,:station)");
			oci_bind_by_name($sql, ':state', $data[0]);
			oci_bind_by_name($sql, ':city', $data[1]);
			oci_bind_by_name($sql, ':station', $data[2]);

			$r = oci_execute($sql);
			if(!$r) {
					$e = oci_error($sql);
					echo $e['message'];
			}
		}
		fclose($handle);
	}

	echo "-------------------------------------------------------";

	$row = 1;
	if (($handle = fopen("./db_data/ticket.txt", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			echo "<p> $num fields in line $row: <br /></p>\n";
			$row++;
			for ($c=0; $c < $num; $c++) {
				echo $data[$c] . "<br />\n";
			}
			$conn = DB_ini::connect();
			$sql = oci_parse($conn, "insert into ticket (price,day,from_loc,to_loc,amount,activate) values (:price, to_date(:day, 'DD-MM-YYYY HH24:MI:SS'), :from_loc, :to_loc, :amount, :activate)");
			oci_bind_by_name($sql, ':price', $data[0]);
			oci_bind_by_name($sql, ':day', $data[1]);
			oci_bind_by_name($sql, ':from_loc', $data[2]);
			oci_bind_by_name($sql, ':to_loc', $data[3]);
			oci_bind_by_name($sql, ':amount', $data[4]);
			oci_bind_by_name($sql, ':activate', $data[5]);
			
			$r = oci_execute($sql);
			if(!$r) {
					$e = oci_error($sql);
					echo $e['message'];
			}
		}
		fclose($handle);
	}

	echo "-------------------------------------------------------";


	$row = 1;
	if (($handle = fopen("./db_data/users.txt", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			echo "<p> $num fields in line $row: <br /></p>\n";
			$row++;
			for ($c=0; $c < $num; $c++) {
				echo $data[$c] . "<br />\n";
			}
			$conn = DB_ini::connect();
			$sql = oci_parse($conn, "insert into users (id,lastname,firstname,password,email,authority,enabled) values (:id, :lastname, :firstname, :password, :email, :authority, :enabled)");
			oci_bind_by_name($sql, ':id', $data[0]);
			oci_bind_by_name($sql, ':lastname', $data[1]);
			oci_bind_by_name($sql, ':firstname', $data[2]);
			oci_bind_by_name($sql, ':password', $data[3]);
			oci_bind_by_name($sql, ':email', $data[4]);
			oci_bind_by_name($sql, ':authority', $data[5]);
			oci_bind_by_name($sql, ':enabled', $data[6]);
			
			$r = oci_execute($sql);
			if(!$r) {
					$e = oci_error($sql);
					echo $e['message'];
			}
		}
		fclose($handle);
	}

	echo "-------------------------------------------------------";

	$row = 1;
	if (($handle = fopen("./db_data/history.txt", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			echo "<p> $num fields in line $row: <br /></p>\n";
			$row++;
			for ($c=0; $c < $num; $c++) {
				echo $data[$c] . "<br />\n";
			}
			$conn = DB_ini::connect();
			$sql = oci_parse($conn, "insert into history (userid,ticketid,amount) values (:userid, :ticketid, :amount)");
			oci_bind_by_name($sql, ':userid', $data[0]);
			oci_bind_by_name($sql, ':ticketid', $data[1]);
			oci_bind_by_name($sql, ':amount', $data[2]);

			$r = oci_execute($sql);
			if(!$r) {
					$e = oci_error($sql);
					echo $e['message'];
			}
		}
		fclose($handle);
	}


?>