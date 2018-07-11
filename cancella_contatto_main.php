<?php
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare il futuro - Cancella Contatto</title>

  <link type="text/css" rel="stylesheet" href="praticare.php">

  </head>
	<body>

	<?php
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
							or die('crea_referente.html: Error connecting to MySQL server.');
	?>

	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Cancella Contatto</h2>
	</div>
	
	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

	<div class="form">
	<form method="post" action="cancella_contatto.php">

		CANCELLA CONTATTO
		<br />
		<br />
		<br />
		Dati Contatto da cancellare
		<br />
		<br />
		<div class="form_indent">
			<span class="testo"><label for="Identificativo">Identificativo</label></span>
			<span class="campo">
				<select id="Identificativo" name="Identificativo" />
					<?php
					$query = "SELECT Anagrafica_Contatto.Identificativo FROM Anagrafica_Contatto ORDER BY Anagrafica_Contatto.Identificativo ";
					$result = mysqli_query($dbc, $query)
										or die('cancella_contatto_main.php: Error querying database - 1');
					?>
					<option " <?php echo TUTTI; ?> " ><?php echo TUTTI; ?></option>
					<?php
					while($row_list=mysqli_fetch_array($result,MYSQLI_BOTH)) {
						$id=$row_list['Identificativo'];
					?>
						<option " <?php echo $id; ?> " ><?php echo $id; ?></option>
					<?php
					}
					?>
				</select>
			</span>
		</div>
		<br/>
		<br/>
		<br/>
		<input type="submit" value="Cancella Contatto" name="submit" />
	</form>
	</div>
</body>
</html>
