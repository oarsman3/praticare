<?php
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare Il Futuro - CANCELLA REFERENTE</title>
  
  <link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>
	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Cancella Referente</h2>
	</div>

	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

<?php

	$referente					= $_POST['Referente'];
	$cognomeRef					= strtok($referente, STRNGSEP);
	$nomeRef					= "";
	$toc						= strtok(STRNGSEP);
	while ($toc !== false) {
		$nomeRef .= $toc . " ";
		$toc = strtok(STRNGSEP);
	}
	$nomeRef = rtrim($nomeRef," ");
	
	$contatto					= $_POST['Contatto'];
	
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
		or die('Error connecting to MySQL server.');

// verifica se il referente che si vuole cancellare esiste

	$query = "SELECT * FROM Anagrafica_Referente WHERE Anagrafica_Referente.Cognome_Ref = '$cognomeRef' AND Anagrafica_Referente.Nome_Ref = '$nomeRef' AND Anagrafica_Referente.FK_contatto = (SELECT ID_Contatto FROM Anagrafica_Contatto WHERE Anagrafica_Contatto.Identificativo = '$contatto') ";
	$result = mysqli_query($dbc, $query)
		or die('cancella_referente.php: Error querying database - 1');

	$num_rows=mysqli_num_rows($result);
	if($num_rows==0) {
		echo "<div class=\"info\">";
			echo "Il referente '$cognomeRef' '$nomeRef' non esiste o e' gia' stato cancellato";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<a href = \"cancella_referente_main.php\">Indietro</a>";
			echo "<br>";
			echo "<a href = \"gestione_anagrafiche.html\">Torna a gestione Anagrafiche</a>";
			echo "<br>";
			echo "<a href = \"index.html\">Torna al menu principale</a>";
		echo "</div>";
	}
	else {

	$row = mysqli_fetch_array($result); 	
	
	$ID_Referente = $row['ID_Referente'];
	
// cancella eventuali interessamenti del referente
		$query = "DELETE FROM Interessamenti WHERE Interessamenti.FK_Referente = '$ID_Referente'";
		$result = mysqli_query($dbc, $query) or die('cancella_referente.php: Error querying database - 2');

// cancella l'anagrafica referente
		$query = "DELETE FROM Anagrafica_Referente WHERE Anagrafica_Referente.ID_Referente = $ID_Referente";
		$result = mysqli_query($dbc, $query) or die('cancella_referente.php: Error querying database - 4');

		echo "<div class=\"info\">";
			echo "Il referente $cognomeRef $nomeRef e' stato cancellato";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<a href = \"cancella_referente_main.php\">Cancella altro referente</a>";
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
