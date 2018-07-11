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
	
	define('STATO_ATTIVITA',1);
	define('ADESIONI_ATTIVITA',2);
	define('STATO_CONTATTO',3);
	define('STATO_REFERENTE',4);
	define('STATO_BAMBINO',5);
	define('FULL_DATA',6);
	define('SQL_STD_FROM',	'FROM (Anagrafica_contatto INNER JOIN Anagrafica_Contatto_Fisico ON Anagrafica_contatto.ID_Contatto = ' .
							'Anagrafica_Contatto_Fisico.FK_contatto) LEFT JOIN (Lista_attivita RIGHT JOIN (Adesioni RIGHT JOIN ' .
							'Bambini ON Adesioni.FK_bambino = Bambini.ID_Bambino) ON Lista_attivita.ID_attivita = Adesioni.FK_attivita) ' .
							'ON Anagrafica_contatto.ID_Contatto = Bambini.FK_contatto_fisico ');
	
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
		
		$query = "SELECT Lista_attivita.tipo, Lista_attivita.nome_attivita, Lista_attivita.Inizio, Lista_attivita.Fine, Adesioni.stato, " .
		"Bambini.Cognome, Bambini.Nome, Anagrafica_contatto.Tipologia, Anagrafica_contatto.Identificativo, Anagrafica_Contatto_Fisico.Cognome, " .
		"Anagrafica_Contatto_Fisico.Nome, Anagrafica_Contatto_Fisico.NR_TEL, Anagrafica_Contatto_Fisico.E_MAIL, Anagrafica_Contatto_Fisico.Qualifica ";

		$query .= SQL_STD_FROM . "WHERE (((Lista_attivita.nome_attivita) Like '%" . $Attivita . "%'));";
		
		$_SESSION['Attivita'] = $Attivita;
		
		break;
		
	case 'STATO_CONTATTO':

		break;
	case 'STATO_REFERENTE':

		break;
		
	case 'STATO_BAMBINO':
	
		$query = "SELECT Bambini.Cognome, Bambini.Nome, Bambini.Data_di_nascita, Adesioni.stato, Lista_attivita.tipo, " .
		"Lista_attivita.nome_attivita, Lista_attivita.Inizio, Lista_attivita.Fine, Anagrafica_contatto.Tipologia, Anagrafica_contatto.Identificativo, " .
		"Anagrafica_Contatto_Fisico.Cognome, Anagrafica_Contatto_Fisico.Nome, Anagrafica_Contatto_Fisico.NR_TEL, Anagrafica_Contatto_Fisico.E_MAIL, " .
		"Anagrafica_Contatto_Fisico.Qualifica ";
		
		$query .= SQL_STD_FROM . "WHERE (((Bambini.Cognome) Like '%" . $Cognome_Bambino . "%'));";
		
		$_SESSION['Cognome_Bambino'] = $Cognome_Bambino;
		break;
		
	case 'FULL_DATA':

		$query = "SELECT Anagrafica_contatto.Tipologia, Anagrafica_contatto.Identificativo, Anagrafica_contatto.Data_primo_contatto, " .
		"Anagrafica_contatto.Cliente, Anagrafica_contatto.Ultimo_contatto, Anagrafica_Contatto_Fisico.Cognome, Anagrafica_Contatto_Fisico.Nome, " .
		"Anagrafica_Contatto_Fisico.CF_PIVA, Anagrafica_Contatto_Fisico.NR_TEL, Anagrafica_Contatto_Fisico.E_MAIL, Anagrafica_Contatto_Fisico.Indirizzo, " .
		"Anagrafica_Contatto_Fisico.CAP, Anagrafica_Contatto_Fisico.Comune, Anagrafica_Contatto_Fisico.Qualifica, Bambini.Cognome, Bambini.Nome, " .
		"Bambini.Data_di_nascita, Adesioni.stato, Lista_attivita.nome_attivita, Lista_attivita.tipo, Lista_attivita.Inizio, Lista_attivita.Fine ";

		$query .= SQL_STD_FROM . "ORDER BY Anagrafica_contatto.Identificativo;";

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
				<th>Qualifica</th></tr>";
				
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
				<th>Qualifica</th></tr>";
				
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
				<th>P.IVA</th>
				<th>N.TEL</th>
				<th>E_MAIL</th>
				<th>Indirizzo</th>
				<th>CAP</th>
				<th>Comune</th>
				<th>Qualifica</th>
				<th>Cognome Bambino</th>
				<th>Nome Bambino</th>
				<th>Data di nascita</th>
				<th>Stato</th>
				<th>Attivita</th>
				<th>Tipo</th>
				<th>Inizio attivita</th>
				<th>Fine attivita</th></tr>";
				
				$row_len=22;

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
