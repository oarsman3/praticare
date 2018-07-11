<?php
	include 'definizioni.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Praticare il futuro - Cancella Referente</title>

	<link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>

	<script>
	
		window.onload=init;

		function init() {
			var Referente = document.getElementById("Referente");
			Referente.onchange=getContatto;
		}
		
		function getContatto(eventObj) {
		
			var httpRequest = createXMLHTTPinstance();			
			if (!httpRequest) {
    			alert('cancella_referente_main.php (getContatto) : Cannot create an XMLHTTP instance');
      			return false;
			}
			
			var cognomeRef = Referente.value.slice(0,Referente.value.search(" - "));
			var nomeRef = Referente.value.slice(Referente.value.search(" - ")+3,Referente.value.length);

			var param1=encodeURIComponent("LISTA_CONTATTI_REFERENTE");
			var param2=encodeURIComponent(cognomeRef);
			var param3=encodeURIComponent(nomeRef);
			if (param2 != "-------------" && param3 != "-------------") {
				var params='TipoDato='+param1+'&KeyOne='+param2+'&KeyTwo='+param3;

				httpRequest.open('GET', 'recuperaDati.php?'+params, false);	// chiamata sincrona
    			httpRequest.send(params);

			    if (httpRequest.readyState === 4) {
					if (httpRequest.status === 200) {
					
						var jar=JSON.parse(httpRequest.responseText);

						var Contatto = document.getElementById("Contatto");
						Contatto.style.backgroundColor = "white";
						document.getElementById("InputContatto").style.color = "blue";
						Contatto.disabled = false;
					    while (Contatto.options.length) {
							Contatto.remove(0);
					    }

					    for (p = 0; p < jar.length; p++) {
					    	var newContatto = new Option(jar[p].Identificativo, jar[p].Identificativo);
					        Contatto.options.add(newContatto);
					    }
						document.getElementById("submit").disabled = false;
						document.getElementById("submit").style.backgroundColor = "white";					
				    }
					else {
						alert('cancella_referente_main.php (getContatto.js): There was a problem with the request.');
					}
			    }
			}
		}
		
	</script>

	<?php
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
							or die('crea_referente.html: Error connecting to MySQL server.');
	?>

	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Cancella Referente</h2>
	</div>
	
	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

	<div class="form">
	<form method="post" action="cancella_referente.php">

		CANCELLA REFERENTE
		<br />
		<br />
		<br />
		Dati Referente da cancellare
		<br />
		<br />
		<br />
		<div class="form_indent">
			<span class="testo"><label for="Referente">Referente</label></span>
			<span class="campo">			
				<select id="Referente" name="Referente" />
					<?php
					$result = mysqli_query($dbc,"SELECT DISTINCT Anagrafica_Referente.Cognome_Ref,Anagrafica_Referente.Nome_Ref FROM Anagrafica_Referente ORDER BY Anagrafica_Referente.Cognome_Ref ")
									or die('modifica_referente_main.php: Error querying database - 1');
					?>
					<option " <?php echo '-------------'; ?> " ><?php echo '-------------'; ?></option>
					<?php
					while($row_list=mysqli_fetch_array($result,MYSQLI_BOTH)) {
					?>
						<option " <?php echo $row_list['Cognome_Ref']," ",$row_list['Nome_Ref']; ?> " ><?php echo $row_list['Cognome_Ref'],STRNGSEP,$row_list['Nome_Ref']; ?></option>
					<?php
					}
					?>
				</select>
			</span>
			
			<div id="InputContatto" style = "color:grey">			
				<br />
				<br />
				<br />
				<span class="testo"><label for="Contatto">Contatto associato</label></span>
				<span class="campo">
					<select id="Contatto" name="Contatto" style="background-color:#dff52f" disabled/>
						<option " <?php echo '-------------'; ?> " ><?php echo '-------------'; ?></option>
					</select>
				</span>
			</div>
				
		<br/>
		<br/>
		<br/>
		<input id="submit" type="submit" value="Cancella Referente" name="submit" disabled/>
	</form>
	</div>
	
	<script src="praticare.js"></script>

</body>
</html>
