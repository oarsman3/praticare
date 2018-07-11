<?php
	include 'definizioni.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare il futuro - Modifica Attivita'</title>

  <link type="text/css" rel="stylesheet" href="praticare.php">

  </head>
	<body>
	
	<script>

		var Attivita;

		window.onload=init;

		function init() {
//			var Attivita = document.getElementById("Nome_Attivita");
			Attivita = document.getElementById("Nome_Attivita");
			Attivita.onchange=getAttivita;		
		}

		function getAttivita(eventObj) {

console.log("getAttivita");

			var httpRequest = createXMLHTTPinstance();			
			if (!httpRequest) {
    			alert('getRefData.php : Cannot create an XMLHTTP instance');
      			return false;
			}
			
			var param1=encodeURIComponent("DATI_ATTIVITA");
			var param2=encodeURIComponent(Attivita.value);
			var params='TipoDato='+param1+'&KeyOne='+param2;

console.log("params: ",params);

			httpRequest.open('GET', 'recuperaDati.php?'+params, false);	// chiamata sincrona
   			httpRequest.send(params);

		    if (httpRequest.readyState === 4) {
				if (httpRequest.status === 200) {
					console.log(httpRequest.responseText);
					var jar=JSON.parse(httpRequest.responseText);
					var jap=jar[0];

console.log("jap: ",jap);
					
					document.getElementById("allInputs").style.color = "blue";
					
					document.getElementById("Tipo").value = jap.Tipo;
					document.getElementById("Tipo").disabled = false;
					document.getElementById("Tipo").style.backgroundColor = "white";

					document.getElementById("Stato_Attivita_Previsto").disabled = false;
					document.getElementById("Stato_Attivita_Attivo").disabled = false;
					document.getElementById("Stato_Attivita_Terminato").disabled = false;
					switch (jap.Stato) {
						case "Previsto":
							document.getElementById("Stato_Attivita_Previsto").checked = true;
						break;
						case "Attivo":
							document.getElementById("Stato_Attivita_Attivo").checked = true;
						break;
						case "Terminato":
							document.getElementById("Stato_Attivita_Terminato").checked = true;
						break;
					}

					document.getElementById("Capacita").value = jap.Capacita;
					document.getElementById("Capacita").disabled = false;
					document.getElementById("Capacita").style.backgroundColor = "white";

					document.getElementById("Inizio").value = jap.Inizio;
					document.getElementById("Inizio").disabled = false;
					document.getElementById("Inizio").style.backgroundColor = "white";

					document.getElementById("Fine").value = jap.Fine;
					document.getElementById("Fine").disabled = false;
					document.getElementById("Fine").style.backgroundColor = "white";

					document.getElementById("Note").value = jap.Note;
					document.getElementById("Note").disabled = false;
					document.getElementById("Note").style.backgroundColor = "white";
					
					document.getElementById("submit").disabled = false;
					document.getElementById("submit").style.backgroundColor = "white";

				}
				else {
					alert('modifica_attivita_main.php(getContatto.js): There was a problem with the request.');
				}
		    }
		}

	
	</script>
	
	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Modifica Attivita'</h2>
	</div>
	
	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_attivita.html">Torna a Gestione Attivita'</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

	<?php
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
    				or die('visualizza_attivita.php: Error connecting to MySQL server.');
	?>
	
	<div class="form">
	<form method="post" action="modifica_attivita.php">

		MODIFICA ATTIVITA'
		<br />
		<br />
		<br />
		<span class="testo"><label for="Nome_Attivita">Nome Attivita'</label></span>
		<span class="campo">			
			<select id="Nome_Attivita" name="Nome_Attivita"/>
				<?php
				$result = mysqli_query($dbc, "SELECT Lista_Attivita_Adesioni.Nome_Attivita FROM Lista_Attivita_Adesioni ORDER BY Lista_Attivita_Adesioni.Nome_Attivita ")
											or die('modifica_attivita_main.php: Error querying database - 1');
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

		<div class="form_indent">
			<div id="allInputs" style = "color:grey">
				<br />
				<br />
				Dati Attivita'

				<br/>
				<br/>
				<span class="testo"><label for="Tipo">Tipo</label></span>
				<span class="campo">
					<select id="Tipo" name="Tipo" style="background-color:#dff52f" disabled/>
						<option value="null">     </option>
						<option value="Corso">corso</option>
						<option value="Campus">campus</option>
					</select>
				</span>

				<br/>
				<br/>
				<span class="testo"><label for="Stato">Stato</label></span>
				<span class="campo">
					<input id="Stato_Attivita_Previsto" name="Stato_Attivita" type="radio" value="Previsto" disabled/>previsto
					<input id="Stato_Attivita_Attivo" name="Stato_Attivita" type="radio" value="Attivo" disabled/>attivo
					<input id="Stato_Attivita_Terminato" name="Stato_Attivita" type="radio" value="Terminato" disabled/>terminato
				</span>

				<br/>
				<br/>
				<span class="testo"><label for="Capacita">Capacita'</label></span>
				<span class="campo"><input type="text" id="Capacita" name="Capacita" style="background-color:#dff52f" disabled/></span>

				<br/>
				<br/>
				<span class="testo"><label for="Inizio">Inizio</label></span>
				<span class="campo"><input type="date" id="Inizio" name="Inizio" style="background-color:#dff52f" disabled/></span>

				<br/>
				<br/>
				<span class="testo"><label for="Fine">Fine</label></span>
				<span class="campo"><input type="date" id="Fine" name="Fine" style="background-color:#dff52f" disabled/></span>

				<br/>
				<br/>
				<span class="testo"><label for="Note">Note</label></span>
				<span class="campo"><textarea id="Note" name="Note" style="background-color:#dff52f" disabled></textarea></span>

			</div>
		</div>
		
		<br/>
		<br/>
		<br/>
		<input id="submit" type="submit" value="Modifica Attivita" name="submit" style="background-color:#dff52f" disabled/>
	</form>
	</div>

	<script src="praticare.js"></script>

</body>
</html>
