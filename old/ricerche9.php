<?php
	session_start();
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
		<h2>Ricerche</h2>
	</div>

	<div class="toolbar">
		<br />
		<a href ="ricerche.html">Nuova ricerca</a>
		<br />
		<br />
		<a href ="index.html">Torna alla pagina iniziale</a>
		<br />
		<br />
		<br />
		<br />
		<a href = "export.php">Esporta in CSV</a>
	</div>

<?php

	$Stato_Attivita = $_POST['Stato_Attivita'];
	$Contatto = $_POST['Contatto'];
	$Cognome_Referente = $_POST['Cognome_Referente'];
	$Cognome_Bambino = $_POST['Cognome_Bambino'];
	$Ordine = $_POST['Ordine'];
	$Dettaglio = $_POST['Dettaglio'];
	
	$_SESSION['Ordine'] = $Ordine;
	$_SESSION['Dettaglio'] = $Dettaglio;
	
	
	if (!empty($Stato_Attivita)) {
		$ricerca = 'STATO_ATTIVITA';
	}
	else if (!empty($Contatto)) {
		$ricerca = 'STATO_CONTATTI';
	}
	else if (!empty($Cognome_Referente)) {
		$ricerca = 'STATO_REFERENTI';
	}
	else if (!empty($Cognome_Bambino)) {
		$ricerca = 'STATO_BAMBINI';
	}
	else {
		$ricerca = 'FULL_DATA';
	}	
	
	$_SESSION['ricerca'] = $ricerca;				/* salva tipo di ricerca in caso di export csv */
	
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
    or die('Error connecting to MySQL server.');

	switch ($ricerca) {
	case 'STATO_ATTIVITA':
		$query =	($Dettaglio=='COMPLETO'? MYSQLI_ATTIVITA_COMPLETO : MYSQLI_ATTIVITA_SINTESI) . MYSQLI_STD_FROM .
															"WHERE (((Lista_Attivita_Adesioni.Nome_Attivita) Like '%" . $Stato_Attivita . "%'));";		
		$_SESSION['Adesioni_Attivita'] = $Adesioni_Attivita;
		break;
		
	case 'STATO_CONTATTI':
		$query =	($Dettaglio=='COMPLETO'? MYSQLI_CONTATTI_COMPLETO : MYSQLI_CONTATTI_SINTESI) . MYSQLI_STD_FROM .
																		"WHERE (((Anagrafica_Contatto.Identificativo) Like '%" . $Contatto . "%'));";		
		$_SESSION['Contatto'] = $Contatto;
		break;
		
	case 'STATO_REFERENTI':
		$query =	($Dettaglio=='COMPLETO'? MYSQLI_REFERENTI_COMPLETO : MYSQLI_REFERENTI_SINTESI) . MYSQLI_STD_FROM .
																"WHERE (((Anagrafica_Referente.Cognome_Ref) Like '%" . $Cognome_Referente . "%'));";		
		$_SESSION['Cognome_Referente'] = $Cognome_Referente;
		break;
		
	case 'STATO_BAMBINI':
		$query =	($Dettaglio=='COMPLETO'? MYSQLI_BAMBINI_COMPLETO : MYSQLI_BAMBINI_SINTESI) . MYSQLI_STD_FROM .
																					"WHERE (((Bambini.Cognome) Like '%" . $Cognome_Bambino . "%'));";
		$_SESSION['Cognome_Bambino'] = $Cognome_Bambino;
		break;
		
	case 'FULL_DATA':
		$query =	MYSQLI_FULL_DATA_COMPLETO . MYSQLI_STD_FROM . "ORDER BY Anagrafica_Contatto.ID_Contatto;";
		break;
		
	default:	
		break;
	}
	
	$result = mysqli_query($dbc, $query)
    or die('Error querying table Anagrafica_contatto.');
	
	$table = array();

	$tbl_pnt=0;
	while ($row = mysqli_fetch_array($result)) {
		$table[$tbl_pnt]=$row;
		$tbl_pnt+=1;
	}

	$tbl_len=count($table);
	
	if ($tbl_len>0) {
	
		echo "<div class=\"main\">";
		echo "<table bgcolor=#FFFFFF>";

		switch ($ricerca) {
			case 'STATO_ATTIVITA':
				$titoli=($Dettaglio=='COMPLETO'? TITOLI_TABELLA_ATTIVITA_COMPLETO : TITOLI_TABELLA_ATTIVITA_SINTESI);
			break;
			
		case 'STATO_CONTATTI':
				$titoli=($Dettaglio=='COMPLETO'? TITOLI_TABELLA_CONTATTI_COMPLETO : TITOLI_TABELLA_CONTATTI_SINTESI);
			break;
			
		case 'STATO_REFERENTI':
				$titoli=($Dettaglio=='COMPLETO'? TITOLI_TABELLA_REFERENTI_COMPLETO : TITOLI_TABELLA_REFERENTI_SINTESI);
			break;
			
		case 'STATO_BAMBINI':
				$titoli=($Dettaglio=='COMPLETO'? TITOLI_TABELLA_BAMBINI_COMPLETO : TITOLI_TABELLA_BAMBINI_SINTESI);
			break;
			
		case 'FULL_DATA':
				$titoli=TITOLI_TABELLA_FULL_DATA_COMPLETO;
			break;
		}
		
		echo "$titoli";
		
		$tbl_pnt=0;
		
		while ($tbl_pnt < $tbl_len) {
								
			$row_pnt=0;
			$row_len = count($table[0]) / 2;		// it's an associated array (ie. fieldname=>value), therefore row len must be divided by 2
			
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
	}
	else {
		echo "*** non esistono righe corrispondenti al criterio di ricerca ***";
	}
	mysqli_close($dbc);
?>

</body>
</html>
