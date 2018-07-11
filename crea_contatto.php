<?php
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare Il Futuro - Ricerche</title>
  
  <link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>
	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Crea Contatto</h2>
	</div>

	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

<?php

global $db_passwd;

	$Identificativo = $_POST['Identificativo'];
	$Tipologia = $_POST['Tipologia'];
	$Cliente=(isset($_POST['Cliente'])?True:False);
	$Note = $_POST['Note'];
	
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
		or die('Error connecting to MySQL server.');

// verifica se esiste gia' un contatto con lo stesso nome		
	$query = "SELECT * FROM Anagrafica_Contatto WHERE Anagrafica_Contatto.Identificativo = '$Identificativo'";
	$result = mysqli_query($dbc, $query)
		or die('crea_contatto.php: Error querying database - 1');

	$num_rows=mysqli_num_rows($result);
	if($num_rows>0) {
		echo "<div class=\"info\">";
			echo "Il contatto \"$Identificativo\" esiste gia'";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<a href = \"crea_contatto.html\">Indietro</a>";
		echo "</div>";
	}
	else {	

		echo "<div class=\"main\">";
		echo "<table bgcolor=#FFFFFF>";

			$query = "INSERT INTO Anagrafica_Contatto (Identificativo, Tipologia, Cliente, Note) " .
													"VALUES ('$Identificativo', '$Tipologia', '$Cliente', '$Note')";
			$result = mysqli_query($dbc, $query)
					or die('crea_contatto.php: Error querying database - 2');		

// mostra righe contatto appena creato
			$query = MYSQLI_CONTATTI_COMPLETO . MYSQLI_STD_FROM . "WHERE Anagrafica_Contatto.Identificativo = '$Identificativo'";
			$result = mysqli_query($dbc, $query)
							or die('crea_contatto.php: Error querying database - 1');
							
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
			echo "Il contatto e' stato creato";
			echo "<br>";
			echo "<br>";
			echo "<a href = \"crea_contatto.html\">Crea altro contatto</a>";
			echo "<br>";
			echo "<a href = \"index.html\">Torna al menu principale</a>";
			
			echo "la passwd del db";
			echo $db_passwd;
			
			
			
		echo "</div>";

	}
?>

</body>
</html>
