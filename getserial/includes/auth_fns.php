<?	

/**
* File: auth_fns.php
* Developer: Zach Zarrow (zzarrow@seas)
* Created: 4/12/2012 11:33pm
* Last Updated: 4/12/2012 11:33pm
*
* Description:
*       Provides serial number lookup and generation functions for the
*	PennCourseReview Mobile authentication application.
**/

	function handle_error($_err){
		die('!ERROR');
	}

	function get_pennkey_from_serial($_serial, $_conn){
		$query = mysql_query("
			SELECT `pennkey` from " . DB_Const::SERIALS_TABLE . " WHERE `serial`='" . $_serial . "' LIMIT 1;
		", $_conn) or (handle_error(mysql_error()));

		if(!mysql_num_rows($query))
			return 0;

		$result_obj = mysql_fetch_object($query) or (handle_error(mysql_error()));
		return($result_obj->pennkey);
	}

	function get_serial_from_pennkey($_pennkey, $_conn){
		$query = mysql_query("
                        SELECT `serial` from " . DB_Const::SERIALS_TABLE . " WHERE `pennkey`='" . $_pennkey . "' LIMIT 1;
                ", $_conn) or (die(API_Strings::HUMAN_READABLE_ERROR));

                if(!mysql_num_rows($query))
                        return 0;

                $result_obj = mysql_fetch_object($query) or (die(API_Strings::HUMAN_READABLE_ERROR));
                return($result_obj->serial);
	}

	function generate_new_serial($_pennkey, $_conn){
		//We will take the first 5 chars from the MD5 hash of the user's PennKey
		//Then, to ensure uniqueness, we'll append the total # of rows in the db to the end of the serial

		//In case the db call fails, we'll choose a random number.  The chance of a serial
		//collision is very negligible.
		$nextID = rand(0, 200) + 1;
		$quer = mysql_query("SELECT COUNT(*) AS numrows FROM " . DB_Const::SERIALS_TABLE . ";");
		if($quer){
			$arr = mysql_fetch_assoc($quer);
			if($arr != FALSE)
				$nextID = $arr['numrows'];
		}
			
		return(substr(md5($_pennkey), 0, 5) . $nextID);
	}

	function register_serial($_serial, $_pennkey, $_conn){
		$insert = "INSERT INTO  `" . DB_Const::SERIALS_TABLE . "` (
			`id` ,
			`serial` ,
			`pennkey` ,
			`issued_timestamp` ,
			`last_access_timestamp`
		)
		VALUES (
			NULL ,  '" . $_serial . "',  '" . $_pennkey . "',  '" . date("Ymdhis") . "', ''			);";

		return(mysql_query($insert));
	}
?>
