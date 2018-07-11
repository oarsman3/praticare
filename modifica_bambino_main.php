<?php
	include 'definizioni.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare il futuro - Modifica bambino</title>

  <link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>

<script>
	
		window.onload=init;

		function init() {
			var Bambino = document.getElementById("Bambino");
			Bambino.onchange=getContatto;
			var Contatto = document.getElementById("Contatto");
			Contatto.onchange=refreshBambData;
		}
		
		function getContatto(eventObj) {
		
			var httpRequest = createXMLHTTPinstance();			
			if (!httpRequest) {
    			alert('modifica_bambino_main.php (getContatto) : Cannot create an XMLHTTP instance');
      			return false;
			}
			
			var Cognome = Bambino.value.slice(0,Bambino.value.search(" - "));
			var Nome = Bambino.value.slice(Bambino.value.search(" - ")+3,Bambino.value.length);

			var param1=encodeURIComponent("LISTA_CONTATTI_BAMBINO");
			var param2=encodeURIComponent(Cognome);
			var param3=encodeURIComponent(Nome);
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
					
						getBambData(Cognome, Nome, jar[0].Identificativo);
												
				    }
					else {
						alert('modifica_bambino_main.php (getContatto.js): There was a problem with the request.');
					}
			    }
			}
		}
		


		function getBambData(Cognome, Nome, Identificativo) {

			var httpRequest = createXMLHTTPinstance();			
			if (!httpRequest) {
    			alert('getBambData.php : Cannot create an XMLHTTP instance');
      			return false;
			}
			
			var param1=encodeURIComponent("DATI_BAMBINO");
			var param2=encodeURIComponent(Cognome);
			var param3=encodeURIComponent(Nome);
			var param4=encodeURIComponent(Identificativo);
			var params='TipoDato='+param1+'&KeyOne='+param2+'&KeyTwo='+param3+'&KeyThree='+param4;

			httpRequest.open('GET', 'recuperaDati.php?'+params, false);	// chiamata sincrona
   			httpRequest.send(params);

		    if (httpRequest.readyState === 4) {
				if (httpRequest.status === 200) {

					var jar=JSON.parse(httpRequest.responseText);
					var jap=jar[0];
					
					document.getElementById("allInputs").style.color = "blue";
					
					document.getElementById("Nome").value = jap.Nome;
					document.getElementById("Nome").disabled = false;
					document.getElementById("Nome").style.backgroundColor = "white";

					document.getElementById("Cognome").value = jap.Cognome;
					document.getElementById("Cognome").disabled = false;
					document.getElementById("Cognome").style.backgroundColor = "white";

					document.getElementById("Data_di_nascita").value = jap.Data_di_nascita;
					document.getElementById("Data_di_nascita").disabled = false;
					document.getElementById("Data_di_nascita").style.backgroundColor = "white";

					document.getElementById("Note").value = jap.Note;
					document.getElementById("Note").disabled = false;
					document.getElementById("Note").style.backgroundColor = "white";
					
					document.getElementById("Nome_Attivita").value = jap.Nome_Attivita;
					document.getElementById("Nome_Attivita").disabled = false;
					document.getElementById("Nome_Attivita").style.backgroundColor = "white";

					document.getElementById("Stato_Adesione_Interessato").disabled = false;
					document.getElementById("Stato_Adesione_Prenotato").disabled = false;
					document.getElementById("Stato_Adesione_Confermato").disabled = false;
					switch (jap.Stato_Adesione) {
						case "interessato":
							document.getElementById("Stato_Adesione_Interessato").checked = true;
						break;
						case "prenotato":
							document.getElementById("Stato_Adesione_Prenotato").checked = true;
						break;
						case "confermato":
							document.getElementById("Stato_Adesione_Confermato").checked = true;
						break;
					}

					document.getElementById("Note_Adesione").value = jap.Note_Adesione;
					document.getElementById("Note_Adesione").disabled = false;
					document.getElementById("Note_Adesione").style.backgroundColor = "white";
					
					document.getElementById("submit").disabled = false;
					document.getElementById("submit").style.backgroundColor = "white";

				}
				else {
					alert('modifica_bambino_main.php(getContatto.js): There was a problem with the request.');
				}
		    }
		}



		function refreshBambData(eventObj) {

			var httpRequest = createXMLHTTPinstance();			
			if (!httpRequest) {
    			alert('refreshBambData.php : Cannot create an XMLHTTP instance');
      			return false;
			}		

			var param1=encodeURIComponent("DATI_BAMBINO");
			var Cognome = Bambino.value.slice(0,Bambino.value.search(" - "));
			var Nome = Bambino.value.slice(Bambino.value.search(" - ")+3,Bambino.value.length);
			var param2=encodeURIComponent(Cognome);
			var param3=encodeURIComponent(Nome);
			var param4=encodeURIComponent(Contatto.value);
			if (param2 != "-------------" && param3 != "-------------" && param4 != "-------------") {
				var params='TipoDato='+param1+'&KeyOne='+param2+'&KeyTwo='+param3+'&KeyThree='+param4;

				httpRequest.open('GET', 'recuperaDati.php?'+params, false);	// chiamata sincrona
    			httpRequest.send(params);

			    if (httpRequest.readyState === 4) {
					if (httpRequest.status === 200) {

						var jar=JSON.parse(httpRequest.responseText);
						var jap=jar[0];
						
						document.getElementById("Nome").value = jap.Nome;
						document.getElementById("Cognome").value = jap.Cognome;
						document.getElementById("Data_di_nascita").value = jap.Data_di_nascita;
						document.getElementById("Note").value = jap.Note;
						document.getElementById("Nome_Attivita").value = jap.Nome_Attivita;
						
						switch (jap.Stato_Adesione) {
							case "interessato":
								document.getElementById("Stato_Adesione_Interessato").checked = true;
							break;
							case "prenotato":
								document.getElementById("Stato_Adesione_Prenotato").checked = true;
							break;
							case "confermato":
								document.getElementById("Stato_Adesione_Confermato").checked = true;
							break;
						}
						
						document.getElementById("Note_Adesione").value = jap.Note_Adesione;

						document.getElementById("submit").disabled = false;

					}
					else {
						alert('modifica_bambino_main.php(getContatto.js): There was a problem with the request.');
					}
			    }
			}
		}

</script>

	<?php
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
							or die('modifica_bambino.html: Error connecting to MySQL server.');
	?>

	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Modifica Bambino</h2>
	</div>
	
	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

	<div class="form">
	<form method="post" action="modifica_bambino.php">

		MODIFICA BAMBINO
		<br />
		<br />
		<br />
		<br />
		<div class="form_indent">
			<span class="testo"><label for="Bambino">Bambino</label></span>
			<span class="campo">			
				<select id="Bambino" name="Bambino" />
					<?php
					$result = mysqli_query($dbc,"SELECT DISTINCT Bambini.Cognome, Bambini.Nome FROM Bambini ORDER BY Bambini.Cognome ")
									or die('modifica_bambini_main.php: Error querying database - 1');
					?>
					<option " <?php echo '-------------'; ?> " ><?php echo '-------------'; ?></option>
					<?php
					while($row_list=mysqli_fetch_array($result,MYSQLI_BOTH)) {
					?>
						<option " <?php echo $row_list['Cognome']," ",$row_list['Nome']; ?> " ><?php echo $row_list['Cognome'],STRNGSEP,$row_list['Nome']; ?></option>
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
				
			<div id="allInputs" style = "color:grey">			
				<br/>
				<br/>
				<br/>
				Dati Bambino
				<br />
				<br />
				<span class="testo"><label for="Nome">Nome</label></span>
				<span class="campo"><input type="text" id="Nome" name="Nome" style="background-color:#dff52f" disabled/></span>
				<br/>
				<br/>
				<span class="testo"><label for="Cognome">Cognome</label></span>
				<span class="campo"><input type="text" id="Cognome" name="Cognome" style="background-color:#dff52f" disabled/></span>
				<br/>
				<br/>
				<span class="testo"><label for="Data_di_nascita">Data_di_nascita</label></span>
				<span class="campo"><input type="Data_di_nascita" id="Data_di_nascita" name="Data_di_nascita" style="background-color:#dff52f" disabled/></span>
				<br/>
				<br/>
				<span class="testo"><label for="Note">Note</label></span>
				<span class="campo"><textarea id="Note" name="Note" style="background-color:#dff52f" disabled></textarea></span>
				<br/>
				<br/>
				<br/>
				Attività a cui è interessato
				<br/>
				<br/>
				<span class="testo"><label for="Nome_Attivita">Nome Attività</label></span>
				<span class="campo">
					<select id="Nome_Attivita" name="Nome_Attivita" style="background-color:#dff52f" disabled/>
						<?php
						$result = mysqli_query($dbc, "SELECT Lista_Attivita_Adesioni.Nome_Attivita FROM Lista_Attivita_Adesioni ORDER BY Lista_Attivita_Adesioni.Nome_Attivita ")
											or die('modifica_referente_main.php: Error querying database - 2');
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
				<span class="testo"><label for="Stato">Stato</label></span>
				<span class="campo">
					<input id="Stato_Adesione_Interessato" name="Stato_Adesione" type="radio" value="interessato" disabled/>Interessato
					<input id="Stato_Adesione_Prenotato" name="Stato_Adesione" type="radio" value="prenotato" disabled/>Prenotato
					<input id="Stato_Adesione_Confermato" name="Stato_Adesione" type="radio" value="confermato" disabled/>Confermato
				</span>
				<br/>
				<br/>
				<span class="testo"><label for="Note_Adesione">Note Adesione</label></span>
				<span class="campo"><textarea id="Note_Adesione" name="Note_Adesione" style="background-color:#dff52f" disabled></textarea></span>

			<?php
			mysqli_close($dbc);
			?>

			<br/>
			<br/>
			<br/>
			<input id="submit" type="submit" value="Modifica Bambino" style="background-color:#dff52f" name="submit" disabled/>
		</form>
		</div>
	</div>
	
	</form>
	</div>
	
	<script src="praticare.js"></script>

</body>
</html>
