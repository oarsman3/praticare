<?php
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare Il Futuro - Modifica Referente</title>
  
  <link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>
	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Modifica Referente</h2>
	</div>

	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

<?php

	$arrkeys = array_keys($_POST);	

	$referente					= $_POST['Referente'];
	$cognomeRef					= strtok($referente, STRNGSEP);
	$nomeRef					= "";
	$toc						= strtok(STRNGSEP);
	while ($toc !== false) {
		$nomeRef .= $toc . " ";
		$toc = strtok(STRNGSEP);
	}
	$nomeRef = rtrim($nomeRef," ");


	$Contatto						= $_POST['Contatto'];
	$P_IVA							= $_POST['P_IVA'];
	$NR_TEL							= $_POST['NR_TEL'];
	$E_MAIL							= $_POST['E_MAIL'];
	$Indirizzo						= $_POST['Indirizzo'];
	$CAP							= $_POST['CAP'];
	$Comune							= $_POST['Comune'];
	$Note_Ref						= $_POST['Note'];
	
	$nAttivita = (count($_POST)-10)/5;
	$cnt=0;
	while($cnt<$nAttivita){
		$ID_Interessamenti_att[$cnt]		= $_POST[$arrkeys[9+$cnt*5]];
		$Nome_Attivita_att[$cnt]			= $_POST[$arrkeys[10+$cnt*5]];
		$Num_Partecipanti_att[$cnt]			= $_POST[$arrkeys[11+$cnt*5]];
		$Stato_Interessamento_att[$cnt]		= $_POST[$arrkeys[12+$cnt*5]];
		$Note_Interessamento_att[$cnt]		= $_POST[$arrkeys[13+$cnt*5]];
		$cnt++;
	}		
				
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
							or die('Error connecting to MySQL server.');

	echo "<div class=\"main\">";
	echo "<table bgcolor=#FFFFFF>";

	$query = "UPDATE Anagrafica_Referente SET P_IVA = '$P_IVA',	NR_TEL = '$NR_TEL', E_MAIL = '$E_MAIL', Indirizzo = '$Indirizzo', CAP = '$CAP', Comune = '$Comune', Note_Ref = '$Note_Ref' " . 
			 "WHERE Nome_Ref LIKE '$nomeRef' AND Cognome_Ref LIKE '$cognomeRef' AND FK_Contatto LIKE (SELECT ID_Contatto FROM Anagrafica_Contatto WHERE Identificativo LIKE '$Contatto') ";
				 
	$result = mysqli_query($dbc, $query)
					or die('modifica_referente.php: Error querying database - 1');		

	echo "<br>";
	echo "+++++ n attivita: ",$nAttivita,"<br>";
	echo "<br>";

	$cnt=0;
	while($cnt<$nAttivita){

		$nk=count($arrkeys);
		$pnt=0;
		while($pnt<$nk){
			echo $arrkeys[$pnt],": ",$_POST[$arrkeys[$pnt]],"<br>";
			$pnt++;
		}
		echo"<br>";
		echo "ID_Interessamenti_att["		,$cnt,"]: ",$ID_Interessamenti_att[$cnt],		"<br>";
		echo "Nome_Attivita_att["			,$cnt,"]: ",$Nome_Attivita_att[$cnt],			"<br>";
		echo "Num_Partecipanti_att["		,$cnt,"]: ",$Num_Partecipanti_att[$cnt],		"<br>";
		echo "Stato_Interessamento_att["	,$cnt,"]: ",$Stato_Interessamento_att[$cnt],	"<br>";
		echo "Note_Interessamento_att["		,$cnt,"]: ",$Note_Interessamento_att[$cnt],		"<br>";
		echo "<br>";
			
		$ID_Interessamenti		= $ID_Interessamenti_att[$cnt];
		$Nome_Attivita			= $Nome_Attivita_att[$cnt];
		$Num_Partecipanti		= $Num_Partecipanti_att[$cnt];
		$Stato_Interessamento	= $Stato_Interessamento_att[$cnt];
		$Note_Interessamento	= $Note_Interessamento_att[$cnt];
			
		if($ID_Interessamenti==0 && $Nome_Attivita!='-------------'){

				// crea nuova associazione referente-interessamento nella tabella Interessamenti

				$query =	"INSERT INTO Interessamenti (FK_Referente, FK_Attivita_Referente, Stato, Num_Partecipanti, Note) VALUES " .
							"((SELECT ID_Referente FROM Anagrafica_Referente WHERE Nome_Ref LIKE '$nomeRef' AND Cognome_Ref LIKE '$cognomeRef' AND FK_Contatto LIKE (SELECT ID_Contatto FROM Anagrafica_Contatto WHERE Identificativo LIKE '$Contatto')), " .
							"(SELECT ID_Interessamento FROM Lista_Attivita_Interessamenti WHERE Lista_Attivita_Interessamenti.Nome_Attivita_Interessamento LIKE '$Nome_Attivita'), " .
							"'$Stato_Interessamento', '$Num_Partecipanti', '$Note_Interessamento') ";			

				echo "+ + + crea nuova associazione referente-interessamento nella tabella Interessamenti<br>";
				echo "$query<br>";
				echo "<br>";
		}
		else {

				// aggiorna associazione referente-interessamento
						
			$query =	"UPDATE Interessamenti SET FK_Attivita_Referente = (SELECT ID_Interessamento FROM Lista_Attivita_Interessamenti WHERE Nome_Attivita_Interessamento LIKE '$Nome_Attivita'), Stato = '$Stato_Interessamento', " .
						"Num_Partecipanti = '$Num_Partecipanti', Note = '$Note_Interessamento' WHERE ID_Interessamenti LIKE '%" . $ID_Interessamenti . "%' ";
		echo "+ + + aggiorna associazione referente-interessamento<br>";
		echo "$query<br>";
		echo "<br>";
		}
		
		$result = mysqli_query($dbc, $query)
						or die('modifica_referente.php: Error querying database - 2');			

		$cnt++;
	}		

	// verifica se nel db ci sono associazioni da cancellare
	$query =	"SELECT ID_Interessamenti FROM Interessamenti WHERE FK_Referente LIKE (SELECT ID_Referente FROM Anagrafica_Referente WHERE Nome_Ref LIKE '$nomeRef' AND Cognome_Ref LIKE '$cognomeRef' AND " .
				"FK_Contatto LIKE (SELECT ID_Contatto FROM Anagrafica_Contatto WHERE Identificativo LIKE '$Contatto')) ";

	echo "+ + + verifica se nel db ci sono associazioni da cancellare<br>";
	echo "$query<br>";
	echo "<br>";
	
	$result = mysqli_query($dbc, $query)
						or die('modifica_referente.php: Error querying database - 3');			
	
	while ($row = mysqli_fetch_array($result)) {
		$IDInt=$row[ID_Interessamenti];
		$cnt=0;
		$found=false;
		while($cnt<nAttivita && !found){
			if($ID_Interessamenti_att[$cnt]==$IDInt){
				$found=true;
			}
			$cnt++;
		}
		if(!found){	// cancella associazione
			$query =	"DELETE FROM Interessamenti WHERE ID_Interessamenti LIKE '%" . $row[ID_Interessamenti] . "%' ";
			echo "+ + + cancella associazione<br>";
			echo "$query<br>";
			echo "<br>";
			mysqli_query($dbc, $query) or die('modifica_referente.php: Error querying database - 4');			
		}
	}



	
	mysqli_close($dbc);

	echo "</table>";
	echo "</div>";

	echo "<div class=\"info\">";
		echo "Il referente e' stato modificato";
		echo "<br>";
		echo "<br>";
		echo "<a href = \"modifica_referente_main.php\">modifica altro referente</a>";
		echo "<br>";
		echo "<a href = \"gestione_anagrafiche\">torna a gestione anagrafiche</a>";
		echo "<br>";
		echo "<a href = \"index.html\">Torna al menu principale</a>";		
	echo "</div>";

?>

</body>
</html>
