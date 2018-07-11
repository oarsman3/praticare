<?php
	session_start();
	include 'definizioni.php';
	include 'dbQueries.php';
	include 'makeTables.php';
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
		<div class="firstoption"><a href ="ricerche.php">Nuova ricerca</a></div>
		
		<div class="nextoption"><a href = "export.php">Esporta in CSV</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
	</div>

<?php

	$Attivita 							= $_POST['Attivita'];
	$Contatto 							= $_POST['Contatto'];
	$Cognome_Nome_Referente		 		= $_POST['Referente'];
	$Cognome_Nome_Bambino 				= $_POST['Bambino'];
	$Ordine_Alfabetico					=(isset($_POST['Ordine_Alfabetico'])?True:False);
	$Ordine_Cronologico					=(isset($_POST['Ordine_Cronologico'])?True:False);
	$Ordine_Sort 						= $_POST['Ordine_Sort'];
//	$Dettaglio 							= $_POST['Dettaglio'];
	$Pivot 								= $_POST['Pivot'];
	
	$_SESSION['Attivita'] 				= $Attivita;
	$_SESSION['Contatto']				= $Contatto;
	$_SESSION['Cognome_Nome_Referente']	= $Cognome_Nome_Referente;
	$_SESSION['Cognome_Nome_Bambino']	= $Cognome_Nome_Bambino;
	$_SESSION['Ordine_Alfabetico'] 		= $Ordine_Alfabetico;
	$_SESSION['Ordine_Cronologico'] 	= $Ordine_Cronologico;
	$_SESSION['Ordine_Sort'] 			= $Ordine_Sort;
//	$_SESSION['Dettaglio']				= $Dettaglio;
	$_SESSION['Pivot']					= $Pivot;

	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB) or die('Error connecting to MySQL server.');
	
	if($Pivot) {
	
		$tableContatti		= array();
		$tableReferenti		= array();
		$tableBambini		= array();
		$tableActReferenti	= array();
		$tableActBambini	= array();
		$emptyTable			= array();					// tabella vuota per il merge delle righe referenti e bambini appartenenti allo stesso contatto
		$bigTable			= array();					// tabellona con le tabelle contatto, referente e bambini compresse e inficcate dentro senza ripetizioni qualsivoglia
		
		if ($Attivita!=TUTTI) {
	
			$tableBambini	= createTblBambini	(BY_ATTIVITA_ID, $Attivita, FILLER, COMPLETO);
			$tableReferenti = createTblReferenti(BY_ATTIVITA_ID, $Attivita, FILLER, COMPLETO);
			mergeAttTables (0, $bigTable, 7, $tableReferenti, 7, $tableBambini);	

		}

		elseif ($Contatto!=TUTTI) {
		
			$tableContatti	= createTblContatti	(BY_NAME,		$Contatto, 									FILLER, COMPLETO);
			$tableReferenti = createTblReferenti(BY_CONTACT_ID,	$tableContatti[0][SRC_COMPL_CONTATTO_ID],	FILLER, COMPLETO);
			$tableBambini	= createTblBambini	(BY_CONTACT_ID,	$tableContatti[0][SRC_COMPL_CONTATTO_ID],	FILLER, COMPLETO);
			
			mergeTables (0,		$bigTable,							// start writing bigTable from row 0
						 0,		$tableContatti,						// write data 'Contatto' from col 0
						 6,		$tableReferenti,					// write data 'Referente' from col 6 ('Contatto' is 6 fields)
						 20,	$tableBambini);						// write data 'Bambino' from col 20 ('Referente' is 14 fields)
		
		}
		else if ($Cognome_Nome_Referente!=TUTTI) {

			$appo		= explode(STRNGSEP,$Cognome_Nome_Referente);
			$cognomeRef	= $appo[0];
			$nomeRef	= $appo[1];
	
			$tableReferenti = createTblReferenti(BY_NAME, $cognomeRef, $nomeRef, COMPLETO);
			$tbl_len		= count($tableReferenti);
			$tbl_pnt 		= 0;
			$tbl			= array();
			$bigTblPtr		= 0;
			$fkContatto		= 0;
			while ($tbl_pnt<$tbl_len) {
			
				$tbl[0] = $tableReferenti[$tbl_pnt];

				if ($fkContatto != $tableReferenti[$tbl_pnt][SRC_COMPL_REF_FK_CONTATTO]) {
					$tableContatti = createTblContatti (BY_CONTACT_ID,	$tbl[0][SRC_COMPL_REF_FK_CONTATTO],	FILLER, COMPLETO);
					$tableBambini = createTblBambini	(BY_CONTACT_ID,	$tbl[0][SRC_COMPL_REF_FK_CONTATTO],	FILLER, COMPLETO);
					$bigTblPtr += mergeTables ($bigTblPtr,	$bigTable, 0, $tableContatti, 6, $tbl, 20, $tableBambini);
				}
				else {
					$bigTblPtr += mergeTables ($bigTblPtr,	$bigTable, 0, $emptyTable, 6, $tbl, 20, $emptyTable);
				}

				$fkContatto = $tableReferenti[$tbl_pnt][SRC_COMPL_REF_FK_CONTATTO];
				$bigTblPtr++;
				$tbl_pnt++;
			}			
		}
		else if ($Cognome_Nome_Bambino!=TUTTI) {
	
			$appo			= explode(STRNGSEP,$Cognome_Nome_Bambino);
			$cognomeBamb	= $appo[0];
			$nomeBamb		= $appo[1];
	
			$tableBambini	= createTblBambini	(BY_NAME, $cognomeBamb, $nomeBamb, COMPLETO);
			$tbl_len		= count($tableBambini);
			$tbl_pnt 		= 0;
			$tbl			= array();
			$bigTblPtr		= 0;
			$fkContatto		= 0;
			while ($tbl_pnt<$tbl_len) {

				$tbl[0] = $tableBambini[$tbl_pnt];

				if ($fkContatto != $tableBambini[$tbl_pnt][SRC_COMPL_BAMB_FK_CONTATTO]) {
					$tableContatti = createTblContatti	(BY_CONTACT_ID, $tbl[0][SRC_COMPL_BAMB_FK_CONTATTO],	FILLER, COMPLETO);
					$tableReferenti = createTblReferenti (BY_CONTACT_ID, $tbl[0][SRC_COMPL_BAMB_FK_CONTATTO],	FILLER, COMPLETO);
					$bigTblPtr += mergeTables ($bigTblPtr,	$bigTable, 0, $tableContatti, 6, $tableReferenti, 20, $tbl);
				}
				else {
					$bigTblPtr += mergeTables ($bigTblPtr,	$bigTable, 0, $emptyTable, 6, $emptyTable, 20, $tbl);
				}

				$fkContatto = $tableBambini[$tbl_pnt][SRC_COMPL_BAMB_FK_CONTATTO];
				$bigTblPtr++;
				$tbl_pnt++;
			}
		}
		
		else {	// full data
			
			$tableContatti	= createTblContatti	(BY_NAME, TUTTI, FILLER, COMPLETO);
			$bigTableRowOffs=0;
			$tbl_len=count($tableContatti);
			$tbl_pnt=0;
			while($tbl_pnt<$tbl_len){
				$tableReferenti = createTblReferenti(BY_CONTACT_ID, $tableContatti[$tbl_pnt][SRC_COMPL_CONTATTO_ID], FILLER, COMPLETO);
				$tableBambini	= createTblBambini	(BY_CONTACT_ID, $tableContatti[$tbl_pnt][SRC_COMPL_CONTATTO_ID], FILLER, COMPLETO);
				$appTableContatti[0]=$tableContatti[$tbl_pnt];
				mergeTables ($bigTableRowOffs,	$bigTable, 0, $appTableContatti, 6, $tableReferenti, 20, $tableBambini);
				$bigTableRowOffs+=(max(count($appTableContatti),count($tableReferenti),count($tableBambini)));
				$tbl_pnt++;
			}
	
		}
	
		echo "<div class=\"main\">";
		echo "<table bgcolor=#FFFFFF>";
		
		if ($Attivita!=TUTTI) {
		
			echo "<tr>" . TITOLI_ATTIVITA_COMPLETO . "</tr>";	
			
			$tbl_len=count($bigTable);
			$row_len = LEN_ATTIVITA_COMPLETO;
			$tbl_pnt=0;
			$color='#EFF2FB';
			while ($tbl_pnt < $tbl_len) {
				$row_pnt=0;
				if ($bigTable[$tbl_pnt][8]!="") {								// cambia bgcolor quando cambia il contatto
					$color=($color=='#FFFFFF')? '#EFF2FB' : '#FFFFFF';
				}
				echo "<tr bgcolor=$color>";
			
				while ($row_pnt<$row_len) {
					echo "<td>" . $bigTable[$tbl_pnt][$row_pnt] . "</td>";
					$row_pnt++;
				}
				echo "</tr>";
				$tbl_pnt++;
			}
		}
		else {
		
			echo "<tr>" . TITOLI_CONTATTO_COMPLETO . TITOLI_REFERENTE_COMPLETO . TITOLI_BAMBINO_COMPLETO . "</tr>";
	
			$tbl_len=count($bigTable);
			$row_len = LEN_CONTATTO_COMPLETO + LEN_REFERENTE_COMPLETO + LEN_BAMBINO_COMPLETO;
			$tbl_pnt=0;
			$color='#EFF2FB';
			while ($tbl_pnt < $tbl_len) {
				$row_pnt=0;
				if ($bigTable[$tbl_pnt][1]!="") {								// cambia bgcolor quando cambia il contatto
					$color=($color=='#FFFFFF')? '#EFF2FB' : '#FFFFFF';
				}
				echo "<tr bgcolor=$color>";
			
				while ($row_pnt<$row_len) {
					echo "<td>" . $bigTable[$tbl_pnt][$row_pnt] . "</td>";
					$row_pnt++;
				}
				echo "</tr>";
				$tbl_pnt++;
			}
		}
		
		echo "</table>";
		echo "</div>";
		
	}	// end Pivot
	
	else {	// NOT Pivot, Ricerca Classic
	
		if ($Attivita!=TUTTI) {
		
			$query = MYSQLI_ATTIVITA_COMPLETO . MYSQLI_STD_FROM .
					"WHERE (((Lista_Attivita_Adesioni.Nome_Attivita) Like '%" . $Attivita . "%')) ";
			$titoli = TITOLI_TABELLA_ATTIVITA_COMPLETO;
		}
		
		else if ($Contatto!=TUTTI) {
		
			$query = MYSQLI_CONTATTI_COMPLETO . MYSQLI_STD_FROM .
					"WHERE (((Anagrafica_Contatto.Identificativo) Like '%" . $Contatto . "%')) ";
			$titoli = TITOLI_TABELLA_CONTATTI_COMPLETO;	
		}
		
		else if ($Cognome_Nome_Referente!=TUTTI) {
		
			$ref		= explode(STRNGSEP,$Cognome_Nome_Referente);
			$cognomeRef	= $ref[0];
			$nomeRef	= $ref[1];
	
			$query = MYSQLI_REFERENTI_COMPLETO . MYSQLI_STD_FROM .
					"WHERE (((Anagrafica_Referente.Cognome_Ref) Like '%" . $cognomeRef . "%') AND ((Anagrafica_Referente.Nome_Ref) Like '%" . $nomeRef . "%')) ";
			$titoli = TITOLI_TABELLA_REFERENTI_COMPLETO;		
		}
		
		else if ($Cognome_Nome_Bambino!=TUTTI) {
		
			$ref			= explode(STRNGSEP,$Cognome_Nome_Bambino);
			$cognomeBamb	= $ref[0];
			$nomeBamb		= $ref[1];
	
			$query = MYSQLI_BAMBINI_COMPLETO . MYSQLI_STD_FROM .
					"WHERE (((Bambini.Cognome) Like '%" . $cognomeBamb . "%') AND ((Bambini.Nome) Like '%" . $nomeBamb . "%')) ";
			$titoli = TITOLI_TABELLA_BAMBINI_COMPLETO;
		}
		
		else {	// full data
		
			$query =	MYSQLI_FULL_DATA_COMPLETO . MYSQLI_STD_FROM;

			$query .= (" ORDER BY Anagrafica_Contatto.");
			
			if ($Ordine_Alfabetico) {
				$query .= ("Identificativo ");
				if ($Ordine_Cronologico) {
					$query .= (",Anagrafica_Contatto.ID_Contatto ");
				}
			}	
			else if ($Ordine_Cronologico) {
				$query .= ("ID_Contatto ");
			}
			else {
				$query .= ("Identificativo ");
			}
			
			$query .= (($Ordine_Sort=='DECRESCENTE')?"DESC;":";");
			
			$titoli = TITOLI_TABELLA_FULL_DATA_COMPLETO;

		}
		
		$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
		or die('Error connecting to MySQL server.');
															
		$result = mysqli_query($dbc, $query)
		or die('ricerche.psp: error querying DB Praticare');
		
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
	
			echo "$titoli";
			
			$tbl_pnt=0;
			
			while ($tbl_pnt < $tbl_len) {
				$row_pnt=0;
				$row_len = count($table[0]) / 2;		// it's an associated array (ie. fieldname=>value), therefore row len must be divided by 2
				if ($row_len>0) {
					$color=($tbl_pnt % 2 != 0)? '#EFF2FB' : '#FFFFFF';
					echo "<tr bgcolor=$color>";
					while ($row_pnt<$row_len) {
						echo "<td>" . $table[$tbl_pnt][$row_pnt] . "</td>";
						$row_pnt += 1;
					}
					echo "</tr>";
				}
				$tbl_pnt += 1;
			}
			echo "</table>";
			echo "</div>";
		}
		else {
			echo "*** non esistono righe corrispondenti al criterio di ricerca ***";
		}
	}	
	mysqli_close($dbc);	

?>

</body>
</html>
