<?
/**
* File: index.php
* Developer: Zach Zarrow (zzarrow@seas)
* Created: 4/13/2012 2:34am
* Last Updated: 4/13/2012 2:34am
*
* Description:
*       Generates the front-end for the serial number acquisition page.
*	Input:
*		"gen", ifset, means to generate a serial number
**/

	include("includes/pcr_auth_common.php");

	$readable_err_str = API_Strings::HUMAN_READABLE_ERROR;
?>
<html>
<body>
	Welcome, <b><? echo($_SERVER['REMOTE_USER']) ?></b>!<br />
	<p>Here, you can obtain a serial number to activate <b>Penn Course Review Mobile</b> on your device.</p>

<?
	function display_serial($_serial){
		echo('
			<p><h2><b><font color="#00AA00">Your serial number is: </font></b>' . $_serial . '</h2></p>	
		');
	}

	function display_gen_button(){

		echo('
			<input type="button" name="gen_serial" value="Generate My Serial Number" onClick=\'location.href="?gen"\' />

			<!-- This can also be turned into an image.  Just use:
				<a href="?gen"><img src="..."></a>
			-->
		');
	}

	$conn = connect_to_db();
	if(!$conn)
		echo($readable_err_str);
	else {
		if(!($serial = get_serial_from_pennkey($_SERVER['REMOTE_USER'], $conn))){
			if(isset($_GET['gen'])){
				$serial = generate_new_serial($_SERVER['REMOTE_USER'], $conn);	
				if(!register_serial($serial, $_SERVER['REMOTE_USER'], $conn)){
					echo($readable_err_str);
				}
				else{
					display_serial($serial);
				}
			} else {
				display_gen_button();				
			}
		} else {
			display_serial($serial);
		}
		mysql_close($conn);
	}
?>

	<p><b>Why do I need a serial number?</b>  For security and privacy, Penn Course Review is only accessible to users with a valid PennKey.  Penn Course Review Mobile is a standalone mobile application, and Penn's Information Systems & Computing (ISC) department currently does not support handling secure PennKey logins on mobile devices.</p><p>So, this is our ISC-approved solution to get around this: You already logged in to this page using Penn's official WebLogin system, and this page will give you a serial number that will activate your mobile app.  And don't worry - You only need to enter the serial number once.  Once your app is activated, you will be able to use Penn Course Review Mobile instantly, for as long as your PennKey is valid.  Just make sure that you <b>never give your serial number out to anybody</b>.</p>

</body>
</html>
