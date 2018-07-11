<?php
	session_start();
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


//SELECT Anagrafica_Contatto.Tipologia, Anagrafica_Contatto.Identificativo, Anagrafica_Referente.Cognome_Ref, Lista_Attivita_Interessamenti.Nome_Attivita, Bambini.Cognome, Lista_Attivita_Adesioni.Nome_Attivita
//FROM ((((Anagrafica_Contatto LEFT JOIN Anagrafica_Referente ON Anagrafica_Contatto.ID_Contatto = Anagrafica_Referente.FK_contatto) LEFT JOIN Interessamenti ON Anagrafica_Referente.ID_Referente = Interessamenti.FK_Referente)
//LEFT JOIN Lista_Attivita_Interessamenti ON Interessamenti.FK_Attivita_Referente = Lista_Attivita_Interessamenti.ID_Interessamento) LEFT JOIN Bambini ON Anagrafica_Contatto.ID_Contatto = Bambini.FK_Contatto)
//LEFT JOIN (Lista_Attivita_Adesioni RIGHT JOIN Adesioni ON Lista_Attivita_Adesioni.ID_Attivita = Adesioni.FK_Attivita) ON Bambini.ID_Bambino = Adesioni.FK_bambino;


	define('STATO_ATTIVITA',1);
	define('ADESIONI_ATTIVITA',2);
	define('STATO_CONTATTO',3);
	define('STATO_REFERENTE',4);
	define('STATO_BAMBINO',5);
	define('FULL_DATA',6);
	define('SQL_STD_FROM',	'FROM ((((Anagrafica_Contatto LEFT JOIN Anagrafica_Referente ON Anagrafica_Contatto.ID_Contatto = ' .
							'Anagrafica_Referente.FK_contatto) LEFT JOIN Interessamenti ON Anagrafica_Referente.ID_Referente = ' .
							'Interessamenti.FK_Referente) LEFT JOIN Lista_Attivita_Interessamenti ON Interessamenti.FK_Attivita_Referente = ' .
							'Lista_Attivita_Interessamenti.ID_Interessamento) LEFT JOIN Bambini ON Anagrafica_Contatto.ID_Contatto = ' .
							'Bambini.FK_Contatto) LEFT JOIN (Lista_Attivita_Adesioni RIGHT JOIN Adesioni ON Lista_Attivita_Adesioni.ID_Attivita ' .
							'= Adesioni.FK_Attivita) ON Bambini.ID_Bambino = Adesioni.FK_bambino ');
	
	$Attivita = $_POST['Attivita'];
	$Contatto = $_POST['Contatto'];
	$Cognome_Referente = $_POST['Cognome_Referente'];
	$Cognome_Bambino = $_POST['Cognome_Bambino'];
	
	
	if (!empty($Attivita)) {
		$ricerca = 'ADESIONI_ATTIVITA';
	}
	else if (!empty($Contatto)) {
		$ricerca = 'STATO_CONTATTO';
	}
	else if (!empty($Cognome_Referente)) {
		$ricerca = 'STATO_REFERENTE';
	}
	else if (!empty($Cognome_Bambino)) {
		$ricerca = 'STATO_BAMBINO';
	}
	else {
		$ricerca = 'FULL_DATA';
	}	
	
	$_SESSION['ricerca'] = $ricerca;				/* salva tipo di ricerca in caso di export csv */
	
	$dbc = mysqli_connect('62.149.150.207', 'Sql732257', '223mqw8tj7', 'Sql732257_1')
    or die('Error connecting to MySQL server.');
	
	switch ($ricerca) {
	case 'STATO_ATTIVITA':
	
		break;
		
	case 'ADESIONI_ATTIVITA':
		
		$query = "SELECT Lista_Attivita_Adesioni.Tipo, Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.Inizio, Lista_Attivita_Adesioni.Fine, Adesioni.Stato, " .
		"Bambini.Cognome, Bambini.Nome, Anagrafica_Contatto.Tipologia, Anagrafica_Contatto.Identificativo, Anagrafica_Referente.Cognome_Ref, " .
		"Anagrafica_Referente.Nome_Ref, Anagrafica_Referente.NR_TEL, Anagrafica_Referente.E_MAIL, Anagrafica_Referente.Note ";

		$query .= SQL_STD_FROM . "WHERE (((Lista_Attivita_Adesioni.Nome_Attivita) Like '%" . $Attivita . "%'));";
		
		$_SESSION['Attivita'] = $Attivita;
		
		break;
		
	case 'STATO_CONTATTO':

		break;
	case 'STATO_REFERENTE':

		break;
		
	case 'STATO_BAMBINO':
	
		$query = "SELECT Bambini.Cognome, Bambini.Nome, Bambini.Data_di_nascita, Adesioni.Stato, Lista_Attivita_Adesioni.Tipo, " .
		"Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.Inizio, Lista_Attivita_Adesioni.Fine, Anagrafica_Contatto.Tipologia, Anagrafica_Contatto.Identificativo, " .
		"Anagrafica_Referente.Cognome_Ref, Anagrafica_Referente.Nome_Ref, Anagrafica_Referente.NR_TEL, Anagrafica_Referente.E_MAIL, " .
		"Anagrafica_Referente.Note ";
		
		$query .= SQL_STD_FROM . "WHERE (((Bambini.Cognome) Like '%" . $Cognome_Bambino . "%'));";
		
		$_SESSION['Cognome_Bambino'] = $Cognome_Bambino;
		break;
		
	case 'FULL_DATA':

		$query = "SELECT Anagrafica_Contatto.Tipologia, Anagrafica_Contatto.Identificativo, Anagrafica_Contatto.Data_primo_contatto, " .
		"Anagrafica_Contatto.Cliente, Anagrafica_Contatto.Ultimo_contatto, Anagrafica_Referente.Cognome_Ref, Anagrafica_Referente.Nome_Ref, " .
		"Lista_Attivita_Interessamenti.Nome_Attivita, Anagrafica_Referente.Note, Anagrafica_Referente.P_IVA, Anagrafica_Referente.NR_TEL, " .
		"Anagrafica_Referente.E_MAIL, Anagrafica_Referente.Indirizzo, Anagrafica_Referente.CAP, Anagrafica_Referente.Comune, Bambini.Cognome, Bambini.Nome, " .
		"Bambini.Data_di_nascita, Adesioni.Stato, Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.Tipo, Lista_Attivita_Adesioni.Inizio, Lista_Attivita_Adesioni.Fine ";

		$query .= SQL_STD_FROM . "ORDER BY Anagrafica_Contatto.ID_Contatto;";

		break;
		
	default:	
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
			case 'ADESIONI_ATTIVITA':	
				echo
				"<tr><th>Tipo</th>
				<th>Attivita</th>
				<th>Inizio attivita</th>
				<th>Fine attivita</th>
				<th>Stato</th>
				<th>Cognome Bambino</th>
				<th>Nome Bambino</th>
			    <th>Tipo Contatto</th>
				<th>Contatto</th>
				<th>Cognome referente</th>
				<th>Nome referente</th>
				<th>N.TEL</th>
				<th>E_MAIL</th>
				<th>Note</th></tr>";
				
				$row_len=14;

			break;
		case 'STATO_CONTATTO':
			break;
		case 'STATO_REFERENTE':
			break;
		case 'STATO_BAMBINO':
				echo
				"<tr><th>Cognome Bambino</th>
				<th>Nome Bambino</th>
				<th>Data di nascita</th>
				<th>Stato</th>
				<th>Tipo</th>
				<th>Attivita</th>
				<th>Inizio attivita</th>
				<th>Fine attivita</th>
			    <th>Tipo Contatto</th>
				<th>Contatto</th>
				<th>Cognome referente</th>
				<th>Nome referente</th>
				<th>N.TEL</th>
				<th>E_MAIL</th>
				<th>Note</th></tr>";
				
				$row_len=15;

			break;
			
		case 'FULL_DATA':
			echo
			   "<tr><th>Tipo Contatto</th>
				<th>Contatto</th>
				<th>Data primocontatto</th>
				<th>Cliente</th>
				<th>Ultimo contatto</th>
				<th>Cognome referente</th>
				<th>Nome referente</th>
				<th>Interessato a</th>
				<th>Note</th>
				<th>P.IVA</th>
				<th>N.TEL</th>
				<th>E_MAIL</th>
				<th>Indirizzo</th>
				<th>CAP</th>
				<th>Comune</th>
				<th>Cognome Bambino</th>
				<th>Nome Bambino</th>
				<th>Data di nascita</th>
				<th>Stato</th>
				<th>Attivita</th>
				<th>Tipo</th>
				<th>Inizio attivita</th>
				<th>Fine attivita</th></tr>";
				
				$row_len=23;

			break;
		}
		
		$tbl_pnt=0;
		
		while ($tbl_pnt < $tbl_len) {
								
			$row_pnt=0;
			
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
