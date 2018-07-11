<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Aliens Abducted Me - Report an Abduction</title>
</head>
<body>
  <h2>Aliens Abducted Me - Report an Abduction</h2>

<?php
  $first_name = $_POST['firstname'];
  $last_name = $_POST['lastname'];
  $when_it_happened = $_POST['whenithappened'];
  $how_long = $_POST['howlong'];
  $how_many = $_POST['howmany'];
  $alien_description = $_POST['aliendescription'];
  $what_they_did = $_POST['whattheydid'];
  $fang_spotted = $_POST['fangspotted'];
  $email = $_POST['email'];
  $other = $_POST['other'];

/*  
$dbc = mysqli_connect('localhost','usr_web202_1', 'web202', 'messico1')
    or die('Error connecting to MySQL server.');
*/
  
$dbc = mysqli_connect('62.149.150.207', 'Sql732257', '223mqw8tj7', 'Sql732257_1')
    or die('Error connecting to MySQL server.');

/*
$dbc = mysql_connect('localhost', 'web202', 'messico1')
    or die('Error connecting to MySQL server.');

	mysql_select_db('usr_web202_1', $dbc) or die(mysql_error());
*/

	$risultato = mysqli_query($dbc, "SELECT * FROM anagraficacontatti") or die('Error connecting to MySQL server.');

    $num_righe = mysqli_num_rows($risultato);

    echo "$num_righe Righe\n";
	echo '<br />';
	
	

  $query = "INSERT INTO anagraficacontatti (first_name, last_name, when_it_happened, how_long, " .
    "how_many, alien_description, what_they_did, fang_spotted, other, email) " .
    "VALUES ('$first_name', '$last_name', '$when_it_happened', '$how_long', '$how_many', " .
    "'$alien_description', '$what_they_did', '$fang_spotted', '$other', '$email')";

echo "$query";

  $result = mysqli_query($dbc, $query)
    or die('Error querying database.');


  mysqli_close($dbc);

  echo 'Thanks for submitting the form.<br />';
  echo 'You were abducted ' . $when_it_happened;
  echo ' and were gone for ' . $how_long . '<br />';
  echo 'Number of aliens: ' . $how_many . '<br />';
  echo 'Describe them: ' . $alien_description . '<br />';
  echo 'The aliens did this: ' . $what_they_did . '<br />';  echo 'Was Fang there? ' . $fang_spotted . '<br />';
  echo 'Other comments: ' . $other . '<br />';
  echo 'Your email address is ' . $email;
?>

	<br />
	<br />
	<br />
	<a href ="index.html">Torna al menu principale</a>

</body>
</html>
