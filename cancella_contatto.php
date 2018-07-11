<?php
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare Il Futuro - CANCELLA CONTATTO</title>
  
  <link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>
	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Cancella Contatto</h2>
	</div>

	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

<?php

	$Identificativo = $_POST['Identificativo'];
	
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
		or die('Error connecting to MySQL server.');

// verifica se il contatto che si vuole cancellare esiste

	$query = "SELECT * FROM Anagrafica_Contatto WHERE Anagrafica_Contatto.Identificativo LIKE '%" . $Identificativo . "%'";
	$result = mysqli_query($dbc, $query)
		or die('cancella_contatto.php: Error querying database - 1');

	$num_rows=mysqli_num_rows($result);
	if($num_rows==0) {
		echo "<div class=\"info\">";
			echo "L'anagrafica '$Identificativo' non esiste o e' gia' stata cancellata";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<a href = \"cancella_contatto_main.php\">Indietro</a>";
			echo "<br>";
			echo "<a href = \"gestione_anagrafiche.html\">Torna a gestione Anagrafiche</a>";
			echo "<br>";
			echo "<a href = \"index.html\">Torna al menu principale</a>";
		echo "</div>";
	}
	else {

	$row = mysqli_fetch_array($result); 	
	
	$ID_Contatto = $row['ID_Contatto'];
	
// verifica se esistono referenti associati al contatto che si vuole cancellare	
		$query = "SELECT * FROM Anagrafica_Referente WHERE Anagrafica_Referente.FK_Contatto = '$ID_Contatto'";
		$result = mysqli_query($dbc, $query) or die('cancella_contatto.php: Error querying database - 2');
		$num_rows=mysqli_num_rows($result);

		if($num_rows>0) {
			echo "<div class=\"info\">";
				echo "l'anagrafica '$Identificativo' non si puo' cancellare perche' e'<br>";
				echo "ancora associata ad anagrafiche referenti";
				echo "<br>";
				echo "<br>";
				echo "Cancellare le anagrafiche referenti e riprovare";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<a href = \"cancella_contatto_main.php\">Indietro</a>";
				echo "<br>";
				echo "<a href = \"gestione_anagrafiche.html\">Torna a gestione Anagrafiche</a>";
				echo "<br>";
				echo "<a href = \"index.html\">Torna al menu principale</a>";
			echo "</div>";
		}
		else {
// verifica se esistono bambini associati al contatto che si vuole cancellare	
			$query = "SELECT * FROM Bambini WHERE Bambini.FK_Contatto = '$ID_Contatto'";
			$result = mysqli_query($dbc, $query) or die('cancella_contatto.php: Error querying database - 3');
			$num_rows=mysqli_num_rows($result);
			
			if($num_rows>0) {
				echo "<div class=\"info\">";
					echo "l'anagrafica '$Identificativo' non si puo' cancellare perche' e'<br>";
					echo "ancora associata ad anagrafiche bambini";
					echo "<br>";
					echo "<br>";
					echo "Cancellare le anagrafiche bambini e riprovare";
					echo "<br>";
					echo "<br>";
					echo "<br>";
					echo "<br>";
					echo "<a href = \"cancella_contatto_main.php\">Indietro</a>";
					echo "<br>";
					echo "<a href = \"gestione_anagrafiche.html\">Torna a gestione Anagrafiche</a>";
					echo "<br>";
					echo "<a href = \"index.html\">Torna al menu principale</a>";
				echo "</div>";
			}
			else {

				$query = "DELETE FROM Anagrafica_Contatto WHERE Anagrafica_Contatto.ID_Contatto = $ID_Contatto";
				$result = mysqli_query($dbc, $query) or die('cancella_contatto.php: Error querying database - 4');

				echo "<div class=\"info\">";
					echo "L'anagrafica '$Identificativo' e' stata cancellata";
					echo "<br>";
					echo "<br>";
					echo "<br>";
					echo "<br>";
					echo "<a href = \"cancella_contatto_main.php\">Cancella altro contatto</a>";
					echo "<br>";
					echo "<a href = \"gestione_anagrafiche.html\">Torna a gestione Anagrafiche</a>";
					echo "<br>";
					echo "<a href = \"index.html\">Torna al menu principale</a>";
				echo "</div>";
			}
		}
	}
	
	mysqli_close($dbc);
?>

</body>
</html>
