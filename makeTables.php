<?php

include 'definizioni.php';

function clearTable ($nrows,$ncols) {
	$row_pnt=0;
	while ($row_pnt < $nrows) {
		$col_pnt=0;
		while ($col_pnt<$ncols) {
			$bigTable[$row_pnt+$bigTableRowOffs][$col_pnt] = "";
			$col_pnt++;
		}
		$row_pnt++;
	}
}
	

function mergeTables ($bigTableRowOffs, &$bigTable, $colOffsContatto, $tableContatti, $colOffsRef, $tableReferenti,	$colOffsBamb, $tableBambini) {

/*
	$nrows=max(count($tableContatti),count($tableReferenti),count($tableBambini));
	$ncols=LEN_CONTATTO_COMPLETO + LEN_REFERENTE_COMPLETO + LEN_BAMBINO_COMPLETO;
	$row_pnt=0;
	while ($row_pnt < $nrows) {
		$col_pnt=0;
		while ($col_pnt<$ncols) {
			$bigTable[$row_pnt+$bigTableRowOffs][$col_pnt] = "";
			$col_pnt++;
		}
		$row_pnt++;
	}
*/

	$nrows=max(count($tableContatti),count($tableReferenti),count($tableBambini));
	
// scrivi in bigtable i dati del Contatto
									
	$tbl_len=count($tableContatti);
	clearTable($tbl_len,LEN_CONTATTO_COMPLETO);				// clear the table
	$tbl_pnt=0;		
	while ($tbl_pnt < $tbl_len) {
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsContatto+0]	= $tableContatti[$tbl_pnt][SRC_COMPL_CONTATTO_TIPO];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsContatto+1]	= $tableContatti[$tbl_pnt][SRC_COMPL_CONTATTO_NOME];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsContatto+2]	= $tableContatti[$tbl_pnt][SRC_COMPL_CONTATTO_PRIMO];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsContatto+3]	= $tableContatti[$tbl_pnt][SRC_COMPL_CONTATTO_CLIENTE];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsContatto+4]	= $tableContatti[$tbl_pnt][SRC_COMPL_CONTATTO_ULTIMO];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsContatto+5]	= $tableContatti[$tbl_pnt][SRC_COMPL_CONTATTO_NOTE];
		$tbl_pnt++;
	}

// scrivi in bigtable i dati del Referente
	
	$tbl_len=count($tableReferenti);
	clearTable($tbl_len,LEN_REFERENTE_COMPLETO);				// clear the table
	$tbl_pnt=0;		
	while ($tbl_pnt < $tbl_len) {
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsRef+0]		= $tableReferenti[$tbl_pnt][SRC_COMPL_REF_COGNOME];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsRef+1]		= $tableReferenti[$tbl_pnt][SRC_COMPL_REF_NOME];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsRef+2]		= $tableReferenti[$tbl_pnt][SRC_COMPL_REF_P_IVA];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsRef+3]		= $tableReferenti[$tbl_pnt][SRC_COMPL_REF_N_TEL];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsRef+4]		= $tableReferenti[$tbl_pnt][SRC_COMPL_REF_E_MAIL];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsRef+5]		= $tableReferenti[$tbl_pnt][SRC_COMPL_REF_INDIRIZZO];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsRef+6]		= $tableReferenti[$tbl_pnt][SRC_COMPL_REF_CAP];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsRef+7]		= $tableReferenti[$tbl_pnt][SRC_COMPL_REF_COMUNE];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsRef+8]		= $tableReferenti[$tbl_pnt][SRC_COMPL_REF_NOTE];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsRef+9]		= $tableReferenti[$tbl_pnt][SRC_COMPL_REF_TIPO_ATT];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsRef+10]	= $tableReferenti[$tbl_pnt][SRC_COMPL_REF_ATT];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsRef+11]	= $tableReferenti[$tbl_pnt][SRC_COMPL_REF_STATO_ADES];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsRef+12]	= $tableReferenti[$tbl_pnt][SRC_COMPL_REF_NUM_PARTEC];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsRef+13]	= $tableReferenti[$tbl_pnt][SRC_COMPL_REF_NOTE_ADES];
		$tbl_pnt++;
	}	
		
// scrivi in bigtable i dati del Bambino

	$tbl_len=count($tableBambini);
	clearTable($tbl_len,LEN_BAMBINO_COMPLETO);				// clear the table
	$tbl_pnt=0;		
	while ($tbl_pnt < $tbl_len) {
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+0]	= $tableBambini[$tbl_pnt][SRC_COMPL_BAMB_COGNOME];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+1]	= $tableBambini[$tbl_pnt][SRC_COMPL_BAMB_NOME];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+2]	= $tableBambini[$tbl_pnt][SRC_COMPL_BAMB_D_NASCITA];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+3]	= $tableBambini[$tbl_pnt][SRC_COMPL_BAMB_NOTE];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+4]	= $tableBambini[$tbl_pnt][SRC_COMPL_BAMB_TIPO_ATT];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+5]	= $tableBambini[$tbl_pnt][SRC_COMPL_BAMB_ATT];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+6]	= $tableBambini[$tbl_pnt][SRC_COMPL_BAMB_STATO_ADES];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+7]	= $tableBambini[$tbl_pnt][SRC_COMPL_BAMB_NOTE_ADES];
		$tbl_pnt++;
	}
	
	return $nrows;
	
}

function mergeAttTables ($bigTableRowOffs, &$bigTable, $colOffsRef, $tableReferenti, $colOffsBamb, $tableBambini) {

// inizializza bigtable con nulls

	$nrows=max(count($tableReferenti),count($tableBambini));
	$ncols=LEN_ATTIVITA_COMPLETO;
	$row_pnt=0;
	while ($row_pnt < $nrows) {
		$col_pnt=0;
		while ($col_pnt<$ncols) {
			$bigTable[$row_pnt+$bigTableRowOffs][$col_pnt] = "";
			$col_pnt++;
		}
		$row_pnt++;
	}

// scrivi in bigtable i dati dell'attivita'
	if (count($tableBambini)>0) {
		$bigTable[$bigTableRowOffs][0]	= $tableBambini[0][SRC_COMPL_ADESIONI_TIPO_ATTIVITA];
		$bigTable[$bigTableRowOffs][1]	= $tableBambini[0][SRC_COMPL_ADESIONI_NOME_ATTIVITA];
		$bigTable[$bigTableRowOffs][2]	= $tableBambini[0][SRC_COMPL_ADESIONI_STATO_ATTIVITA];
		$bigTable[$bigTableRowOffs][3]	= $tableBambini[0][SRC_COMPL_ADESIONI_CAPACITA];
		$bigTable[$bigTableRowOffs][4]	= $tableBambini[0][SRC_COMPL_ADESIONI_INIZIO];
		$bigTable[$bigTableRowOffs][5]	= $tableBambini[0][SRC_COMPL_ADESIONI_FINE];
		$bigTable[$bigTableRowOffs][6]	= $tableBambini[0][SRC_COMPL_ADESIONI_NOTE_ATTIVITA];
	}
	else {
		$bigTable[$bigTableRowOffs][0]	= $tableReferenti[0][SRC_COMPL_INTERESS_TIPO_INTERESSAMENTO];
		$bigTable[$bigTableRowOffs][1]	= $tableReferenti[0][SRC_COMPL_INTERESS_NOME_INTERESSAMENTO];
		$bigTable[$bigTableRowOffs][2]	= $tableReferenti[0][SRC_COMPL_INTERESS_STATO_ATTIVITA];
		$bigTable[$bigTableRowOffs][3]	= $tableReferenti[0][SRC_COMPL_INTERESS_CAPACITA];
		$bigTable[$bigTableRowOffs][4]	= $tableReferenti[0][SRC_COMPL_INTERESS_INIZIO];
		$bigTable[$bigTableRowOffs][5]	= $tableReferenti[0][SRC_COMPL_INTERESS_FINE];
		$bigTable[$bigTableRowOffs][6]	= $tableReferenti[0][SRC_COMPL_INTERESS_NOTE_ATTIVITA];
	}

// scrivi in bigtable i dati dei Bambino

	$tbl_len=count($tableBambini);
	$tbl_pnt=0;		
	while ($tbl_pnt < $tbl_len) {
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+0]	= $tableBambini[$tbl_pnt][SRC_COMPL_ADESIONI_TIPO_CONTATTO];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+1]	= $tableBambini[$tbl_pnt][SRC_COMPL_ADESIONI_ID_CONTATTO];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+2]	= "* BAMBINO *";
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+3]	= $tableBambini[$tbl_pnt][SRC_COMPL_ADESIONI_COGNOME];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+4]	= $tableBambini[$tbl_pnt][SRC_COMPL_ADESIONI_NOME];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+5]	= $tableBambini[$tbl_pnt][SRC_COMPL_ADESIONI_DATA_DI_NASCITA];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+6]	= $tableBambini[$tbl_pnt][SRC_COMPL_ADESIONI_NOTE];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+7]	= 1;													// n. bambini partecipanti: sempre 1
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+8]	= $tableBambini[$tbl_pnt][SRC_COMPL_ADESIONI_STATO_ADESIONE];
		$bigTable[$bigTableRowOffs+$tbl_pnt][$colOffsBamb+9]	= $tableBambini[$tbl_pnt][SRC_COMPL_ADESIONI_NOTE_ADESIONE];
		$tbl_pnt++;
	}
	
// scrivi in bigtable i dati dei Referenti

	$bas_tbl_pnt=$tbl_pnt;
	$tbl_len=count($tableReferenti);
	$tbl_pnt=0;		
	while ($tbl_pnt < $tbl_len) {
		$bigTable[$bigTableRowOffs+$bas_tbl_pnt+$tbl_pnt][$colOffsRef+0] = $tableReferenti[$tbl_pnt][SRC_COMPL_INTERESS_ID_TIPO_CONTATTO];
		$bigTable[$bigTableRowOffs+$bas_tbl_pnt+$tbl_pnt][$colOffsRef+1] = $tableReferenti[$tbl_pnt][SRC_COMPL_INTERESS_ID_CONTATTO];
		$bigTable[$bigTableRowOffs+$bas_tbl_pnt+$tbl_pnt][$colOffsRef+2] = "* REFERENTE *";
		$bigTable[$bigTableRowOffs+$bas_tbl_pnt+$tbl_pnt][$colOffsRef+3] = $tableReferenti[$tbl_pnt][SRC_COMPL_INTERESS_COGNOME_REF];
		$bigTable[$bigTableRowOffs+$bas_tbl_pnt+$tbl_pnt][$colOffsRef+4] = $tableReferenti[$tbl_pnt][SRC_COMPL_INTERESS_NOME_REF];
		$bigTable[$bigTableRowOffs+$bas_tbl_pnt+$tbl_pnt][$colOffsRef+5] = "- -";												// la data di nascita del referente non ci interessa
		$bigTable[$bigTableRowOffs+$bas_tbl_pnt+$tbl_pnt][$colOffsRef+6] = $tableReferenti[$tbl_pnt][SRC_COMPL_INTERESS_NOTE_REF];
		$bigTable[$bigTableRowOffs+$bas_tbl_pnt+$tbl_pnt][$colOffsRef+7] = $tableReferenti[$tbl_pnt][SRC_COMPL_INTERESS_NUM_PARTECIPANTI];
		$bigTable[$bigTableRowOffs+$bas_tbl_pnt+$tbl_pnt][$colOffsRef+8] = $tableReferenti[$tbl_pnt][SRC_COMPL_INTERESS_STATO_INTERESSAMENTO];
		$bigTable[$bigTableRowOffs+$bas_tbl_pnt+$tbl_pnt][$colOffsRef+9] = $tableReferenti[$tbl_pnt][SRC_COMPL_INTERESS_NOTE_INTERESSAMENTO];
		$tbl_pnt++;
	}	
}

?>