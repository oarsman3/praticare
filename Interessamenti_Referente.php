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
