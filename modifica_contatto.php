<?php
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare Il Futuro - Modifica Contatto</title>
  
  <link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>
	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Modifica Contatto</h2>
	</div>

	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

<?php

	$Identificativo			= $_POST['Identificativo'];
	$Tipologia				= $_POST['Tipologia'];
	$Cliente				= (isset($_POST['Cliente'])?True:False);
	$Note					= $_POST['Note'];
	$Data_ultimo_contatto	= $_POST['Data_ultimo_contatto'];
	
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
							or die('Error connecting to MySQL server.');

	echo "<div class=\"main\">";
	echo "<table bgcolor=#FFFFFF>";
	
		$query = "UPDATE Anagrafica_Contatto SET Tipologia = '$Tipologia'," .
			 	 "Cliente = '$Cliente', Note = '$Note', Ultimo_contatto = '$Data_ultimo_contatto' " .
				 "WHERE Identificativo = '$Identificativo'";

		$result = mysqli_query($dbc, $query)
					or die('modifica_contatto.php: Error querying database - 2');		

// mostra riga contatto appena modificata

		$query = MYSQLI_CONTATTI_COMPLETO . MYSQLI_STD_FROM . "WHERE Anagrafica_Contatto.Identificativo = '$Identificativo'";
		$result = mysqli_query($dbc, $query)
							or die('modifica_contatto.php: Error querying database - 3');
							
		$table = array();
		$tbl_pnt=0;
		while ($row = mysqli_fetch_array($result)) {
			$table[$tbl_pnt]=$row;
			$tbl_pnt+=1;
		}

		$tbl_len=count($table);

		$titoli=TITOLI_TABELLA_CONTATTI_COMPLETO;
		echo "$titoli";

		$tbl_pnt=0;	
		while ($tbl_pnt < $tbl_len) {		
			$row_pnt=0;
			$row_len = count($table[0]) / 2;
			if ($row_len>0) {
				echo "<tr>";
				while ($row_pnt<$row_len) {
					echo "<td>" . $table[$tbl_pnt][$row_pnt] . "</td>";
					$row_pnt += 1;
					}
				$tbl_pnt += 1;
				echo "</tr>";
			}
			else {
				$tbl_pnt += 1;
			}
		}
		
		mysqli_close($dbc);

	echo "</table>";
	echo "</div>";

	echo "<div class=\"info\">";
		echo "Il contatto e' stato modificato";
		echo "<br>";
		echo "<br>";
		echo "<a href = \"modifica_contatto_main.php\">modifica altro contatto</a>";
		echo "<br>";
		echo "<a href = \"gestione_anagrafiche\">torna a gestione anagrafiche</a>";
		echo "<br>";
		echo "<a href = \"index.html\">Torna al menu principale</a>";		
	echo "</div>";

?>

</body>
</html>
