<?php
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare Il Futuro - CANCELLA BAMBINO</title>
  
  <link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>
	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Cancella Bambino</h2>
	</div>

	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

<?php

	$Cognome_Ref = $_POST['Cognome'];
	$Nome_Ref = $_POST['Nome'];
	
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
		or die('Error connecting to MySQL server.');

// verifica se il bambino che si vuole cancellare esiste

	$query = "SELECT * FROM Bambini WHERE Bambini.Cognome_Ref = '$Cognome' AND Bambini.Nome_Ref = '$Nome'";
	$result = mysqli_query($dbc, $query)
		or die('cancella_bambini.php: Error querying database - 1');

	$num_rows=mysqli_num_rows($result);
	if($num_rows==0) {
		echo "<div class=\"info\">";
			echo "l'anagrafica bambini '$Cognome' '$Nome' non esiste o e' gia' stata cancellata";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<a href = \"cancella_bambino.html\">Indietro</a>";
			echo "<br>";
			echo "<a href = \"gestione_anagrafiche.html\">Torna a gestione Anagrafiche</a>";
			echo "<br>";
			echo "<a href = \"index.html\">Torna al menu principale</a>";
		echo "</div>";
	}
	else {

	$row = mysqli_fetch_array($result); 	
	
	$ID_Referente = $row['ID_Bambino'];
	
// cancella eventuali adesioni ad attivita' del bambino
		$query = "DELETE FROM Adesioni WHERE Adesioni.FK_Bambino = '$ID_Bambino'";
		$result = mysqli_query($dbc, $query) or die('cancella_bambino.php: Error querying database - 2');

// cancella l'anagrafica bambino
		$query = "DELETE FROM Bambini WHERE Bambini.ID_Bambino = $ID_Bambino";
		$result = mysqli_query($dbc, $query) or die('cancella_referente.php: Error querying database - 4');

		echo "<div class=\"info\">";
			echo "l'anagrafica bambini $Cognome_Ref $Nome_Ref e' stata cancellata";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<a href = \"cancella_referente.html\">Cancella altra anagrafica bambini</a>";
			echo "<br>";
			echo "<a href = \"gestione_anagrafiche.html\">Torna a gestione Anagrafiche</a>";
			echo "<br>";
			echo "<a href = \"index.html\">Torna al menu principale</a>";
		echo "</div>";
	}
	
	mysqli_close($dbc);
?>

</body>
</html>
