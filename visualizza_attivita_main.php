<?php
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare il futuro - Visualizza Attivita'</title>

  <link type="text/css" rel="stylesheet" href="praticare.php">

  </head>
<body>

	<?php
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
							or die('crea_referente.html: Error connecting to MySQL server.');
	?>

	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Visualizza Attivita'</h2>
	</div>

	<div class="toolbar">
	
		<div class="firstoption"><a href ="gestione_attivita.html">Torna alla gestione attivita'</a>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>

	</div>



	<div class="form">
		<form method="post" action="visualizza_attivita.php">
		VISUALIZZAZIONE STATO ATTIVITA'
		<br />
		<br />
		<br />
		<div class="form_indent">
			<span class="testo"><label for="Nome_Attivita">Nome Attivita'</label></span>
			<span class="campo">
				<select id="Nome_Attivita" name="Nome_Attivita" />
					<?php
					$result = mysqli_query($dbc, "SELECT Lista_Attivita_Adesioni.Nome_Attivita FROM Lista_Attivita_Adesioni ORDER BY Lista_Attivita_Adesioni.Nome_Attivita ")
										or die('crea_bambino_main.php: Error querying database - 2');
					?>
					<option " <?php echo TUTTI; ?> " ><?php echo TUTTI; ?></option>
					<?php
					while($row_list=mysqli_fetch_array($result,MYSQLI_BOTH)) {
					?>
						<option " <?php echo $row_list['Nome_Attivita']; ?> " ><?php echo $row_list['Nome_Attivita']; ?></option>
					<?php
					}
					?>
				</select>
			</span>
		</div>
		<br />
		<br />
		<br />
		Stato Attivita'
		<br />
		<br />
		<div class="form_indent">
			Previste<input name="Stato" type="Radio"/>
			Attive<input name="Stato" type="Radio"/>
			Terminate<input name="Stato" type="Radio"/>
			Tutte<input name="Stato" type="Radio" checked="checked"/>
		</div>
		<br />
		<br />
		<br />
		<br />
		<br />
		<input type="submit" value="Visualizza Attivita" name="submit" />
		</form>
  	</div>
</body>
</html>
