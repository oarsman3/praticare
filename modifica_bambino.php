<?php
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare Il Futuro - Modifica Bambino</title>
  
  <link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>
	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Modifica Bambino</h2>
	</div>

	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

<?php

	$Bambino			= $_POST['Bambino'];
	$cognome			= strtok($Bambino, STRNGSEP);
	$nome				= "";
	$toc				= strtok(STRNGSEP);
	while ($toc !== false) {
		$nome .= $toc . " ";
		$toc = strtok(STRNGSEP);
	}
	$nome = rtrim($nome," ");
	
	$Contatto					= $_POST['Contatto'];
	$Nome						= $_POST['Nome'];
	$Cognome					= $_POST['Cognome'];
	$Data_di_nascita			= $_POST['Data_di_nascita'];
	$Note						= $_POST['Note'];
	$Nome_Attivita				= $_POST['Nome_Attivita'];
	$Stato_Adesione				= $_POST['Stato_Adesione'];
	$Note_Adesione				= $_POST['Note_Adesione'];
				
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
							or die('Error connecting to MySQL server.');

	echo "<div class=\"main\">";
	echo "<table bgcolor=#FFFFFF>";

		$query = "UPDATE Bambini SET Nome = '$Nome',	Cognome = '$Cognome', Data_di_nascita = '$Data_di_nascita', Note = '$Note' " . 
				 "WHERE Nome LIKE '$Nome' AND Cognome LIKE '$Cognome' AND FK_Contatto LIKE (SELECT ID_Contatto FROM Anagrafica_Contatto WHERE Identificativo LIKE '$Contatto') ";
				 
		$result = mysqli_query($dbc, $query)
					or die('modifica_referente.php: Error querying database - 1');		

		$query = "UPDATE Adesioni SET FK_attivita = (SELECT ID_attivita FROM Lista_Attivita_Adesioni WHERE Nome_Attivita LIKE '$Nome_Attivita'), Stato = '$Stato_Adesione', Note = '$Note_Adesione' " .
				 "WHERE FK_Bambino = (SELECT ID_Bambino FROM Bambini WHERE Nome LIKE '$Nome' AND Cognome LIKE '$Cognome' AND FK_Contatto LIKE (SELECT ID_Contatto FROM Anagrafica_Contatto WHERE Identificativo LIKE '$Contatto')) ";

		$result = mysqli_query($dbc, $query)
					or die('modifica_referente.php: Error querying database - 2');		

// mostra riga contatto appena modificata

/*
		$query = MYSQLI_CONTATTI_COMPLETO . MYSQLI_STD_FROM . "WHERE Nome_Ref LIKE '$nomeRef' AND Cognome_Ref LIKE '$cognomeRef' AND Anagrafica_Referente.FK_Contatto LIKE (SELECT ID_Contatto FROM Anagrafica_Contatto WHERE Identificativo LIKE '$Contatto') ";


		$result = mysqli_query($dbc, $query)
							or die('modifica_referente.php: Error querying database - 3');
							
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
*/
		
		mysqli_close($dbc);

	echo "</table>";
	echo "</div>";

	echo "<div class=\"info\">";
		echo "Il referente e' stato modificato";
		echo "<br>";
		echo "<br>";
		echo "<a href = \"modifica_referente_main.php\">modifica altro referente</a>";
		echo "<br>";
		echo "<a href = \"gestione_anagrafiche\">torna a gestione anagrafiche</a>";
		echo "<br>";
		echo "<a href = \"index.html\">Torna al menu principale</a>";		
	echo "</div>";

?>

</body>
</html>
