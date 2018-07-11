<?php
	include 'definizioni.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare il futuro - Modifica Referente</title>

  <link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>

<script>
	
		window.onload=init;

		function init() {
			var Referente = document.getElementById("Referente");
			Referente.onchange=getContatto;
			var Contatto = document.getElementById("Contatto");
			Contatto.onchange=refreshRefData;
		}
		
		function getContatto(eventObj) {
		
			var httpRequest = createXMLHTTPinstance();			
			if (!httpRequest) {
    			alert('modifica_referente_main.php (getContatto) : Cannot create an XMLHTTP instance');
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
					
						getRefData(cognomeRef, nomeRef, jar[0].Identificativo);
												
				    }
					else {
						alert('modifica_referente_main.php (getContatto.js): There was a problem with the request.');
					}
			    }
			}
		}
		


		function getRefData(cognomeRef, nomeRef, Identificativo) {

			var httpRequest = createXMLHTTPinstance();			
			if (!httpRequest) {
    			alert('getRefData.php : Cannot create an XMLHTTP instance');
      			return false;
			}
			
			var param1=encodeURIComponent("DATI_REFERENTE");
			var param2=encodeURIComponent(cognomeRef);
			var param3=encodeURIComponent(nomeRef);
			var param4=encodeURIComponent(Identificativo);
			var params='TipoDato='+param1+'&KeyOne='+param2+'&KeyTwo='+param3+'&KeyThree='+param4;

			httpRequest.open('GET', 'recuperaDati.php?'+params, false);	// chiamata sincrona
   			httpRequest.send(params);

		    if (httpRequest.readyState === 4) {
				if (httpRequest.status === 200) {
					console.log(httpRequest.responseText);
					var jar=JSON.parse(httpRequest.responseText);
					var jap=jar[0];
					console.log("jap: ",jap);
					
					document.getElementById("allInputs").style.color = "blue";
					
					document.getElementById("P_IVA").value = jap.P_IVA;
					document.getElementById("P_IVA").disabled = false;
					document.getElementById("P_IVA").style.backgroundColor = "white";

					document.getElementById("NR_TEL").value = jap.NR_TEL;
					document.getElementById("NR_TEL").disabled = false;
					document.getElementById("NR_TEL").style.backgroundColor = "white";

					document.getElementById("E_MAIL").value = jap.E_MAIL;
					document.getElementById("E_MAIL").disabled = false;
					document.getElementById("E_MAIL").style.backgroundColor = "white";

					document.getElementById("Indirizzo").value = jap.Indirizzo;
					document.getElementById("Indirizzo").disabled = false;
					document.getElementById("Indirizzo").style.backgroundColor = "white";

					document.getElementById("CAP").value = jap.CAP;
					document.getElementById("CAP").disabled = false;
					document.getElementById("CAP").style.backgroundColor = "white";

					document.getElementById("Comune").value = jap.Comune;
					document.getElementById("Comune").disabled = false;
					document.getElementById("Comune").style.backgroundColor = "white";

					document.getElementById("Note_Ref").value = jap.Note_Ref;
					document.getElementById("Note_Ref").disabled = false;
					document.getElementById("Note_Ref").style.backgroundColor = "white";
					
					document.getElementById("Nome_Attivita").value = jap.lista_interessamenti[0].Nome_Attivita;
					document.getElementById("Nome_Attivita").disabled = false;
					document.getElementById("Nome_Attivita").style.backgroundColor = "white";

					document.getElementById("Num_Partecipanti").value = jap.lista_interessamenti[0].Num_Partecipanti;
					document.getElementById("Num_Partecipanti").disabled = false;
					document.getElementById("Num_Partecipanti").style.backgroundColor = "white";

					document.getElementById("Stato_Interessamento_Interessato").disabled = false;
					document.getElementById("Stato_Interessamento_Prenotato").disabled = false;
					document.getElementById("Stato_Interessamento_Confermato").disabled = false;
					switch (jap.lista_interessamenti[0].Stato_Interessamento) {
						case "interessato":
							document.getElementById("Stato_Interessamento_Interessato").checked = true;
						break;
						case "prenotato":
							document.getElementById("Stato_Interessamento_Prenotato").checked = true;
						break;
						case "confermato":
							document.getElementById("Stato_Interessamento_Confermato").checked = true;
						break;
					}

					document.getElementById("Note_Interessamento").value = jap.lista_interessamenti[0].Note_Interessamento;
					document.getElementById("Note_Interessamento").disabled = false;
					document.getElementById("Note_Interessamento").style.backgroundColor = "white";
					
					document.getElementById("submit").disabled = false;
					document.getElementById("submit").style.backgroundColor = "white";

				}
				else {
					alert('modifica_referente_main.php(getContatto.js): There was a problem with the request.');
				}
		    }
		}



		function refreshRefData(eventObj) {

			var httpRequest = createXMLHTTPinstance();			
			if (!httpRequest) {
    			alert('refreshRefData.php : Cannot create an XMLHTTP instance');
      			return false;
			}		

			var param1=encodeURIComponent("DATI_REFERENTE");
			var cognomeRef = Referente.value.slice(0,Referente.value.search(" - "));
			var nomeRef = Referente.value.slice(Referente.value.search(" - ")+3,Referente.value.length);
			var param2=encodeURIComponent(cognomeRef);
			var param3=encodeURIComponent(nomeRef);
			var param4=encodeURIComponent(Contatto.value);
			if (param2 != "-------------" && param3 != "-------------" && param4 != "-------------") {
				var params='TipoDato='+param1+'&KeyOne='+param2+'&KeyTwo='+param3+'&KeyThree='+param4;

				httpRequest.open('GET', 'recuperaDati.php?'+params, false);	// chiamata sincrona
    			httpRequest.send(params);

			    if (httpRequest.readyState === 4) {
					if (httpRequest.status === 200) {
						console.log(httpRequest.responseText);
						var jar=JSON.parse(httpRequest.responseText);
						var jap=jar[0];
						
						document.getElementById("P_IVA").value = jap.P_IVA;
						document.getElementById("NR_TEL").value = jap.NR_TEL;
						document.getElementById("E_MAIL").value = jap.E_MAIL;
						document.getElementById("Indirizzo").value = jap.Indirizzo;
						document.getElementById("CAP").value = jap.CAP;
						document.getElementById("Comune").value = jap.Comune;
						document.getElementById("Note_Ref").value = jap.Note_Ref;
						document.getElementById("Nome_Attivita").value = jap.lista_interessamenti[0].Nome_Attivita;
						document.getElementById("Num_Partecipanti").value = jap.lista_interessamenti[0].Num_Partecipanti;
						
						switch (jap.lista_interessamenti[0].Stato_Interessamento) {
							case "interessato":
								document.getElementById("Stato_Interessamento_Interessato").checked = true;
							break;
							case "prenotato":
								document.getElementById("Stato_Interessamento_Prenotato").checked = true;
							break;
							case "confermato":
								document.getElementById("Stato_Interessamento_Confermato").checked = true;
							break;
						}
						
						document.getElementById("Note_Interessamento").value = jap.lista_interessamenti[0].Note_Interessamento;

						document.getElementById("submit").disabled = false;

					}
					else {
						alert('modifica_referente_main.php(getContatto.js): There was a problem with the request.');
					}
			    }
			}
		}

</script>

	<?php
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
							or die('modifica_referente.html: Error connecting to MySQL server.');
	?>

	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Modifica Referente</h2>
	</div>
	
	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

	<div class="form">
	<form method="post" action="modifica_referente.php">

		MODIFICA REFERENTE
		<br />
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
				
			<div id="allInputs" style = "color:grey">			
				<br/>
				<br/>
				<br/>
				Dati Referente
				<br />
				<br />
				<span class="testo"><label for="P_IVA">C.F./P.IVA</label></span>
				<span class="campo"><input type="text" id="P_IVA" name="P_IVA" style="background-color:#dff52f" disabled/></span>
				<br/>
				<br/>
				<span class="testo"><label for="NR_TEL">Nr Tel</label></span>
				<span class="campo"><input type="text" id="NR_TEL" name="NR_TEL" style="background-color:#dff52f" disabled/></span>
				<br/>
				<br/>
				<span class="testo"><label for="E_MAIL">E-Mail</label></span>
				<span class="campo"><input type="email" id="E_MAIL" name="E_MAIL" style="background-color:#dff52f" disabled/></span>
				<br/>
				<br/>
				<span class="testo"><label for="Indirizzo">Indirizzo</label></span>
				<span class="campo"><input type="text" id="Indirizzo" name="Indirizzo" style="background-color:#dff52f" disabled/></span>
				<br/>
				<br/>
				<span class="testo"><label for="CAP">CAP</label></span>
				<span class="campo"><input type="text" id="CAP" name="CAP" style="background-color:#dff52f" disabled/></span>
				<br/>
				<br/>
				<span class="testo"><label for="Comune">Comune</label></span>
				<span class="campo"><input type="text" id="Comune" name="Comune" style="background-color:#dff52f" disabled/></span>
				<br/>
				<br/>
				<span class="testo"><label for="Note">Note</label></span>
				<span class="campo"><textarea id="Note_Ref" name="Note" style="background-color:#dff52f" disabled></textarea></span>
				<br/>
				<br/>
				<br/>

				<div id="tabellaSceltaAttivita">
					<div id="rowTxtAttNumStat">
						<div id="colNomeAtt">
							attivita'
						</div>
						<div id="colNumPart">
							partecipanti
						</div>
						<div id="colstat">
							int.	pren.	conf.
						</div>
					</div>
					<div id="rowValAttNumStat">
						<div id="colNomeAtt">
							<select id="Nome_Attivita" name="Nome_Attivita" style="background-color:#dff52f" maxlength="25" disabled/>
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
						</div>
						<div id="colNumPart">
							<input id="Num_Partecipanti" name="Num_Partecipanti" type="number" min="0" max="999" style="background-color:#dff52f" disabled/>
						</div>
						<div id="colStato">
							<input class="radio" id="Stato_Interessamento_Interessato" name="Stato_Interessamento" type="radio" value="interessato" disabled/>
							<input class="radio" id="Stato_Interessamento_Prenotato" name="Stato_Interessamento" type="radio" value="prenotato" disabled/>
							<input class="radio" id="Stato_Interessamento_Confermato" name="Stato_Interessamento" type="radio" value="confermato" disabled/>
						</div>
					</div>
				</div>
				
				<div id="tabellaNoteAttivita">
					<div id="rowNoteAtt">
						<div id="colTxtNoteAtt">
							note
						</div>
						<div id="colValNoteAtt">
							<textarea id="Note_Interessamento" name="Note_Interessamento" style="background-color:#dff52f" rows="1" cols="50" disabled></textarea>
						</div>
					</div>
				</div>
			
			</div>
			<?php
			mysqli_close($dbc);
			?>

			<br/>
			<br/>
			<br/>
			<input id="submit" type="submit" value="Modifica Referente" style="background-color:#dff52f" name="submit" disabled/>
		</form>
		</div>
	</div>
	
	</form>
	</div>
	
	<script src="praticare.js"></script>

</body>
</html>
