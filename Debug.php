<?php
	session_start();
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare il futuro - Ricerche</title>

  <link type="text/css" rel="stylesheet" href="praticare.php">

  </head>
<body>
	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>**DEBUG**DEBUG**DEBUG**DEBUG**</h2>
	</div>

	<div class="toolbar">
		<br />
		<a href ="index.html">Torna alla pagina iniziale</a>
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<a href = "Fine.html">Esci</a>
	</div>

	<div class="form">
		<form method="post" action="ricerche12.php">
		RICERCHE
		<br />
		<br />
		<br />
		Criterio di ricerca		(Nessun criterio = tutti i dati)
		<br />
		<br />
		<div class="form_indent">
			<span class="testo"><label for="Adesioni_Attivita">Attivita (adesioni)</label></span>
			<span class="campo"><input type="text" id="Adesioni_Attivita" name="Adesioni_Attivita" /></span>
			<br />
			<br />
			<span class="testo"><label for="Stato_Attivita">Attivita (disponibilita')</label></span>
			<span class="campo"><input type="text" id="Stato_Attivita" name="Stato_Attivita" /></span>
			<br />
			<br />
			<span class="testo"><label for="Contatto"> Contatto</label></span>
			<span class="campo"><input type="text" id="Contatto" name="Contatto" /></span>
			<br />
			<br />
			<span class="testo"><label for="Cognome_Referente">Referente</label></span>
			<span class="campo"><input type="text" id="Cognome_Referente" name="Cognome_Referente" /></span>
			<br />
			<br />
			<span class="testo"><label for="Cognome_Bambino">  Bambino</label></span>
			<span class="campo"><input type="text" id="Cognome_Bambino" name="Cognome_Bambino" /></span>
			<br />
			<br />
		</div>
		<br />
		<br />
		Ordine:
		<br />
		<div class="form_indent">
			Alfabetico <input id="Ordine" name="Ordine" type="radio" value="ALFABETICO" checked="checked"/>
			Cronologico <input id="Ordine" name="Ordine" type="radio" value="CRONOLOGICO"/>
		</div>
		<br />
		<br />
		Dettaglio:
		<br />
		<div class="form_indent">
			Sintesi <input id="Dettaglio" name="Dettaglio" type="radio" value="SINTESI"/>
			Completo <input id="Dettaglio" name="Dettaglio" type="radio" checked="checked" value="COMPLETO"/>
		</div>
		<br />
		<br />
		<br />
		<br />
		<input type="submit" value="Ricerca" name="submit" />
		</form>
  	</div>
</body>
</html>
