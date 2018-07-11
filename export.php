<?php
	session_start();
	include 'definizioni.php';
	include 'dbQueries.php';
	include 'makeTables.php';


	$ricerca = $_SESSION['ricerca'];
	$_SESSION['ricerca']= "";
	$Attivita = $_SESSION['Attivita'];
	$_SESSION['Attivita']= "";
	$Cognome_Bambino = $_SESSION['Cognome_Bambino'];
	$_SESSION['Cognome_Bambino']= "";
	$Contatto = $_SESSION['Contatto'];
	$_SESSION['Contatto'] = "";
	$Cognome_Referente = $_SESSION['Cognome_Referente'];	
	$_SESSION['Cognome_Referente'] = "";
	$Dettaglio = $_SESSION['Dettaglio'];
	$_SESSION['Dettaglio'] = "";
	$Ordine_Alfabetico = $_SESSION['Ordine_Alfabetico'];
	$_SESSION['Ordine_Alfabetico'] = "";
	$Ordine_Cronologico = $_SESSION['Ordine_Cronologico'];
	$_SESSION['Ordine__Cronologico'] = "";
	$Ordine_Sort = $_SESSION['Ordine_Sort'];
	$_SESSION['Ordine_Sort'] = "";
	$Pivot = $_SESSION['Pivot'];
	$_SESSION['Pivot'] = "";
		
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
    or die('Export.php: Error connecting to MySQL server.');

	if($Pivot) {

		$tableContatti	= array();
		$tableReferenti = array();
		$tableBambini	= array();
		$bigTable		= array();					// tabellona con le tre tabelle contatto, referente e bambini compresse e inficcate dentro senza ripetizioni qualsivoglia
		
		if ($Attivita!=TUTTI) {
// t.b.d.
		}
		
		elseif ($Contatto!=TUTTI) {
	
			$_SESSION['Contatto'] = $Contatto;
	
			$tableContatti	= createTblContatti	(BY_NAME,		$Contatto,									COMPLETO);
			$tableReferenti = createTblReferenti(BY_CONTACT_ID,	$tableContatti[0][SRC_COMPL_CONTATTO_ID],	COMPLETO);
			$tableBambini	= createTblBambini	(BY_CONTACT_ID,	$tableContatti[0][SRC_COMPL_CONTATTO_ID],	COMPLETO);
			
			mergeTables (0,		$bigTable,							// start writing Table from row 0
						 0,		$tableContatti,						// write data 'Contatto' from col 0
						 6,		$tableReferenti,					// write data 'Referente' from col 6 ('Contatto' is 6 fields long)
						 19,	$tableBambini);						// write data 'Bambino' from col 19 ('Referente' is 13 fields long)
		
		}
		else if ($Cognome_Referente!=TUTTI) {
	
			$_SESSION['Cognome_Referente'] = $Cognome_Referente;
	
			$tableReferenti = createTblReferenti(BY_NAME,		$Cognome_Referente,								COMPLETO);
			$tableContatti	= createTblContatti	(BY_CONTACT_ID,	$tableReferenti[0][SRC_COMPL_REF_FK_CONTATTO],	COMPLETO);
			$tableBambini	= createTblBambini	(BY_CONTACT_ID,	$tableReferenti[0][SRC_COMPL_REF_FK_CONTATTO],	COMPLETO);
	
			mergeTables (0,	$bigTable, 0, $tableContatti, 6, $tableReferenti, 19, $tableBambini);
			
		}
		else if ($Cognome_Bambino!=TUTTI) {
	
			$_SESSION['Cognome_Bambino'] = $Cognome_Bambino;
			
			$tableBambini	= createTblBambini	(BY_NAME,		$Cognome_Bambino,								COMPLETO);
			$tableContatti	= createTblContatti	(BY_CONTACT_ID,	$tableBambini[0][SRC_COMPL_BAMB_FK_CONTATTO],	COMPLETO);
			$tableReferenti = createTblReferenti(BY_CONTACT_ID,	$tableBambini[0][SRC_COMPL_BAMB_FK_CONTATTO],	COMPLETO);
	
			mergeTables (0,	$bigTable, 0, $tableContatti, 6, $tableReferenti, 19, $tableBambini);
			
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
				mergeTables ($bigTableRowOffs,	$bigTable, 0, $appTableContatti, 6, $tableReferenti, 20, $tableBambini);
				$bigTableRowOffs+=(max(count($appTableContatti),count($tableReferenti),count($tableBambini)));
				$tbl_pnt++;
			}
		}
		
		$tbl_len=count($bigTable);
		
		if ($tbl_len>0) {
				
			$csv = ""; 
			$delim = "";
	
//recupero i nomi dei campi che occuperanno la prima riga del csv
			foreach($titoli_csv as $v) {
				$csv .= $delim . '"' . str_replace('"', '""', $v) . '"';
				$delim= ";";
			}
			$csv .= "\n";
		
//recupero i valori dei campi
			$tbl_pnt=0;		
			while ($tbl_pnt < $tbl_len) {
				$elm=$bigTable[$tbl_pnt];
				$delim = "";
				foreach($elm as $v) {
					if($v==""){
						$v="  ";
					}
					$csv .= $delim . '"' . str_replace('"', '""', $v) . '"';
					$delim = ";";
				}
				$tbl_pnt++;
				$csv .= "\n"; 
			}
		}
	}	// fine ricerca stile "Pivot"

	else {	// ricerca stile "Classic"
		switch ($ricerca) {
		
		case 'ATTIVITA':
			$query = ($Dettaglio=='COMPLETO'? MYSQLI_ATTIVITA_COMPLETO : MYSQLI_ATTIVITA_SINTESI) . MYSQLI_STD_FROM .
																"WHERE (((Lista_Attivita_Adesioni.Nome_Attivita) Like '%" . $Attivita . "%')) ";
	
			if (!$Ordine_Alfabetico and !$Ordine_Cronologico) {
				$query .= "ORDER BY Lista_Attivita_Adesioni.Nome_Attivita ";
			}
			else {
				$query .= "ORDER BY ";
				if ($Ordine_Alfabetico) {
					$query .= ("Lista_Attivita_Adesioni.Nome_Attivita ");
					if ($Ordine_Cronologico) {
						$query .= (",Lista_Attivita_Adesioni.ID_Attivita ");
					}
				}
				else if ($Ordine_Cronologico) {
					$query .= ("Lista_Attivita_Adesioni.ID_Attivita ");
				}
			}
			$_SESSION['Attivita'] = $Attivita;
			break;
			
		case 'STATO_CONTATTI':
			$query =	($Dettaglio=='COMPLETO'? MYSQLI_CONTATTI_COMPLETO : MYSQLI_CONTATTI_SINTESI) . MYSQLI_STD_FROM .
																			"WHERE (((Anagrafica_Contatto.Identificativo) Like '%" . $Contatto . "%')) ";		
																			
			if (!$Ordine_Alfabetico and !$Ordine_Cronologico) {
				$query .= "ORDER BY Anagrafica_Contatto.Identificativo ";
			}
			else {
				$query .= "ORDER BY ";
				if ($Ordine_Alfabetico) {
					$query .= ("Anagrafica_Contatto.Identificativo ");
					if ($Ordine_Cronologico) {
						$query .= (",Anagrafica_Contatto.ID_Contatto ");
					}
				}
				else if ($Ordine_Cronologico) {
					$query .= ("Anagrafica_Contatto.ID_Contatto ");
				}
			}
			$_SESSION['Contatto'] = $Contatto;
			break;
			
		case 'STATO_REFERENTI':
			$query =	($Dettaglio=='COMPLETO'? MYSQLI_REFERENTI_COMPLETO : MYSQLI_REFERENTI_SINTESI) . MYSQLI_STD_FROM .
																	"WHERE (((Anagrafica_Referente.Cognome_Ref) Like '%" . $Cognome_Referente . "%')) ";		
																			
			if (!$Ordine_Alfabetico and !$Ordine_Cronologico) {
				$query .= "ORDER BY Anagrafica_Referente.Cognome_Ref ";
			}
			else {
				$query .= "ORDER BY ";
				if ($Ordine_Alfabetico) {
					$query .= ("Anagrafica_Referente.Cognome_Ref ");
					if ($Ordine_Cronologico) {
						$query .= (",Anagrafica_Referente.ID_Referente ");
					}
				}
				else if ($Ordine_Cronologico) {
					$query .= ("Anagrafica_Referente.ID_Referente ");
				}
			}
			$_SESSION['Cognome_Referente'] = $Cognome_Referente;
			break;
			
		case 'STATO_BAMBINI':
			$query =	($Dettaglio=='COMPLETO'? MYSQLI_BAMBINI_COMPLETO : MYSQLI_BAMBINI_SINTESI) . MYSQLI_STD_FROM .
																						"WHERE (((Bambini.Cognome) Like '%" . $Cognome_Bambino . "%')) ";
																			
			if (!$Ordine_Alfabetico and !$Ordine_Cronologico) {
				$query .= "ORDER BY Bambini.Cognome ";
			}
			else {
				$query .= "ORDER BY ";
				if ($Ordine_Alfabetico) {
					$query .= ("Bambini.Cognome ");
					if ($Ordine_Cronologico) {
						$query .= (",Bambini.ID_Bambino ");
					}
				}
				else if ($Ordine_Cronologico) {
					$query .= ("Bambini.ID_Bambino ");
				}
			}
			$_SESSION['Cognome_Bambino'] = $Cognome_Bambino;
			break;
			
		case 'FULL_DATA':
			$query =	MYSQLI_FULL_DATA_COMPLETO . MYSQLI_STD_FROM;
																			
			if (!$Ordine_Alfabetico and !$Ordine_Cronologico) {
				$query .= "ORDER BY Anagrafica_Contatto.Identificativo ";
			}
			else {
				$query .= "ORDER BY ";
				if ($Ordine_Alfabetico) {
					$query .= ("Anagrafica_Contatto.Identificativo ");
					if ($Ordine_Cronologico) {
						$query .= (",Anagrafica_Contatto.ID_Contatto ");
					}
				}
				else if ($Ordine_Cronologico) {
					$query .= ("Anagrafica_Contatto.ID_Contatto ");
				}
			}		
			break;
			
		default:	
			break;
		}
	
		$query .= (($Ordine_Sort=='DECRESCENTE')?"DESC;":";");
		
		$result = mysqli_query($dbc, $query)
		or die('Export.php: Error querying DB praticare -01');
		
		$table = array();
	
	// copia risultato della query in tabella
	
		$tbl_pnt=0;
		while ($row = mysqli_fetch_array($result)) {
			$table[$tbl_pnt]=$row;
			$tbl_pnt++;
		}

		$tbl_len=count($table);
			
		if ($tbl_len>0) {
				
			$csv = ""; 
			$delim = "";
	
//recupero i nomi dei campi che occuperanno la prima riga del csv
	
			$elm=$table[0];
			$i=0;
			foreach($elm as $k => $v) {
				if ($i%2!=0) {								// scrive solo i campi dispari, altrimenti scrive due volte
					$csv .= $delim . '"' . str_replace('"', '""', $k) . '"';
					$delim= ";";
				}
				$i++;
			}
			$csv .= "\n";
		
//recupero i valori dei campi
			$tbl_pnt=0;		
			while ($tbl_pnt < $tbl_len) {
				$elm=$table[$tbl_pnt];
				$delim = "";
				$i=0;
				foreach($elm as $v) {
					if ($i%2!=0){
						$csv .= $delim . '"' . str_replace('"', '""', $v) . '"';
						$delim = ";";
					}
					$i++;
				}
				$tbl_pnt += 1;
				$csv .= "\n"; 
			}
		}
	}	// end export ricerca Classic
		
// invia al browser l'estrazione in csv
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=".export2.".csv");
	echo $csv;

	mysqli_close($dbc);
?>