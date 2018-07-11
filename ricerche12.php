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
		<div class="firstoption"><a href ="ricerche.html">Nuova ricerca</a></div>
		
		<div class="nextoption"><a href = "export.php">Esporta in CSV</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
	</div>

<?php

	$Attivita 						= $_POST['Attivita'];
	$Contatto 						= $_POST['Contatto'];
	$Cognome_Referente 				= $_POST['Referente'];
	$Cognome_Bambino 				= $_POST['Bambino'];
	$Ordine_Alfabetico				=(isset($_POST['Ordine_Alfabetico'])?True:False);
	$Ordine_Cronologico				=(isset($_POST['Ordine_Cronologico'])?True:False);
	$Ordine_Sort 					= $_POST['Ordine_Sort'];
	$Dettaglio 						= $_POST['Dettaglio'];
	
	$_SESSION['Attivita'] 			= $Attivita;
	$_SESSION['Contatto']			= $Contatto;
	$_SESSION['Referente']			= $Cognome_Referente;
	$_SESSION['Bambino']			= $Cognome_Bambino;
	$_SESSION['Ordine_Alfabetico'] 	= $Ordine_Alfabetico;
	$_SESSION['Ordine_Cronologico'] = $Ordine_Cronologico;
	$_SESSION['Ordine_Sort'] 		= $Ordine_Sort;
	$_SESSION['Dettaglio']			= $Dettaglio;

	$tableContatti	= array();
	$tableReferenti = array();
	$tableBambini	= array();
	$bigTable		= array();					// tabellona con le tre tabelle contatto, referente e bambini compresse e inficcate dentro senza ripetizioni qualsivoglia
	
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB) or die('Error connecting to MySQL server.');
	
	if ($Attivita!=TUTTI) {
// t.b.d.
	}

	elseif ($Contatto!=TUTTI) {

		$_SESSION['Contatto'] = $Contatto;

		$tableContatti	= createTblContatti	(BY_NAME,		$Contatto,									COMPLETO);
		$tableReferenti = createTblReferenti(BY_CONTACT_ID,	$tableContatti[0][SRC_COMPL_CONTATTO_ID],	COMPLETO);
		$tableBambini	= createTblBambini	(BY_CONTACT_ID,	$tableContatti[0][SRC_COMPL_CONTATTO_ID],	COMPLETO);
		
		mergeTables (0,		$bigTable,							// start writing bigTable from row 0
					 0,		$tableContatti,						// write data 'Contatto' from col 0
					 6,		$tableReferenti,					// write data 'Referente' from col 6 ('Contatto' is 6 fields long)
					 17,	$tableBambini);						// write data 'Bambino' from col 17 ('Referente' is 11 fields long)
	
	}
	else if ($Cognome_Referente!=TUTTI) {

		$_SESSION['Cognome_Referente'] = $Cognome_Referente;

		$tableReferenti = createTblReferenti(BY_NAME,		$Cognome_Referente,								COMPLETO);
		$tableContatti	= createTblContatti	(BY_CONTACT_ID,	$tableReferenti[0][SRC_COMPL_REF_FK_CONTATTO],	COMPLETO);
		$tableBambini	= createTblBambini	(BY_CONTACT_ID,	$tableReferenti[0][SRC_COMPL_REF_FK_CONTATTO],	COMPLETO);

		mergeTables (0,	$bigTable, 0, $tableContatti, 6, $tableReferenti, 17, $tableBambini);
		
	}
	else if ($Cognome_Bambino!=TUTTI) {

		$_SESSION['Cognome_Bambino'] = $Cognome_Bambino;
		
		$tableBambini	= createTblBambini	(BY_NAME,		$Cognome_Bambino,								COMPLETO);
		$tableContatti	= createTblContatti	(BY_CONTACT_ID,	$tableBambini[0][SRC_COMPL_BAMB_FK_CONTATTO],	COMPLETO);
		$tableReferenti = createTblReferenti(BY_CONTACT_ID,	$tableBambini[0][SRC_COMPL_BAMB_FK_CONTATTO],	COMPLETO);

		mergeTables (0,	$bigTable, 0, $tableContatti, 6, $tableReferenti, 17, $tableBambini);
		
	}
	else {

		$tableContatti	= createTblContatti	(BY_NAME, TUTTI, COMPLETO);
		$bigTableRowOffs=0;
		$tbl_len=count($tableContatti);
		$tbl_pnt=0;
		while($tbl_pnt<$tbl_len){
			$tableReferenti = createTblReferenti(BY_CONTACT_ID, $tableContatti[$tbl_pnt][SRC_COMPL_CONTATTO_ID], COMPLETO);
			$tableBambini	= createTblBambini	(BY_CONTACT_ID, $tableContatti[$tbl_pnt][SRC_COMPL_CONTATTO_ID], COMPLETO);
			$appTableContatti[0]=$tableContatti[$tbl_pnt];
			mergeTables ($bigTableRowOffs,	$bigTable, 0, $appTableContatti, 6, $tableReferenti, 17, $tableBambini);
			$bigTableRowOffs+=(max(count($appTableContatti),count($tableReferenti),count($tableBambini)));
			$tbl_pnt++;
		}

	}

	echo "<div class=\"main\">";
	echo "<table bgcolor=#FFFFFF>";
	
	echo "<tr>" . TITOLI_CONTATTO_COMPLETO . TITOLI_REFERENTE_COMPLETO . TITOLI_BAMBINO_COMPLETO . "</tr>";

	$tbl_len=count($bigTable);
	$row_len = LEN_CONTATTO_COMPLETO + LEN_REFERENTE_COMPLETO + LEN_BAMBINO_COMPLETO;
	$tbl_pnt=0;
	$color='#EFF2FB';
	while ($tbl_pnt < $tbl_len) {
		$row_pnt=0;
		if ($bigTable[$tbl_pnt][0]!="") {
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
	
	echo "</table>";
	echo "</div>";

	mysqli_close($dbc);	

?>

</body>
</html>
