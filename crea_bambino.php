<?php
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare Il Futuro - Crea Anagrafica Bambino</title>
  
  <link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>
	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Crea Anagrafica Bambino</h2>
	</div>

	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

<?php
	$Identificativo		= $_POST['Identificativo'];
	$Nome				= $_POST['Nome'];
	$Cognome 			= $_POST['Cognome'];
	$Data_di_nascita 	= $_POST['Data_di_nascita'];
	$Note 				= $_POST['Note'];
	$Nome_Attivita 		= $_POST['Nome_Attivita'];
	$Stato_Adesione 	= $_POST['Stato_Adesione'];
	$Note_Adesione		= $_POST['Note_Adesione'];
	
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB) or die('crea_bambino.php: Error connecting to MySQL server.');

// verifica se esiste il contatto a cui verra' associato il bambino		
	$query = "SELECT * FROM Anagrafica_Contatto WHERE Anagrafica_Contatto.Identificativo LIKE '%" . $Identificativo . "%'";
	$result = mysqli_query($dbc, $query) or die('crea_bambino.php: Error querying database - 1');

	$num_rows=mysqli_num_rows($result);

	if($num_rows==0) {
		echo "<div class=\"info\">";
			echo "il contatto '$Identificativo' non esiste, e' necessario crearlo prima di creare l'anagrafica bambino";
			echo "<br>";
			echo "<br>";
			echo "<a href = \"crea_bambino_main.php\">Indietro</a>";
		echo "</div>";
	}
	else {	

// recupera ID Contatto
		$row = mysqli_fetch_array($result); 
		$ID_contatto = $row['ID_Contatto'];
		
// verifica se esiste gia' l'anagrafica bambino associata al contatto
		$query = "SELECT * FROM Bambini WHERE Bambini.Cognome = '$Cognome' AND Bambini.Nome = '$Nome' AND Bambini.FK_contatto = " . $ID_contatto ;

		$result = mysqli_query($dbc, $query) or die('crea_bambino.php: Error querying database - 2');

		$num_rows=mysqli_num_rows($result);

		if($num_rows!=0) {
			echo "<div class=\"info\">";
				echo "l/'anagrafica bambino $Cognome $Nome associata al contatto esiste gia/'";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<a href = \"crea_bambino_main.php\">Indietro</a>";
				echo "<br>";
				echo "<a href = \"gestione_anagrafiche.html\">Torna a gestione anagrafiche</a>";
			echo "</div>";
		}
		else {

// Crea anagrafica bambino linkandolo al contatto
			$query = "INSERT INTO Bambini (FK_contatto, Nome, Cognome, Data_di_nascita, Note) VALUES ('$ID_contatto', '$Nome', '$Cognome', '$Data_di_nascita', '$Note')";
			$result = mysqli_query($dbc, $query) or die('crea_bambino.php: Error querying database - 3');
		
// se indicata nel form, associa attivita' a bambino
			if ($Nome_Attivita!="") {

// recupera ID bambino
				$query = "SELECT * FROM Bambini WHERE Bambini.Cognome = '$Cognome' AND Bambini.Nome = '$Nome' AND Bambini.FK_contatto = '$ID_contatto'";
				$result = mysqli_query($dbc, $query) or die('crea_bambino.php: Error querying database - 4');
				$row = mysqli_fetch_array($result); 
				$ID_Bambino = $row['ID_Bambino'];

// recupera ID attivita'
				$query = "SELECT * FROM Lista_Attivita_Adesioni " . "WHERE (((Lista_Attivita_Adesioni.Nome_Attivita) LIKE '%" . $Nome_Attivita . "%')) ";
				$result = mysqli_query($dbc, $query) or die('crea_bambino.php: Error querying database - 5');			
				$row = mysqli_fetch_array($result); 
				$ID_Attivita = $row['ID_attivita'];


// crea associazione Bambino-attivita nella tablella Adesioni
				$query = "INSERT INTO Adesioni (FK_bambino, FK_attivita, Stato, Note) VALUES ('$ID_Bambino', '$ID_Attivita', '$Stato_Adesione', '$Note_Adesione')";
				$result = mysqli_query($dbc, $query) or die('crea_bambino.php: Error querying database - 6');	
			}
	
			echo "<div class=\"main\">";
			echo "<table bgcolor=#FFFFFF>";

// mostra righe appena create

				$query = MYSQLI_BAMBINI_COMPLETO . MYSQLI_STD_FROM . "WHERE Bambini.Cognome = '$Cognome' AND Bambini.Nome = '$Nome';";
				$result = mysqli_query($dbc, $query) or die('crea_bambino.php: Error querying database - 7');
				
				$table = array();
				$tbl_pnt=0;
				while ($row = mysqli_fetch_array($result)) {
					$table[$tbl_pnt]=$row;
					$tbl_pnt+=1;
				}
	
				$tbl_len=count($table);
	
				$titoli=TITOLI_TABELLA_BAMBINI_COMPLETO;
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

			echo "</table>";
			echo "</div>";
	
			echo "<div class=\"info\">";
				echo "l'anagrafica bambino '$Cognome' '$Nome' e' stata creata";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<a href = \"crea_bambino_main.php\">Crea altra anagrafica bambino</a>";
				echo "<br>";
				echo "<a href = \"gestione_anagrafiche.html\">Torna a gestione anagrafiche</a>";
				echo "<br>";
				echo "<a href = \"index.html\">Torna al menu principale</a>";
			echo "</div>";
		}
	}

	mysqli_close($dbc);

?>

</body>
</html>
