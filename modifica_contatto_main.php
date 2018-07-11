<?php
	include 'definizioni.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>Praticare il futuro - Modifica Anagrafica Contatto</title>

	<link type="text/css" rel="stylesheet" href="praticare.php">
	
	<script>
	
		window.onload=init;

		function init() {
			var Identificativo = document.getElementById("Identificativo");
			Identificativo.onchange=getContatto;
		}
		
		function getContatto(eventObj) {

			var httpRequest = createXMLHTTPinstance();			
			if (!httpRequest) {
    			alert('Giving up :( Cannot create an XMLHTTP instance');
      			return false;
			}
			
			var param1=encodeURIComponent("CONTATTO");
			var param2=encodeURIComponent(Identificativo.value);
			var params='TipoDato='+param1+'&KeyOne='+param2;

			httpRequest.open('GET', 'recuperaDati.php?'+params, false);	// chiamata sincrona
    		httpRequest.send(params);

		    if (httpRequest.readyState === 4) {
				if (httpRequest.status === 200) {

					document.getElementById("nextinputs").style.color = "blue";

					console.log(httpRequest.responseText);
					var jar=JSON.parse(httpRequest.responseText);
					var jap=jar[0];
					console.log("jap: ",jap);

					document.getElementById("TipologiaScuola").disabled = false;
					document.getElementById("TipologiaFamiglia").disabled = false;
					document.getElementById("TipologiaAssociazione").disabled = false;
					
					document.getElementById("TipologiaScuola").checked = false;
					document.getElementById("TipologiaFamiglia").checked = false;
					document.getElementById("TipologiaAssociazione").checked = false;
					if (jap.Tipologia=="Scuola") {
						document.getElementById("TipologiaScuola").checked = true;
					}
					else if (jap.Tipologia=="Famiglia") {
						document.getElementById("TipologiaFamiglia").checked = true;
					} 
					else if (jap.Tipologia=="Associazione") {
						document.getElementById("TipologiaAssociazione").checked = true;
					}
					
					document.getElementById("Note").disabled = false;
					document.getElementById("Note").style.backgroundColor = "white";
					document.getElementById("Note").value = jap.Note;
					
					document.getElementById("Cliente").disabled = false;
					if (jap.Cliente==1) {
						document.getElementById("Cliente").checked = true;
					}
					else {
						document.getElementById("Cliente").checked = false;
					}
					
					document.getElementById("Data_ultimo_contatto").disabled = false;
					document.getElementById("Data_ultimo_contatto").style.backgroundColor = "white";
					document.getElementById("Data_ultimo_contatto").value = jap.Ultimo_contatto;

					document.getElementById("submit").disabled = false;
					document.getElementById("submit").style.backgroundColor = "white";

				}
				else {
					alert('modifica_contatto_main.php(getContatto.js): There was a problem with the request.');
				}
		    }
		}
		
	</script>

</head>

<body>

	<?php
	$dbc = mysqli_connect(MYSQLI_HOST, MYSQLI_ACCNT, MYSQLI_PSSWD, MYSQLI_DB)
								or die('modifica_contatto_main.php: Error connecting to MySQL server.');
	?>


	<div class="header">
		<h1>PRATICARE IL FUTURO</h1>
		<h2>Modifica Anagrafica Contatto</h2>
	</div>
	
	<div class="toolbar">
	
		<div class="firstoption"><a href = "gestione_anagrafiche.html">Torna a Gestione Anagrafiche</a></div>

		<div class="gotomain"><a href ="index.html">Torna alla pagina iniziale</a></div>
		
		<div class="end"><a href ="end.html">Esci</a></div>
		
	</div>

	<div class="form">
	<form method="post" action="modifica_contatto.php">

		MODIFICA ANAGRAFICA CONTATTO
		<br />
		<br />
		<br />
		Contatto da modificare
		<br />
		<br />
		<div class="form_indent">
			<span class="testo"><label for="Identificativo">Identificativo</label></span>
			<span class="campo">
				<select id="Identificativo" name="Identificativo" />
					<?php
					$query = "SELECT Anagrafica_Contatto.Identificativo FROM Anagrafica_Contatto ORDER BY Anagrafica_Contatto.Identificativo ";
					$result = mysqli_query($dbc, $query)
										or die('modifica_contatto_main.php: Error querying database - 2');
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
			
			<div id="nextinputs" style = "color:grey">
				<br />
				<br />
				Famiglia <input id="TipologiaFamiglia" name="Tipologia" type="radio" value="Famiglia" disabled/>
				Associazione <input id="TipologiaAssociazione" name="Tipologia" type="radio" value="Associazione" disabled/>
				Scuola <input id="TipologiaScuola" name="Tipologia" type="radio" value="Scuola" disabled/>
				<br/>
				<br/>
				Cliente<input id=Cliente name="Cliente" type="checkbox" disabled/>
				<br/>
				<br/>
				<span class="testo"><label for="Note">Note</label></span>
				<span class="campo"><textarea id="Note" name="Note" style="background-color:#dff52f" disabled></textarea></span>
				<br/>
				<br/>
				<span class="testo"><label for="Data_ultimo_contatto">Data ultimo contatto</label></span>
				<span class="campo"><input type="date" id="Data_ultimo_contatto" name="Data_ultimo_contatto" style="background-color:#dff52f" disabled/></span>
			</div>

			<?php
			mysqli_close($dbc);
			?>

			<br/>
			<br/>
			<br/>
			<br/>
			<input id="submit" type="submit" value="Modifica Anagrafica Contatto" name="submit" style="background-color:#dff52f" disabled/>
		</div>
	</form>
	</div>

	<script src="praticare.js"></script>

</body>
</html>
