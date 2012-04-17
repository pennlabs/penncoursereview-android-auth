<?
/**
* File: index.php
* Developer: Zach Zarrow (zzarrow@seas)
* Created: 4/12/2012 11:50pm
* Last Updated: 4/12/2012 11:50pm
*
* Description:
*       Provides the lookup interface for the mobile application
*	to resolve a serial number to an associated PennKey.
*	
*	INPUT: serial = The user's serial number as saved on the device
*	OUTPUT:	If lookup is successful, the user's PennKey
*		If the lookup fails or we have malformed input,
*			we display API_Strings->SERIAL_NOT_FOUND
*		If an error occurs during lookup, we display
*			we display API_Strings->ERROR
**/ 

	include("../getserial/includes/pcr_auth_common.php");

	function handle_invalid_request(){
		die(API_Strings::SERIAL_NOT_FOUND);
	}

	if(isset($_GET['serial']))
		$serial_number = sanitize_input($_GET['serial']);	
	else
		handle_invalid_request();

	$conn = connect_to_db();

	//get_pennkey_from_serial returns 0 when pennkey isn't found
	$pennkey = get_pennkey_from_serial($serial_number, $conn);

	if(!($pennkey = get_pennkey_from_serial($serial_number, $conn)))
		handle_invalid_request();		

	echo($pennkey);

	mysql_close($conn);
?>
