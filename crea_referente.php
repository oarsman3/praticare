<?php
	include 'definizioni.php';
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
		<h2>Crea Referente</h2>
	</div>

	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

<?php
	$Identificativo		= $_POST['Identificativo'];
	$Nome				= $_POST['Nome'];
	$Cognome			= $_POST['Cognome'];
	$P_IVA				= $_POST['P_IVA'];
	$NR_TEL				= $_POST['NR_TEL'];
	$Email				= $_POST['Email'];
	$Indirizzo			= $_POST['Indirizzo'];
	$CAP				= $_POST['CAP'];
	$Comune				= $_POST['Comune'];
	$Note				= $_POST['Note'];
	$Nome_Attivita 		= $_POST['Nome_Attivita'];
	$Num_Partecipanti	= $_POST['Num_Partecipanti'];
	$Stato_Adesione		= $_POST['Stato_Adesione'];
	$Note_Adesione		= $_POST['Note_Adesione'];
	
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
		or die('crea_referente.php: Error connecting to MySQL server.');

// verifica se esiste il contatto a cui verra' associato il referente		
	$query = "SELECT * FROM Anagrafica_Contatto WHERE Anagrafica_Contatto.Identificativo = '$Identificativo'";
	$result = mysqli_query($dbc, $query)
		or die('crea_referente.php: Error querying database - 1');

	$num_rows=mysqli_num_rows($result);
	if($num_rows==0) {
		echo "<div class=\"info\">";
			echo "il contatto $Identificativo non esiste, e' necessario crearlo prima di creare il Referente";
			echo "<br>";
			echo "<br>";
			echo "<a href = \"crea_referente_main.php\">Indietro</a>";
		echo "</div>";
	}
	else {	

		$row = mysqli_fetch_array($result); 

		$ID = $row['ID_Contatto'];

// verifica se esiste gia' il referente ssociato al contatto
		$query = "SELECT * FROM Anagrafica_Referente WHERE Anagrafica_Referente.Cognome_Ref = '$Cognome' AND Anagrafica_Referente.Nome_Ref = '$Nome' AND Anagrafica_Referente.FK_contatto = " . $ID ;

		$result = mysqli_query($dbc, $query) or die('crea_referente.php: Error querying database - 2');

		$num_rows=mysqli_num_rows($result);

		if($num_rows!=0) {
			echo "<div class=\"info\">";
				echo "l/'anagrafica referente $Cognome $Nome associata al contatto esiste gia/'";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<a href = \"crea_referente_main.php\">Indietro</a>";
				echo "<br>";
				echo "<a href = \"gestione_anagrafiche.html\">Torna a gestione anagrafiche</a>";
			echo "</div>";
		}
		else {

			$query = "INSERT INTO Anagrafica_Referente (FK_contatto, Nome_Ref, Cognome_Ref, P_IVA, NR_TEL, E_MAIL, Indirizzo, CAP, Comune, Note_Ref) " .
				"VALUES ('$ID', '$Nome', '$Cognome', '$P_IVA', '$NR_TEL', '$Email', '$Indirizzo', '$CAP', '$Comune', '$Note')";
	
			$result = mysqli_query($dbc, $query)
				or die('crea_referente.php: Error querying database - 3');
	
// se indicata nel form, associa attivita' al Referente
			if ($Nome_Attivita!="") {
	
// recupera ID referente
				$query = "SELECT * FROM Anagrafica_Referente WHERE Anagrafica_Referente.Cognome_Ref = '$Cognome' AND Anagrafica_Referente.Nome_Ref = '$Nome' AND Anagrafica_Referente.FK_contatto = '$ID'";
				$result = mysqli_query($dbc, $query) or die('crea_referente.php: Error querying database - 4');
				$row = mysqli_fetch_array($result); 
				$ID_Referente = $row['ID_Referente'];
	
// recupera ID attivita'
				$query = "SELECT * FROM Lista_Attivita_Interessamenti " . "WHERE (((Lista_Attivita_Interessamenti.Nome_Attivita_Interessamento) LIKE '%" . $Nome_Attivita . "%')) ";
				$result = mysqli_query($dbc, $query) or die('crea_referente.php: Error querying database - 5');			
				$row = mysqli_fetch_array($result); 
				$ID_Attivita = $row['ID_Interessamento'];
	
// crea associazione referente-attivita nella tablella Interessamenti
				$query = "INSERT INTO Interessamenti (FK_Referente, FK_Attivita_Referente, Stato, Num_Partecipanti, Note) VALUES ('$ID_Referente', '$ID_Attivita', '$Stato_Adesione', '$Num_Partecipanti', '$Note_Adesione')";

				$result = mysqli_query($dbc, $query) or die('crea_referente.php: Error querying database - 6');	
			}
				
			echo "<div class=\"main\">";
			echo "<table bgcolor=#FFFFFF>";
	
// mostra righe contatto appena creato
	
				$query = MYSQLI_REFERENTI_COMPLETO . MYSQLI_STD_FROM . "WHERE Anagrafica_Referente.Cognome_Ref = '$Cognome' AND Anagrafica_Referente.Nome_Ref = '$Nome' ;";
				$result = mysqli_query($dbc, $query)
							or die('crea_referente.php: Error querying database - 4');
				
				$table = array();
				$tbl_pnt=0;
				while ($row = mysqli_fetch_array($result)) {
					$table[$tbl_pnt]=$row;
					$tbl_pnt+=1;
				}
	
				$tbl_len=count($table);
	
				echo TITOLI_TABELLA_REFERENTI_COMPLETO;
				
				$tbl_pnt=0;	
				while ($tbl_pnt < $tbl_len) {		
					$row_pnt=0;
					$row_len = count($table[0]) / 2;
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
	
			echo "<div class=\"info\">";
				echo "Il referente e' stato creato";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<a href = \"crea_referente_main.php\">Crea altro referente</a>";
				echo "<br>";
				echo "<a href = \"gestione_anagrafiche.html\">Torna a gestione anagrafiche</a>";
				echo "<br>";
				echo "<a href = \"index.html\">Torna al menu principale</a>";
			echo "</div>";
		}
	}
	
	mysqli_close($dbc);
	
?>

</body>
</html>
