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
			Referente.onchange = getContatto;
			var Contatto = document.getElementById("Contatto");
			Contatto.onchange = refreshRefData;
			var nuovaAttivita = document.getElementById("nuovaAttivita");
			nuovaAttivita.onclick = aggiungiAttivita;
		}
		
		
		
		
		function rinominaNodoClone(child,cnt) {
			if(child.nodeType==1){
				var ptr=child.id.search("_att_0");
				if(ptr>=0){
					child.id=child.id.replace("_att_0","_att_"+cnt);
					child.name=child.name.replace("_att_0","_att_"+cnt);
//					console.log("new child.id",child.id);
//					console.log(". . . new child.name",child.name);
				}
			}
			var nodes = child.childNodes;
			for(var i=0, lun=nodes.length; i<lun; i++){
				rinominaNodoClone(nodes[i],cnt);
			}
		}
		
		
		

		function aggiungiAttivita(eventObj) {
			var cnt = 1;
			while (document.getElementById("unaAttivita_att_"+cnt)) {
				cnt++;
			}
			var unaAtt = document.getElementById("unaAttivita_att_0");

			$sii=document.getElementById("Stato_Interessamento_Interessato_att_0").checked;			// backup dati att 0
			$sip=document.getElementById("Stato_Interessamento_Prenotato_att_0").checked;
			$sic=document.getElementById("Stato_Interessamento_Confermato_att_0").checked;
			
			var cloneAtt = unaAtt.cloneNode(true);
			cloneAtt.id="unaAttivita_att_"+cnt;
			document.getElementById("listaAttivita").appendChild(cloneAtt);

			document.getElementById("Stato_Interessamento_Interessato_att_0").checked=$sii;			// and restore dati, appendchild corrupts...
			document.getElementById("Stato_Interessamento_Prenotato_att_0").checked=$sip;
			document.getElementById("Stato_Interessamento_Confermato_att_0").checked=$sic;

			unaAtt=document.getElementById("unaAttivita_att_"+cnt);
			var nodes = unaAtt.childNodes;
			for(var i=0, lun=nodes.length; i<lun; i++){
				rinominaNodoClone(nodes[i],cnt);
			}
			document.getElementById("Nome_Attivita_att_"+cnt).value = "-------------";
			document.getElementById("Num_Partecipanti_att_"+cnt).value = 0;
			document.getElementById("Stato_Interessamento_Interessato_att_"+cnt).checked = true;
			document.getElementById("Note_Interessamento_att_"+cnt).value = "";
			document.getElementById("ID_Interessamenti_att_"+cnt).value = 0;						// nuova attivita'
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

				httpRequest.open('GET', 'recuperaDati.php?'+params, false);
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

			httpRequest.open('GET', 'recuperaDati.php?'+params, false);
   			httpRequest.send(params);

		    if (httpRequest.readyState === 4) {
				if (httpRequest.status === 200) {

					var listaAtt = document.getElementById("listaAttivita");					// cancella lista attivita' precedente
					var cntAtt = 1;
					while (document.getElementById("unaAttivita_att_"+cntAtt)) {
						var unaAtt=document.getElementById("unaAttivita_att_"+cntAtt);
						listaAtt.removeChild(unaAtt);
						cntAtt++;
					}
													
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
					
					document.getElementById("ID_Interessamenti_att_0").value = 0;			// variabile hidden, non e' necessario il disable

					document.getElementById("Nome_Attivita_att_0").value = "-------------";
					document.getElementById("Nome_Attivita_att_0").disabled = false;
					document.getElementById("Nome_Attivita_att_0").style.backgroundColor = "white";

					document.getElementById("Num_Partecipanti_att_0").value = 0;
					document.getElementById("Num_Partecipanti_att_0").disabled = false;
					document.getElementById("Num_Partecipanti_att_0").style.backgroundColor = "white";

					document.getElementById("Stato_Interessamento_Interessato_att_0").disabled = false;
					document.getElementById("Stato_Interessamento_Prenotato_att_0").disabled = false;
					document.getElementById("Stato_Interessamento_Confermato_att_0").disabled = false;

					document.getElementById("Note_Interessamento_att_0").value = "";
					document.getElementById("Note_Interessamento_att_0").disabled = false;
					document.getElementById("Note_Interessamento_att_0").style.backgroundColor = "white";

					var len=jap.lista_interessamenti.length;
					
					var pnt=1;
					while (pnt<len) {												// clona la prima attivita' per ogni interessamento
						var unaAtt = document.getElementById("unaAttivita_att_0");
						var cloneAtt = unaAtt.cloneNode(true);
						cloneAtt.id="unaAttivita_att_"+pnt;
						document.getElementById("listaAttivita").appendChild(cloneAtt);							
						var el=document.getElementById("unaAttivita_att_"+pnt);
						var nodes = el.childNodes;
						for(var i=0, lun=nodes.length; i<lun; i++){
							rinominaNodoClone(nodes[i],pnt);
						}								
						pnt++;
					}


					var pnt=0;
					while (pnt<len) {

						document.getElementById("ID_Interessamenti_att_"+pnt).value = jap.lista_interessamenti[pnt].ID_Interessamenti;
					
						document.getElementById("Nome_Attivita_att_"+pnt).value = jap.lista_interessamenti[pnt].Nome_Attivita;
						document.getElementById("Nome_Attivita_att_"+pnt).disabled = false;
						document.getElementById("Nome_Attivita_att_"+pnt).style.backgroundColor = "white";

						document.getElementById("Num_Partecipanti_att_"+pnt).value = jap.lista_interessamenti[pnt].Num_Partecipanti;
						document.getElementById("Num_Partecipanti_att_"+pnt).disabled = false;
						document.getElementById("Num_Partecipanti_att_"+pnt).style.backgroundColor = "white";

						document.getElementById("Stato_Interessamento_Interessato_att_"+pnt).disabled = false;
						document.getElementById("Stato_Interessamento_Prenotato_att_"+pnt).disabled = false;
						document.getElementById("Stato_Interessamento_Confermato_att_"+pnt).disabled = false;

						switch (jap.lista_interessamenti[pnt].Stato_Interessamento) {
							case "interessato":
								document.getElementById("Stato_Interessamento_Interessato_att_"+pnt).checked = true;
							break;
							case "prenotato":
								document.getElementById("Stato_Interessamento_Prenotato_att_"+pnt).checked = true;
							break;
							case "confermato":
								document.getElementById("Stato_Interessamento_Confermato_att_"+pnt).checked = true;
							break;
							default:
								document.getElementById("Stato_Interessamento_Interessato_att_"+pnt).checked = true;
							break;							
						}

						document.getElementById("Note_Interessamento_att_"+pnt).value = jap.lista_interessamenti[pnt].Note_Interessamento;
						document.getElementById("Note_Interessamento_att_"+pnt).disabled = false;
						document.getElementById("Note_Interessamento_att_"+pnt).style.backgroundColor = "white";

						pnt++;
					}
					
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

				httpRequest.open('GET', 'recuperaDati.php?'+params, false);
    			httpRequest.send(params);

			    if (httpRequest.readyState === 4) {
					if (httpRequest.status === 200) {

						var listaAtt = document.getElementById("listaAttivita");				// cancella lista attivita' precedente
						var cntAtt = 1;
						while (document.getElementById("unaAttivita_att_"+cntAtt)) {
							var unaAtt=document.getElementById("unaAttivita_att_"+cntAtt);
							listaAtt.removeChild(unaAtt);
							cntAtt++;
						}
													
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

						var pnt=1;
						var len=jap.lista_interessamenti.length;
						while (pnt<len) {												// clona la prima attivita' per ogni interessamento
							var unaAtt = document.getElementById("unaAttivita_att_0");
							var cloneAtt = unaAtt.cloneNode(true);
							cloneAtt.id="unaAttivita_att_"+pnt;
							document.getElementById("listaAttivita").appendChild(cloneAtt);							
							var el=document.getElementById("unaAttivita_att_"+pnt);
							var nodes = el.childNodes;
							for(var i=0, lun=nodes.length; i<lun; i++){
								rinominaNodoClone(nodes[i],pnt);
							}								
							pnt++;
						}

						var pnt=0;					
						while (pnt<len) {
											
							document.getElementById("ID_Interessamenti_att_"+pnt).value = jap.lista_interessamenti[pnt].ID_Interessamenti;
												
							document.getElementById("Nome_Attivita_att_"+pnt).value = jap.lista_interessamenti[pnt].Nome_Attivita;
							document.getElementById("Num_Partecipanti_att_"+pnt).value = jap.lista_interessamenti[pnt].Num_Partecipanti;
						
							switch (jap.lista_interessamenti[pnt].Stato_Interessamento) {
								case "interessato":
									document.getElementById("Stato_Interessamento_Interessato_att_"+pnt).checked = true;
								break;
								case "prenotato":
									document.getElementById("Stato_Interessamento_Prenotato_att_"+pnt).checked = true;
								break;
								case "confermato":
									document.getElementById("Stato_Interessamento_Confermato_att_"+pnt).checked = true;
								break;
								default:
									document.getElementById("Stato_Interessamento_Interessato_att_"+pnt).checked = true;
								break;							
							}
						
							document.getElementById("Note_Interessamento_att_"+pnt).value = jap.lista_interessamenti[pnt].Note_Interessamento;

							document.getElementById("submit").disabled = false;

							pnt++;

						}
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

				<div id="listaAttivita">
					<div id="unaAttivita_att_0">
					
						<input id="ID_Interessamenti_att_0" type="hidden" name="ID_Interessamenti_att_0" value=0 />		<!-- id interessamento, serve allo script per indirizzare la modifica -->
				
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
									<select id="Nome_Attivita_att_0" name="Nome_Attivita_att_0" style="background-color:#dff52f" maxlength="25" disabled/>
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
									<input id="Num_Partecipanti_att_0" name="Num_Partecipanti_att_0" type="number" min="0" max="999" style="background-color:#dff52f" disabled/>
								</div>
								<div id="colStato">
									<input id="Stato_Interessamento_Interessato_att_0" name="Stato_Interessamento_att_0" type="radio" value="interessato" disabled/>
									<input id="Stato_Interessamento_Prenotato_att_0" name="Stato_Interessamento_att_0" type="radio" value="prenotato" disabled/>
									<input id="Stato_Interessamento_Confermato_att_0" name="Stato_Interessamento_att_0" type="radio" value="confermato" disabled/>
								</div>
							</div>
						</div>
					
						<div id="tabellaNoteAttivita">
							<div id="rowNoteAtt">
								<div id="colTxtNoteAtt">
									note
								</div>
								<div id="colValNoteAtt">
									<textarea id="Note_Interessamento_att_0" name="Note_Interessamento_att_0" style="background-color:#dff52f" rows="1" cols="50" disabled></textarea>
								</div>
							</div>
						</div>

					</div>
				</div>

				<br>
				<br>
				<input id="nuovaAttivita" type="button" value="aggiungi attivita"/>
			
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
