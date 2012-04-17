<?

/**
* File: security_fns.php
* Developer: Zach Zarrow (zzarrow@seas)
* Created: 4/12/2012 11:42pm
* Last Updated: 4/12/2012 11:42pm
*
* Description:
*       Security and data sanitation functions for the PennCourseReview
*       Mobile authentication application.
**/

	function sanitize_input($_input){
		return trim(strip_tags(addslashes($_input)));
	}
?>
