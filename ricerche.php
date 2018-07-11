<?php
	include 'definizioni.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare il futuro - Ricerche</title>

  <link type="text/css" rel="stylesheet" href="praticare.php">

  </head>
	<body>

	<?php
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
							or die('crea_referente.html: Error connecting to MySQL server.');
	?>

	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Ricerche</h2>
	</div>
	
	<div class="toolbar">
	
		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

	<div class="form">
	<form method="post" action="ricerche14.php">

		RICERCHE
		<br />
		<br />
		<br />
		Criterio di ricerca
		<br />
		<br />
		<div class="form_indent">
			<span class="testo"><label for="Attivita">Attivita</label></span>
			<span class="campo">
				<select id="Attivita" name="Attivita" />
					<?php
					$result = mysqli_query($dbc, "SELECT DISTINCT Lista_Attivita_Adesioni.Nome_Attivita FROM Lista_Attivita_Adesioni ORDER BY Lista_Attivita_Adesioni.Nome_Attivita ")
										or die('crea_referente_main.php: Error querying database - 1');
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
		<br/>
		<div class="form_indent">
			<span class="testo"><label for="Contatto">Contatto</label></span>
			<span class="campo">
				<select id="Contatto" name="Contatto" />
					<?php
					$result = mysqli_query($dbc,"SELECT DISTINCT Anagrafica_Contatto.Identificativo FROM Anagrafica_Contatto ORDER BY Anagrafica_Contatto.Identificativo ")
											or die('ricerche_main.php: Error querying database - 2');
					?>
					<option " <?php echo '-------------'; ?> " ><?php echo '-------------'; ?></option>
					<?php
					while($row_list=mysqli_fetch_array($result,MYSQLI_BOTH)) {
					?>
						<option " <?php echo $row_list['Identificativo']; ?> " ><?php echo $row_list['Identificativo']; ?></option>
					<?php
					}
					?>
				</select>
			</span>
		</div>
		<br/>
		<div class="form_indent">
			<span class="testo"><label for="Referente">Referente</label></span>
			<span class="campo">
				<select id="Referente" name="Referente" />
					<?php
					$result = mysqli_query($dbc,"SELECT DISTINCT Anagrafica_Referente.Cognome_Ref,Anagrafica_Referente.Nome_Ref FROM Anagrafica_Referente ORDER BY Anagrafica_Referente.Cognome_Ref ")
									or die('ricerche_main.php: Error querying database - 3');
					?>
					<option " <?php echo '-------------'; ?> " ><?php echo '-------------'; ?></option>
					<?php
					while($row_list=mysqli_fetch_array($result,MYSQLI_BOTH)) {
					?>
						<option " <?php echo $row_list['Cognome_Ref']," ",$row_list['Nome_Ref']; ?> " ><?php echo $row_list['Cognome_Ref']," ",STRNGSEP,$row_list['Nome_Ref']; ?></option>
					<?php
					}
					?>
				</select>
			</span>
		</div>
		<br/>
		<div class="form_indent">
			<span class="testo"><label for="Bambino">Bambino</label></span>
			<span class="campo">
				<select id="Bambino" name="Bambino" />
					<?php
					$result = mysqli_query($dbc,"SELECT DISTINCT Bambini.Cognome,Bambini.Nome FROM Bambini ORDER BY Bambini.Cognome ")
									or die('ricerche_main.php: Error querying database - 4');
					?>
					<option " <?php echo '-------------'; ?> " ><?php echo '-------------'; ?></option>
					<?php
					while($row_list=mysqli_fetch_array($result,MYSQLI_BOTH)) {
					?>
						<option " <?php echo $row_list['Cognome']," ",$row_list['Nome']; ?> " ><?php echo $row_list['Cognome']," ",STRNGSEP,$row_list['Nome']; ?></option>
					<?php
					}
					?>
				</select>
			</span>
		</div>
		
		<br />
		Cronologico  <input name="Ordine_Cronologico" type="checkbox" checked="checked"/>
		Alfabetico   <input name="Ordine_Alfabetico" type="checkbox" />
		<br />
		Crescente    <input id="Ordine_Sort" name="Ordine_Sort" type="radio" value="CRESCENTE" checked="checked"/>
		Decrescente  <input id="Ordine_Sort" name="Ordine_Sort" type="radio" value="DECRESCENTE"/>
		<br />
		<br />
		DATI AGGREGATI        <input name="Pivot" type="checkbox" checked="checked"/>
		<?php
		mysqli_close($dbc);
		?>

		<br/>
		<br/>
		<br/>
		<br/>
		<input type="submit" value="Ricerca" name="submit" />
	</form>
	</div>
</body>
</html>
