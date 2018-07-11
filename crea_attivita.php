<?php
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare Il Futuro - Crea Attivita'</title>
  
  <link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>
	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Crea Attivita</h2>
	</div>

	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_attivita.html">Torna a Gestione Attivita'</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

<?php
	$Nome_Attivita = $_POST['Nome_Attivita'];
	$Tipo = $_POST['Tipo'];
	$Stato=(isset($_POST['Stato'])?True:False);
	$Capacita = (int) $_POST['Capacita'];
	$data = strtotime ($_POST['Inizio']);
	$Inizio = date('d-n-y',$data);
	$data = strtotime ($_POST['Fine']);
	$Fine = date('d-n-y',$data);
	$Note = $_POST['Note'];
	
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
		or die('crea_attivita.php: Error connecting to MySQL server.');

	$query = "SELECT * FROM Lista_Attivita_Adesioni " . "WHERE Lista_Attivita_Adesioni.Nome_Attivita='$Nome_Attivita'";
	
	$result = mysqli_query($dbc, $query)
			or die('crea_attivita.php: Error querying database - 1');

	$num_rows = mysqli_num_rows($result);
	if($num_rows>0) {
		echo "<div class=\"info\">";
			echo "L'attivita' $Nome_Attivita esiste gia'";
			echo "<br>";
			echo "<br>";
			echo "<a href = \"crea_attivita.html\">Indietro</a>";
		echo "</div>";
	}
	else {
	
// memorizza dati nuova attivita' nella tabella delle associazioni bambini-attivita (adesioni)
		$query = "INSERT INTO Lista_Attivita_Adesioni (Nome_Attivita, Tipo, Stato, Capacita, Inizio, Fine, Note) " .
			"VALUES ('$Nome_Attivita', '$Tipo', '$Stato', '$Capacita', '$Inizio', '$Fine', '$Note')";

		$result = mysqli_query($dbc, $query)
			or die('crea_attivita.php: Error querying database - 2');
	
// memorizza dati nuova attivita' nella tabella delle associazioni referenti-attivita (interessamenti)
		$query = "INSERT INTO Lista_Attivita_Interessamenti (Nome_Attivita_Interessamento, Tipo, Stato, Capacita, Inizio, Fine, Note) " .
			"VALUES ('$Nome_Attivita', '$Tipo', '$Stato', '$Capacita', '$Inizio', '$Fine', '$Note')";

		$result = mysqli_query($dbc, $query)
			or die('crea_attivita.php: Error querying database - 3');

		mysqli_close($dbc);

		echo "<div class=\"info\">";
			echo "l'Attivita' \"$Nome_Attivita\" e' stata creata";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<a href = \"crea_attivita.html\">Crea altra Attivita'</a>";
			echo "<br>";
			echo "<br>";
			echo "<a href = \"gestione_attivita.html\">Torna a gestione Attivita'</a>";
			echo "<br>";
			echo "<br>";
			echo "<a href = \"index.html\">Torna al menu principale</a>";
		echo "</div>";

	}
?>

</body>
</html>
