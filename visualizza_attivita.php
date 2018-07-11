<?php
	session_start();
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare Il Futuro - Visualizza Attivita'</title>
  
  <link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>
	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Visualizza Attivita'</h2>
	</div>

	<div class="toolbar">
	
		<div class="firstoption"><a href ="gestione_attivita.html">Torna alla gestione attivita'</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>

	</div>

<?php

	$Nome_Attivita = $_POST['Nome_Attivita'];
	$Stato = $_POST['Stato'];
	
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
    or die('visualizza_attivita.php: Error connecting to MySQL server.');

// crea tabella stato adesioni

	$query =	"SELECT Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.Tipo, Lista_Attivita_Adesioni.Inizio, " .
				"Lista_Attivita_Adesioni.Fine, Lista_Attivita_Adesioni.Capacita, Adesioni.Stato, COUNT( Adesioni.Stato ) , " .
				"Lista_Attivita_Adesioni.Stato, Lista_Attivita_Adesioni.Note " .
				"FROM Lista_Attivita_Adesioni LEFT JOIN Adesioni ON Lista_Attivita_Adesioni.ID_Attivita = Adesioni.FK_Attivita ";
				
	$query .= ($Nome_Attivita==TUTTI)?"":"WHERE Lista_Attivita_Adesioni.Nome_Attivita Like '%" . $Nome_Attivita . "%' ";
	
	$query .= "GROUP BY Lista_Attivita_Adesioni.Nome_Attivita, Adesioni.Stato ";

	$result = mysqli_query($dbc, $query)
		or die('visualizza_attivita.psp: error querying DB Praticare - 1');
	
	$tabella_adesioni = array();
	
	$p=0;
	while ($row = mysqli_fetch_array($result,MYSQLI_BOTH)) {
		$tabella_adesioni[$p]=$row;
		$p++;
	}

// crea tabella stato Interessamenti

	$query =	"SELECT Lista_Attivita_Interessamenti.Nome_Attivita_Interessamento, Lista_Attivita_Interessamenti.Tipo, Lista_Attivita_Interessamenti.Inizio, " .
				"Lista_Attivita_Interessamenti.Fine, Lista_Attivita_Interessamenti.Capacita, Interessamenti.Stato, SUM( Interessamenti.Num_Partecipanti ) , " .
				"Lista_Attivita_Interessamenti.Stato, Lista_Attivita_Interessamenti.Note " .
				"FROM Lista_Attivita_Interessamenti LEFT JOIN Interessamenti ON Lista_Attivita_Interessamenti.ID_Interessamento = " .
				"Interessamenti.FK_Attivita_Referente ";

	$query .= ($Nome_Attivita==TUTTI)?"":"WHERE Lista_Attivita_Interessamenti.Nome_Attivita_Interessamento Like '%" . $Nome_Attivita . "%' ";

	$query .= "GROUP BY Lista_Attivita_Interessamenti.Nome_Attivita_Interessamento, Interessamenti.Stato ";

	$result = mysqli_query($dbc, $query) or die('visualizza_attivita.psp: error querying DB Praticare - 2');
	
	$tabella_Interessamenti = array();
	
	$p=0;
	while ($row = mysqli_fetch_array($result,MYSQLI_BOTH)) {
		$tabella_interessamenti[$p]=$row;
		$p++;
	}
	

// aggrega tabelle ADESIONI e INTERESSAMENTI, riducendo a una singola riga piu' righe di una stessa attivita'
// Praticamente fa una PIVOT

	$table = array();
	
	$srcpt=0;
	$dstpt=0;
	$tbl_len=count($tabella_adesioni);
	
	while ($srcpt<$tbl_len) {	
		$q=0;
		$found=False;
		while (!$found and $q<$dstpt) {

			if ($tabella_adesioni[$srcpt][SRC_OFFSET_NOME_ATTIVITA]==$table[$q][DST_OFFSET_NOME_ATTIVITA]) {
				$found=True;
			}
			else {
				$q++;
			}
		}
		
		if (!$found) {								// nuova attivita', scrivi campi e azzera contatori adesioni/interessamenti
		
			$table[$dstpt][DST_OFFSET_NOME_ATTIVITA]			=	$tabella_adesioni[$srcpt][SRC_OFFSET_NOME_ATTIVITA];
			$table[$dstpt][DST_OFFSET_TIPO]						=	$tabella_adesioni[$srcpt][SRC_OFFSET_TIPO];
			$table[$dstpt][DST_OFFSET_INIZIO]					=	$tabella_adesioni[$srcpt][SRC_OFFSET_INIZIO];
			$table[$dstpt][DST_OFFSET_FINE]						=	$tabella_adesioni[$srcpt][SRC_OFFSET_FINE];
			$table[$dstpt][DST_OFFSET_CAPACITA]					=	$tabella_adesioni[$srcpt][SRC_OFFSET_CAPACITA];
//			$table[$dstpt][DST_OFFSET_STATO_ATTIVITA]			=	($tabella_adesioni[$srcpt][SRC_OFFSET_STATO_ATTIVITA])==0?'inattivo':'attivo';
			$table[$dstpt][DST_OFFSET_STATO_ATTIVITA]			=	$tabella_adesioni[$srcpt][SRC_OFFSET_STATO_ATTIVITA];
			$table[$dstpt][DST_OFFSET_NOTE]						=	$tabella_adesioni[$srcpt][SRC_OFFSET_NOTE];
			$table[$dstpt][DST_OFFSET_BAMBINI_CONFERMATI]	 	= 	"";
			$table[$dstpt][DST_OFFSET_BAMBINI_PRENOTATI] 		= 	"";

			$dstpt++;
		}

		switch ($tabella_adesioni[$srcpt][SRC_OFFSET_STATO_ADESIONI]) {

			case 'prenotato':
				$table[$q][DST_OFFSET_BAMBINI_PRENOTATI] = $tabella_adesioni[$srcpt][SRC_OFFSET_COUNT];
			break;

			case 'confermato':
				$table[$q][DST_OFFSET_BAMBINI_CONFERMATI] = $tabella_adesioni[$srcpt][SRC_OFFSET_COUNT];
			break;

			default:
			break;
		}
		
		$srcpt++;
	}

	$srcpt=0;
	$dstpt=0;	
	$tbl_len=count($tabella_interessamenti);
	
	while ($srcpt<$tbl_len) {	
		$q=0;
		$found=False;
		while (!$found and $q<$dstpt) {

			if ($tabella_interessamenti[$srcpt][SRC_OFFSET_NOME_ATTIVITA]==$table[$q][DST_OFFSET_NOME_ATTIVITA]) {
				$found=True;
			}
			else {
				$q++;
			}
		}
		
		if (!$found) {								// nuova attivita', scrivi campi e azzera contatori interessamenti
		
			$table[$dstpt][DST_OFFSET_NOME_ATTIVITA]			=	$tabella_interessamenti[$srcpt][SRC_OFFSET_NOME_ATTIVITA];
			$table[$dstpt][DST_OFFSET_TIPO]						=	$tabella_interessamenti[$srcpt][SRC_OFFSET_TIPO];
			$table[$dstpt][DST_OFFSET_INIZIO]					=	$tabella_interessamenti[$srcpt][SRC_OFFSET_INIZIO];
			$table[$dstpt][DST_OFFSET_FINE]						=	$tabella_interessamenti[$srcpt][SRC_OFFSET_FINE];
			$table[$dstpt][DST_OFFSET_CAPACITA]					=	$tabella_interessamenti[$srcpt][SRC_OFFSET_CAPACITA];
//			$table[$dstpt][DST_OFFSET_STATO_ATTIVITA]			=	($tabella_interessamenti[$srcpt][SRC_OFFSET_STATO_ATTIVITA])==0?'inattivo':'attivo';
			$table[$dstpt][DST_OFFSET_STATO_ATTIVITA]			=	$tabella_interessamenti[$srcpt][SRC_OFFSET_STATO_ATTIVITA];
			$table[$dstpt][DST_OFFSET_NOTE]						=	$tabella_interessamenti[$srcpt][SRC_OFFSET_NOTE];
			$table[$dstpt][DST_OFFSET_REFERENTI_INTERESSATI]	=	"";
			$table[$dstpt][DST_OFFSET_REFERENTI_CONFERMATI]		=	"";
			$table[$dstpt][DST_OFFSET_REFERENTI_PRENOTATI]		=	"";
			
			$dstpt++;
		}

		switch ($tabella_interessamenti[$srcpt][SRC_OFFSET_STATO_ADESIONI]) {
		
			case 'interessato':
				$table[$q][DST_OFFSET_REFERENTI_INTERESSATI] = $tabella_interessamenti[$srcpt][SRC_OFFSET_COUNT];
			break;
			
			case 'confermato':
				$table[$q][DST_OFFSET_REFERENTI_CONFERMATI] = $tabella_interessamenti[$srcpt][SRC_OFFSET_COUNT];
			break;
			
			case 'prenotato':
				$table[$q][DST_OFFSET_REFERENTI_PRENOTATI] = $tabella_interessamenti[$srcpt][SRC_OFFSET_COUNT];
			break;
			
			default:
			break;
		}
		
		$srcpt++;
	}
	
	$tbl_len=count($table);
	
	echo "<div class=\"main\">";
	echo "<table bgcolor=#FFFFFF>";

		$titoli= TITOLI_STATO_ATTIVITA;

		echo "$titoli";
		
		$tbl_pnt=0;
		
		while ($tbl_pnt < $tbl_len) {
			$row_pnt=0;
			$row_len = count($table[0]);
			if ($row_len>0) {
				echo "<tr>";
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

	mysqli_close($dbc);
?>

</body>
</html>
