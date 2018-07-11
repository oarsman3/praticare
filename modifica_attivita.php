<?php
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare Il Futuro - Modifica Attivita</title>
  
  <link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>
	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Modifica Attivita</h2>
	</div>

	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_attivita.html">Torna a Gestione Attivita'</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

<?php

	$Nome_Attivita			= $_POST['Nome_Attivita'];
	$Tipo					= $_POST['Tipo'];
	$Stato					= $_POST['Stato'];
	$Capacita				= $_POST['Capacita'];
	$Inizio					= $_POST['Inizio'];
	$Fine					= $_POST['Fine'];
	$Note					= $_POST['Note'];
				
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
							or die('Error connecting to MySQL server.');

	echo "<div class=\"main\">";
	echo "<table bgcolor=#FFFFFF>";

		$query = "UPDATE Lista_Attivita_Adesioni SET Tipo = '$Tipo',	Stato = '$Stato', Capacita = '$Capacita', Inizio = '$Inizio', Fine = '$Fine', Note = '$Note' " . 
				 "WHERE Nome_Attivita LIKE '$Nome_Attivita' ";
				 
		$result = mysqli_query($dbc, $query)
					or die('modifica_attivita.php: Error querying database - 1');		

		$query = "UPDATE Lista_Attivita_Interessamenti SET Tipo = '$Tipo',	Stato = '$Stato', Capacita = '$Capacita', Inizio = '$Inizio', Fine = '$Fine', Note = '$Note' " . 
				 "WHERE Nome_Attivita_Interessamento LIKE '$Nome_Attivita' ";				 

		$result = mysqli_query($dbc, $query)
					or die('modifica_attivita.php: Error querying database - 2');		

		mysqli_close($dbc);

	echo "</table>";
	echo "</div>";

	echo "<div class=\"info\">";
		echo "l'Attivita' e' stata modificata";
		echo "<br>";
		echo "<br>";
		echo "<a href = \"modifica_attivita_main.php\">modifica altra attivita'</a>";
		echo "<br>";
		echo "<a href = \"gestione_attivita.htm\">torna a gestione attivita'</a>";
		echo "<br>";
		echo "<a href = \"index.html\">Torna al menu principale</a>";		
	echo "</div>";

?>

</body>
</html>
