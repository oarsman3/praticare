!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Aliens Abducted Me - Report an Abduction</title>
</head>
<body>
  <h2>Aliens Abducted Me - Report an Abduction</h2>

<?php
	$Identificativo = $_POST['Identificativo'];
	$Tipologia = $_POST['Tipologia'];
	$Nome = $_POST['Nome'];
	$Cognome = $_POST['Cognome'];
	$CF_PIVA = $_POST['P_IVA'];
	$Email = $_POST['Email'];
 
  
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
		or die('Error connecting to MySQL server.');


	$query = "INSERT INTO Anagrafica_Contatto (Identificativo, Tipologia) " .
		"VALUES ('$Identificativo', '$Tipologia')";

echo "$query";

	$result = mysqli_query($dbc, $query)
		or die('Error querying database - 1');

/*
Inserisci contatto fisico
	  
*/
	$query = "SELECT * FROM Anagrafica_Contatto " .
		"WHERE (((Anagrafica_Contatto.Identificativo)='$Identificativo'))";
	
	
	$result = mysqli_query($dbc, $query)
		or die('Error querying database - 2');

	echo '<br />';

	$row = mysqli_fetch_array($result); 
	$ID = $row['ID_Contatto'];
	echo ('$ID');
	$query = "INSERT INTO Anagrafica_Referente (FK_contatto, Nome_Ref, Cognome_Ref, P_IVA, E_MAIL) " .
    "VALUES ('$ID', '$Nome', '$Cognome', '$P_IVA', '$Email')";
	echo "$query";
	$result = mysqli_query($dbc, $query)
		or die('Error querying database - 3');
		
	$query="SELECT * FROM Anagrafica_Contatto";
	
	$result = mysqli_query($dbc, $query)
		or die('Error querying database - 4');
	
	$num_righe = mysqli_num_rows($result);

    echo "$num_righe Righe\n";
	echo '<br />';


	while( $row = mysqli_fetch_array($result)) {  
	echo $row['Identificativo'].' '.$row['Tipologia'];	
	echo '<br/>';
	}

  mysqli_close($dbc);

  echo 'Thanks for submitting the form.<br />';
  echo 'Identificativo ' . $Identificativo;
?>

	<br />
	<br />
	<br />
	<a href ="index.html">Torna al menu principale</a>

</body>
</html>
