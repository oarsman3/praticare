<?php
	include 'definizioni.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare il futuro - Crea Referente</title>

  <link type="text/css" rel="stylesheet" href="praticare.php">

  </head>
	<body>

	<?php
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
							or die('crea_referente.html: Error connecting to MySQL server.');
	?>

	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Crea Referente</h2>
	</div>
	
	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

	<div class="form">
	<form method="post" action="crea_referente.php">

		CREA REFERENTE
		<br />
		<br />
		<br />
		Contatto a cui e' associato il referente
		<br />
		<br />
		<div class="form_indent">
			<span class="testo"><label for="Identificativo">Identificativo</label></span>
			<span class="campo">
				<select id="Identificativo" name="Identificativo" />
					<?php
					$query = "SELECT Anagrafica_Contatto.Identificativo FROM Anagrafica_Contatto ORDER BY Anagrafica_Contatto.Identificativo ";
					$result = mysqli_query($dbc, $query)
										or die('crea_referente_main.php: Error querying database - 1');
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
		Dati Referente
		<br />
		<br />
		<div class="form_indent">
			<span class="testo"><label for="Nome">Nome</label></span>
			<span class="campo"><input type="text" id="Nome" name="Nome" /></span>
			<br/>
			<br/>
			<span class="testo"><label for="Cognome">Cognome</label></span>
			<span class="campo"><input type="text" id="Cognome" name="Cognome" /></span>
			<br/>
			<br/>
			<span class="testo"><label for="P_IVA">C.F/P.IVA</label></span>
			<span class="campo"><input type="text" id="P_IVA" name="P_IVA" /></span>
			<br/>
			<br/>
			<span class="testo"><label for="NR_TEL">Nr Tel</label></span>
			<span class="campo"><input type="text" id="NR_TEL" name="NR_TEL" /></span>
			<br/>
			<br/>
			<span class="testo"><label for="Email">E-Mail</label></span>
			<span class="campo"><input type="email" id="Email" name="Email" /></span>
			<br/>
			<br/>
			<span class="testo"><label for="Indirizzo">Indirizzo</label></span>
			<span class="campo"><input type="text" id="Indirizzo" name="Indirizzo" /></span>
			<br/>
			<br/>
			<span class="testo"><label for="CAP">CAP</label></span>
			<span class="campo"><input type="text" id="CAP" name="CAP" /></span>
			<br/>
			<br/>
			<span class="testo"><label for="Comune">Comune</label></span>
			<span class="campo"><input type="text" id="Comune" name="Comune" /></span>
			<br/>
			<br/>
			<span class="testo"><label for="Note">Note</label></span>
			<span class="campo"><textarea id="Note" name="Note"></textarea></span>
		</div>
		<br/>
		<br/>
		<br/>
		Attivita' a cui e' interessato
		<br/>
		<br/>
		<div class="form_indent">
			<span class="testo"><label for="Nome_Attivita">Nome Attivita'</label></span>
			<span class="campo">
				<select id="Nome_Attivita" name="Nome_Attivita" />
					<?php
					$result = mysqli_query($dbc, "SELECT Lista_Attivita_Adesioni.Nome_Attivita FROM Lista_Attivita_Adesioni ORDER BY Lista_Attivita_Adesioni.Nome_Attivita ")
										or die('crea_referente_main.php: Error querying database - 2');
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
			<br/>
			<br/>
			<span class="testo"><label for="Stato">Numero Partecipanti </label></span>
			<span class="campo">
				<input id="Num_Partecipanti" name="Num_Partecipanti" type="number" min="0"/>
			</span>
			<br/>
			<br/>
			<span class="testo"><label for="Stato">Stato</label></span>
			<span class="campo">
				<input id="Stato_Adesione" name="Stato_Adesione" type="radio" checked="checked" value="interessato"/>Interessato
				<input id="Stato_Adesione" name="Stato_Adesione" type="radio" value="prenotato"/>Prenotato
				<input id="Stato_Adesione" name="Stato_Adesione" type="radio" value="confermato"/>Confermato
			</span>
			<br/>
			<br/>
			<span class="testo"><label for="Note_Adesione">Note Adesione</label></span>
			<span class="campo"><textarea id="Note_Adesione" name="Note_Adesione"></textarea></span>
		</div>

		<?php
		mysqli_close($dbc);
		?>

		<br/>
		<br/>
		<br/>
		<input type="submit" value="Crea Referente" name="submit" />
	</form>
	</div>
</body>
</html>
