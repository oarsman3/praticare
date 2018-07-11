<?php

include 'definizioni.php';

function createTblContatti ($modo, $queryParm1, $queryParm2, $Dettaglio) {

global $Ordine_Alfabetico, $Ordine_Cronologico, $Ordine_Sort, $dbc;

	$query = SELECT_CONTATTO_COMPLETO . FROM_ANAGRAFICA_CONTATTO ;
	
	if ($modo==BY_NAME) {
		$query .= ($queryParm1 == TUTTI or $queryParm1 == "") ? " " : "WHERE (((Anagrafica_Contatto.Identificativo) Like '%" . $queryParm1 . "%')) ";
	}
	else {
		$query .= "WHERE Anagrafica_Contatto.ID_Contatto = " . $queryParm1 . " ";
	}
		
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
	
	$query .= (($Ordine_Sort==DECRESCENTE)?"DESC;":";");
	$result = mysqli_query($dbc, $query) or die('creaTblContatti.php: error querying DB Praticare - 01');	
	$table = array();
	$tbl_pnt=0;
	while ($row = mysqli_fetch_array($result)) {
			$table[$tbl_pnt]=$row;
			$tbl_pnt+=1;
	}
	return $table;
}





function createTblReferenti($modo, $queryParm1, $queryParm2, $Dettaglio) {

global $Ordine_Alfabetico, $Ordine_Cronologico, $Ordine_Sort, $dbc;
	
	if ($modo==BY_NAME) {
		$query = SELECT_REFERENTE_COMPLETO . FROM_ANAGRAFICA_REFERENTE ;
		$query .= ($queryParm1 == TUTTI or $queryParm1 == "") ? " " : "WHERE (((Anagrafica_Referente.Cognome_Ref) Like '%" . $queryParm1 . "%') AND ((Anagrafica_Referente.Nome_Ref) Like '%" . $queryParm2 . "%')) ";
	}
	elseif ($modo==BY_ATTIVITA_ID) { 
		$query = SELECT_FROM_INTERESSAMENTI_REFERENTI_COMPLETO;
		$query .= "WHERE Lista_Attivita_Interessamenti.nome_attivita_interessamento = '" . $queryParm1 . "' ";
	}
	else {
		$query = SELECT_REFERENTE_COMPLETO . FROM_ANAGRAFICA_REFERENTE ;
		$query .= "WHERE Anagrafica_Referente.FK_Contatto = " . $queryParm1 . " ";
	}
	
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

	$query .= (($Ordine_Sort==DECRESCENTE)?"DESC;":";");
	$result = mysqli_query($dbc, $query) or die('creaTblReferenti.php: error querying DB Praticare - 01');	
	$table = array();
	$tbl_pnt=0;
	while ($row = mysqli_fetch_array($result)) {
		$table[$tbl_pnt]=$row;
		$tbl_pnt+=1;
	}
	return $table;
}



function createTblBambini($modo, $queryParm1, $queryParm2, $Dettaglio) {

global $Ordine_Alfabetico, $Ordine_Cronologico, $Ordine_Sort, $dbc;
	
	if ($modo==BY_NAME) {
		$query = SELECT_BAMBINO_COMPLETO . FROM_BAMBINI ;
		$query .= ($queryParm1 == TUTTI or $queryParm1 == "") ? " " : "WHERE (((Bambini.Cognome) Like '%" . $queryParm1 . "%') AND ((Bambini.Nome) Like '%" . $queryParm2 . "%')) ";
	}
	elseif ($modo==BY_ATTIVITA_ID) {
		$query = SELECT_FROM_ATTIVITA_BAMBINI_COMPLETO;
		$query .= "WHERE Lista_Attivita_Adesioni.Nome_Attivita = '" . $queryParm1 . "' ";
	}
	else {
		$query = SELECT_BAMBINO_COMPLETO . FROM_BAMBINI ;
		$query .= "WHERE Bambini.FK_Contatto = " . $queryParm1 . " ";
	}	
																
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

	$query .= (($Ordine_Sort==DECRESCENTE)?"DESC;":";");
	$result = mysqli_query($dbc, $query) or die('creaTblBambini.php: error querying DB Praticare - 01');	
	$table = array();
	$tbl_pnt=0;
	while ($row = mysqli_fetch_array($result)) {
		$table[$tbl_pnt]=$row;
		$tbl_pnt+=1;
	}
	return $table;
}


?>