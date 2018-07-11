<?php
	include 'definizioni.php';
	
	$TipoDato	=	$_GET['TipoDato'];
	$KeyOne		=	$_GET['KeyOne'];
	$KeyTwo		=	$_GET['KeyTwo'];
	$KeyThree	=	$_GET['KeyThree'];

	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
		or die('Error connecting to MySQL server.');

	if ($TipoDato=="CONTATTO") {

		$query = "SELECT DISTINCT * FROM Anagrafica_Contatto WHERE Anagrafica_Contatto.Identificativo LIKE '%" . $KeyOne . "%'";
		$result = mysqli_query($dbc, $query)
			or die('recuperaDati.php: Error querying database - 1');

		$row = mysqli_fetch_array($result); 

		$jarr = array();
		
		array_push($jarr, array('Tipologia'				=> $row['Tipologia'],
								'Identificativo'		=> $row['Identificativo'],
								'Data_primo_contatto'	=> $row['Data_primo_contatto'],
								'Cliente'				=> $row['Cliente'],
								'Ultimo_contatto'		=> $row['Ultimo_contatto'],
								'Note'					=> $row['Note']));

	}
	
	elseif ($TipoDato=="LISTA_CONTATTI_REFERENTE") {

		$jarr = array();

		$query =	"SELECT Identificativo FROM Anagrafica_Contatto WHERE Anagrafica_Contatto.ID_Contatto IN " .
					"(SELECT FK_Contatto FROM Anagrafica_Referente WHERE Anagrafica_Referente.Cognome_Ref LIKE '%" . $KeyOne . "%' AND " .
					"Anagrafica_Referente.Nome_Ref LIKE '%" . $KeyTwo . "%') ";
					
		$result = mysqli_query($dbc, $query)
						or die('recuperaDati.php: Error querying database - 2');
						
		while ($row = mysqli_fetch_array($result)) {
			array_push($jarr, $row);
		}	
	}

	elseif ($TipoDato=="LISTA_CONTATTI_BAMBINO") {

		$jarr = array();

		$query =	"SELECT Identificativo FROM Anagrafica_Contatto WHERE Anagrafica_Contatto.ID_Contatto IN " .
					"(SELECT FK_Contatto FROM Bambini WHERE Bambini.Cognome LIKE '%" . $KeyOne . "%' AND " .
					"Bambini.Nome LIKE '%" . $KeyTwo . "%') ";
					
		$result = mysqli_query($dbc, $query)
						or die('recuperaDati.php: Error querying database - 2,5');
						
		while ($row = mysqli_fetch_array($result)) {
			array_push($jarr, $row);
		}	
	}

	elseif ($TipoDato=="DATI_REFERENTE") {

		$query =	"SELECT * FROM Anagrafica_Referente WHERE Anagrafica_Referente.FK_Contatto LIKE " .
					"(SELECT DISTINCT ID_Contatto FROM Anagrafica_Contatto WHERE Anagrafica_Contatto.Identificativo LIKE '%" . $KeyThree . "%') AND " .
					"Anagrafica_Referente.Cognome_Ref LIKE '%" . $KeyOne . "%' AND Anagrafica_Referente.Nome_Ref LIKE '%" . $KeyTwo . "%'";

		$result = mysqli_query($dbc, $query)
					or die('recuperaDati.php: Error querying database - 3');
					
		$row = mysqli_fetch_array($result);		// dati referente

		$query = "SELECT * FROM Interessamenti WHERE Interessamenti.FK_Referente LIKE '%" . $row['ID_Referente'] . "%' ";
		$result = mysqli_query($dbc, $query)
					or die('recuperaDati.php: Error querying database - 4');
		$numInt=0;
		$refInt = array();
		while($arow = mysqli_fetch_array($result)) {
			$refInt[$numInt]['Num_Partecipanti'] 			= $arow['Num_Partecipanti'];
			$refInt[$numInt]['Stato_Interessamento']		= $arow['Stato'];
			$refInt[$numInt]['Note_Interessamento'] 		= $arow['Note'];
			$refInt[$numInt]['FK_Attivita_Referente']	 	= $arow['FK_Attivita_Referente'];
			$refInt[$numInt]['ID_Interessamenti']	 		= $arow['ID_Interessamenti'];
			$numInt++;
		}

		$ptrInt=0;
		while($ptrInt<$numInt) {
			$query = "SELECT Nome_Attivita_Interessamento FROM Lista_Attivita_Interessamenti WHERE Lista_Attivita_Interessamenti.ID_Interessamento LIKE '%" . $refInt[$ptrInt]['FK_Attivita_Referente'] . "%' ";
			$result = mysqli_query($dbc, $query)
					or die('recuperaDati.php: Error querying database - 5');
			$arow = mysqli_fetch_array($result);
			$refInt[$ptrInt]['Nome_Attivita'] = $arow['Nome_Attivita_Interessamento'];
			$ptrInt++;
		}	   

		$jarr = array();
								
		array_push($jarr, array('P_IVA'					=> $row['P_IVA'],
								'NR_TEL'				=> $row['NR_TEL'],
								'E_MAIL'				=> $row['E_MAIL'],
								'Indirizzo'				=> $row['Indirizzo'],
								'CAP'					=> $row['CAP'],
								'Comune'				=> $row['Comune'],
								'Note_Ref'				=> $row['Note_Ref'],
								'lista_interessamenti'	=> $refInt));
	}

	elseif ($TipoDato=="DATI_BAMBINO") {

		$query =	"SELECT * FROM Bambini WHERE Bambini.FK_Contatto LIKE " .
					"(SELECT DISTINCT ID_Contatto FROM Anagrafica_Contatto WHERE Anagrafica_Contatto.Identificativo LIKE '%" . $KeyThree . "%') AND " .
					"Bambini.Cognome LIKE '%" . $KeyOne . "%' AND Bambini.Nome LIKE '%" . $KeyTwo . "%'";

		$result = mysqli_query($dbc, $query)
					or die('recuperaDati.php: Error querying database - 6');
					
		$row = mysqli_fetch_array($result);		// dati bambino

		$query = "SELECT * FROM Adesioni WHERE Adesioni.FK_bambino LIKE '%" . $row['ID_Bambino'] . "%' ";
		$result = mysqli_query($dbc, $query)
					or die('recuperaDati.php: Error querying database - 7');
		$arow = mysqli_fetch_array($result);
		$query = "SELECT Nome_Attivita FROM Lista_Attivita_Adesioni WHERE Lista_Attivita_Adesioni.ID_Attivita LIKE '%" . $arow['FK_attivita'] . "%' ";
		$result = mysqli_query($dbc, $query)
					or die('recuperaDati.php: Error querying database - 8');
		$aarow = mysqli_fetch_array($result);	// nome attivita bambino		

		$jarr = array();
		
		array_push($jarr, array('Nome'					=> $row['Nome'],
								'Cognome'				=> $row['Cognome'],
								'Data_di_nascita'		=> $row['Data_di_nascita'],
								'Note'					=> $row['Note'],
								'Nome_Attivita'			=> $aarow['Nome_Attivita'],
								'Stato_Adesione'		=> $arow['Stato'],
								'Note_Adesione'			=> $arow['Note']));

	}

	elseif ($TipoDato=="DATI_ATTIVITA") {

		$query =	"SELECT * FROM Lista_Attivita_Adesioni WHERE Lista_Attivita_Adesioni.Nome_Attivita LIKE '%" . $KeyOne . "%' ";

		$result = mysqli_query($dbc, $query)
					or die('recuperaDati.php: Error querying database - 9');
					
		$row = mysqli_fetch_array($result);		// dati attivita'

		$jarr = array();
		
		array_push($jarr, array('Tipo'					=> $row['Tipo'],
								'Stato'					=> $row['Stato'],
								'Capacita'				=> $row['Capacita'],
								'Inizio'				=> $row['Inizio'],
								'Fine'					=> $row['Fine'],
								'Note'					=> $row['Note']));
				
	}

	else {}
	
	echo json_encode($jarr);
?>
