<?

/**
* File: db_fns.php
* Developer: Zach Zarrow (zzarrow@seas)
* Created: 4/12/2012 11:27pm
* Last Updated: 4/12/2012 11:27pm
*
* Description:
* 	Provides common database functions for the PennCourseReview
*	Mobile authentication application.
**/

	class DB_Const{
		const HOST = "localhost";
		const DB_NAME = "cis350";
		const SERIALS_TABLE = "pcr_mobile_serials";

		const USERNAME = "cis350";
		const PASSWORD = getenv("CIS350_DB_PASSWORD");
	}

	function connect_to_db(){
		$conn = mysql_connect(DB_Const::HOST, DB_Const::USERNAME, DB_Const::PASSWORD);
		if(!$conn) //error
			return 0;
		mysql_select_db(DB_Const::DB_NAME, $conn);
		return $conn;	
	}	

?>
