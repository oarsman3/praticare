<?php

// costanti query mysqli

define('MYSQLI_STD_FROM','FROM ((((Anagrafica_Contatto LEFT JOIN Anagrafica_Referente ON Anagrafica_Contatto.ID_Contatto = ' .
						'Anagrafica_Referente.FK_contatto) LEFT JOIN Interessamenti ON Anagrafica_Referente.ID_Referente = ' .
						'Interessamenti.FK_Referente) LEFT JOIN Lista_Attivita_Interessamenti ON Interessamenti.FK_Attivita_Referente = ' .
						'Lista_Attivita_Interessamenti.ID_Interessamento) LEFT JOIN Bambini ON Anagrafica_Contatto.ID_Contatto = ' .
						'Bambini.FK_Contatto) LEFT JOIN (Lista_Attivita_Adesioni RIGHT JOIN Adesioni ON Lista_Attivita_Adesioni.ID_attivita ' .
						'= Adesioni.FK_Attivita) ON Bambini.ID_Bambino = Adesioni.FK_bambino ');
			
define('MYSQLI_ATTIVITA_COMPLETO',	'SELECT DISTINCT Lista_Attivita_Adesioni.Tipo, Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.Inizio, ' .
									'Lista_Attivita_Adesioni.Fine, Adesioni.Stato, Bambini.Cognome, Bambini.Nome, Anagrafica_Contatto.Tipologia, ' .
									'Anagrafica_Contatto.Identificativo, Anagrafica_Referente.Cognome_Ref, Anagrafica_Referente.Nome_Ref, ' .
									'Anagrafica_Referente.NR_TEL, Anagrafica_Referente.E_MAIL, Anagrafica_Referente.Note_Ref ');
			
define('MYSQLI_ATTIVITA_SINTESI',	'SELECT DISTINCT Lista_Attivita_Adesioni.Nome_Attivita, Bambini.Cognome, Bambini.Nome, Anagrafica_Contatto.Identificativo, ' .
									'Anagrafica_Referente.Cognome_Ref, Anagrafica_Referente.Note_Ref ');

define('MYSQLI_BAMBINI_COMPLETO',	'SELECT DISTINCT Bambini.Cognome, Bambini.Nome, Bambini.Data_di_nascita, Adesioni.Stato, Lista_Attivita_Adesioni.Tipo, ' .
									'Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.Inizio, Lista_Attivita_Adesioni.Fine, ' .
									'Anagrafica_Contatto.Tipologia, Anagrafica_Contatto.Identificativo, Anagrafica_Referente.Cognome_Ref, ' .
									'Anagrafica_Referente.Nome_Ref, Anagrafica_Referente.NR_TEL, Anagrafica_Referente.E_MAIL, Anagrafica_Referente.Note_Ref ');
									
define('MYSQLI_BAMBINI_SINTESI',	'SELECT DISTINCT Bambini.Cognome, Bambini.Nome, Adesioni.Stato, Lista_Attivita_Adesioni.Nome_Attivita, Anagrafica_Contatto.Tipologia, ' .
									'Anagrafica_Contatto.Identificativo ');


define('MYSQLI_CONTATTI_COMPLETO',	'SELECT DISTINCT Anagrafica_Contatto.Tipologia, Anagrafica_Contatto.Identificativo, Anagrafica_Contatto.Data_primo_contatto, ' .
									'Anagrafica_Contatto.Cliente, Anagrafica_Contatto.Ultimo_contatto, Anagrafica_Referente.Cognome_Ref, ' .
									'Anagrafica_Referente.Nome_Ref, Lista_Attivita_Interessamenti.Nome_Attivita_Interessamento, Anagrafica_Referente.Note_Ref, ' .
									'Anagrafica_Referente.P_IVA, Anagrafica_Referente.NR_TEL, Anagrafica_Referente.E_MAIL, Anagrafica_Referente.Indirizzo, ' .
									'Anagrafica_Referente.CAP, Anagrafica_Referente.Comune, Bambini.Cognome, Bambini.Nome, Bambini.Data_di_nascita, ' .
									'Adesioni.Stato, Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.Tipo, Lista_Attivita_Adesioni.Inizio, ' .
									'Lista_Attivita_Adesioni.Fine ');

define('MYSQLI_CONTATTI_SINTESI',	'SELECT DISTINCT Anagrafica_Contatto.Identificativo, Anagrafica_Contatto.Cliente, Anagrafica_Referente.Cognome_Ref, ' .
									'Anagrafica_Referente.Note_Ref, Bambini.Cognome, Bambini.Nome, Adesioni.Stato, Lista_Attivita_Adesioni.Nome_Attivita ');
									
define('MYSQLI_REFERENTI_COMPLETO',	'SELECT DISTINCT Anagrafica_Referente.Cognome_Ref, Anagrafica_Referente.Nome_Ref, Anagrafica_Contatto.Tipologia, ' .
									'Anagrafica_Contatto.Identificativo, Lista_Attivita_Interessamenti.Nome_Attivita_Interessamento, Anagrafica_Referente.Note_Ref, ' .
									'Anagrafica_Referente.P_IVA, Anagrafica_Referente.NR_TEL, Anagrafica_Referente.E_MAIL, Anagrafica_Referente.Indirizzo, ' .
									'Anagrafica_Referente.CAP, Anagrafica_Referente.Comune, Bambini.Cognome, Bambini.Nome, Bambini.Data_di_nascita, ' .
									'Adesioni.Stato, Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.Tipo, Lista_Attivita_Adesioni.Inizio, ' .
									'Lista_Attivita_Adesioni.Fine ');

define('MYSQLI_REFERENTI_SINTESI',	'SELECT DISTINCT Anagrafica_Referente.Cognome_Ref, Anagrafica_Referente.Nome_Ref, Lista_Attivita_Interessamenti.Nome_Attivita_Interessamento, ' .
									'Anagrafica_Referente.Note_Ref, Bambini.Cognome, Bambini.Nome, Adesioni.Stato, Lista_Attivita_Adesioni.Nome_Attivita ');

define('MYSQLI_FULL_DATA_COMPLETO',	'SELECT DISTINCT Anagrafica_Contatto.Tipologia, Anagrafica_Contatto.Identificativo, Anagrafica_Contatto.Data_primo_contatto, ' .
									'Anagrafica_Contatto.Cliente, Anagrafica_Contatto.Ultimo_contatto, Anagrafica_Referente.Cognome_Ref, ' .
									'Anagrafica_Referente.Nome_Ref, Lista_Attivita_Interessamenti.Nome_Attivita_Interessamento, Anagrafica_Referente.Note_Ref, ' .
									'Anagrafica_Referente.P_IVA, Anagrafica_Referente.NR_TEL, Anagrafica_Referente.E_MAIL, Anagrafica_Referente.Indirizzo, ' .
									'Anagrafica_Referente.CAP, Anagrafica_Referente.Comune, Bambini.Cognome, Bambini.Nome, Bambini.Data_di_nascita, ' .
									'Adesioni.Stato, Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.Tipo, Lista_Attivita_Adesioni.Inizio, ' .
									'Lista_Attivita_Adesioni.Fine ');

// titoli tabelle

define('TITOLI_TABELLA_ATTIVITA_COMPLETO','	<tr><th>Tipo</th>
												<th>Attivita</th>
												<th>Inizio attivita</th>
												<th>Fine attivita</th>
												<th>Stato</th>
												<th>Cognome Bambino</th>
												<th>Nome Bambino</th>
											    <th>Tipo Contatto</th>
												<th>Contatto</th>
												<th>Cognome referente</th>
												<th>Nome referente</th>
												<th>N.TEL</th>
												<th>E_MAIL</th>
												<th>Note</th></tr>');

define('TITOLI_TABELLA_ATTIVITA_SINTESI','	<tr><th>Attivita</th>
												<th>Cognome Bambino</th>
												<th>Nome Bambino</th>
												<th>Contatto</th>
												<th>Cognome referente</th>
												<th>Note</th></tr>');

define('TITOLI_STATO_ATTIVITA','			<tr><th>Attivita</th>
												<th>Tipo</th>
												<th>Stato</th>
												<th>Inizio attivita</th>
												<th>Fine attivita</th>
												<th>Capacita\'</th>
												<th>bamb prenotati</th>
												<th>bamb confermati</th>
												<th>ref interessati</th>
												<th>ref prenotati</th>
												<th>ref confermati</th>
												<th>Note</th></tr>');

define('TITOLI_TABELLA_BAMBINI_COMPLETO','	<tr><th>Cognome Bambino</th>
												<th>Nome Bambino</th>
												<th>Data di nascita</th>
												<th>Stato</th>
												<th>Tipo</th>
												<th>Attivita</th>
												<th>Inizio attivita</th>
												<th>Fine attivita</th>
												<th>Tipo Contatto</th>
												<th>Contatto</th>
												<th>Cognome referente</th>
												<th>Nome referente</th>
												<th>N.TEL</th>
												<th>E_MAIL</th>
												<th>Note</th>
												<th>Indirizzo</th></tr>');
	
define('TITOLI_TABELLA_BAMBINI_SINTESI','	<tr><th>Cognome Bambino</th>
												<th>Nome Bambino</th>
												<th>Stato</th>
												<th>Attivita</th>
												<th>Tipo Contatto</th>
												<th>Contatto</th></tr>');

define('TITOLI_TABELLA_CONTATTI_COMPLETO','	<tr><th>Tipo Contatto</th>
												<th>Contatto</th>
												<th>Data primocontatto</th>
												<th>Cliente</th>
												<th>Ultimo contatto</th>
												<th>Cognome referente</th>
												<th>Nome referente</th>
												<th>Interessato a</th>
												<th>Note</th>
												<th>P.IVA</th>
												<th>N.TEL</th>
												<th>E_MAIL</th>
												<th>Indirizzo</th>
												<th>CAP</th>
												<th>Comune</th>
												<th>Cognome Bambino</th>
												<th>Nome Bambino</th>
												<th>Data di nascita</th>
												<th>Stato</th>
												<th>Attivita</th>
												<th>Tipo</th>
												<th>Inizio attivita</th>
												<th>Fine attivita</th></tr>');
	
define('TITOLI_TABELLA_CONTATTI_SINTESI','	<tr><th>Contatto</th>
												<th>Cliente</th>
												<th>Cognome referente</th>
												<th>Note</th>
												<th>Cognome Bambino</th>
												<th>Nome Bambino</th>
												<th>Stato</th>
												<th>Attivita</th></tr>');
												
define('TITOLI_TABELLA_REFERENTI_COMPLETO','<tr><th>Cognome referente</th>
												<th>Nome referente</th>
												<th>Tipo Contatto</th>
												<th>Contatto</th>
												<th>Interessato a</th>
												<th>Note</th>
												<th>P.IVA</th>
												<th>N.TEL</th>
												<th>E_MAIL</th>
												<th>Indirizzo</th>
												<th>CAP</th>
												<th>Comune</th>
												<th>Cognome Bambino</th>
												<th>Nome Bambino</th>
												<th>Data di nascita</th>
												<th>Stato</th>
												<th>Attivita</th>
												<th>Tipo</th>
												<th>Inizio attivita</th>
												<th>Fine attivita</th></tr>');

define('TITOLI_TABELLA_REFERENTI_SINTESI','<tr><th>Cognome referente</th>
												<th>Nome referente</th>
												<th>Interessato a</th>
												<th>Note</th>
												<th>Cognome Bambino</th>
												<th>Nome Bambino</th>
												<th>Stato</th>
												<th>Attivita</th></tr>');

define('TITOLI_TABELLA_FULL_DATA_COMPLETO','<tr><th>Tipo Contatto</th>
											<th>Contatto</th>
											<th>Data primocontatto</th>
											<th>Cliente</th>
											<th>Ultimo contatto</th>
											<th>Cognome referente</th>
											<th>Nome referente</th>
											<th>Interessato a</th>
											<th>Note</th>
											<th>P.IVA</th>
											<th>N.TEL</th>
											<th>E_MAIL</th>
											<th>Indirizzo</th>
											<th>CAP</th>
											<th>Comune</th>
											<th>Cognome Bambino</th>
											<th>Nome Bambino</th>
											<th>Data di nascita</th>
											<th>Stato</th>
											<th>Attivita</th>
											<th>Tipo</th>
											<th>Inizio attivita</th>
											<th>Fine attivita</th></tr>');


											
// Mappatura campi risultanti dalla query "visualizza attivita" => tabella html 
// +-----+--------------------------+-----+
// | SRC | CAMPO                    | DST |
// +-----+--------------------------+-----+
// |  0  | nome attivita'           |  0  |
// +-----+--------------------------+-----+
// |  1  | tipo                     |  1  |
// +-----+--------------------------+-----+
// |  2  | inizio                   |  3  |
// +-----+--------------------------+-----+
// |  3  | fine                     |  4  |
// +-----+--------------------------+-----+
// |  4  | capacita'                |  5  |
// +-----+--------------------------+-----+
// |  5  | stato adesioni/interes   | n.a.|
// +-----+--------------------------+-----+
// |  6  | cont stato (bmb prenot)  |  6  |
// +-----+--------------------------+-----+
// |  6  | cont stato (bmb conf)    |  7  |
// +-----+--------------------------+-----+
// |  6  | cont stato (ref interes) |  8  |
// +-----+--------------------------+-----+
// |  6  | cont stato (ref prenot)	|  9  |
// +-----+--------------------------+-----+
// |  6  | cont stato (ref conferm) |  10 |
// +-----+--------------------------+-----+
// |  7  | stato attivita           |  2  |
// +-----+--------------------------+-----+
// |  8  | note                     |  11 |
// +-----+--------------------------+-----+

// offset campi tabella risultato query sql
define('SRC_OFFSET_NOME_ATTIVITA', 			0);
define('SRC_OFFSET_TIPO', 					1);
define('SRC_OFFSET_INIZIO', 				2);
define('SRC_OFFSET_FINE', 					3);
define('SRC_OFFSET_CAPACITA', 				4);
define('SRC_OFFSET_STATO_ADESIONI', 		5);
define('SRC_OFFSET_COUNT',					6);
define('SRC_OFFSET_STATO_ATTIVITA', 		7);
define('SRC_OFFSET_NOTE', 					8);

// offset campi tabella da stampare
define('DST_OFFSET_NOME_ATTIVITA', 			0);
define('DST_OFFSET_TIPO', 					1);
define('DST_OFFSET_STATO_ATTIVITA',			2);
define('DST_OFFSET_INIZIO', 				3);
define('DST_OFFSET_FINE', 					4);
define('DST_OFFSET_CAPACITA', 				5);
//define('DST_OFFSET_STATO', 				 );  n.a.
define('DST_OFFSET_BAMBINI_PRENOTATI', 		6);
define('DST_OFFSET_BAMBINI_CONFERMATI', 	7);
define('DST_OFFSET_REFERENTI_INTERESSATI', 	8);
define('DST_OFFSET_REFERENTI_PRENOTATI', 	9);
define('DST_OFFSET_REFERENTI_CONFERMATI', 	10);
define('DST_OFFSET_NOTE', 					11);
			
			
// costanti connessione DB

define('MYSQLI_HOST','62.149.150.207');
define('MYSQLI_ACCNT','Sql732257');
define('MYSQLI_PSSWD','223mqw8tj7');
define('MYSQLI_DB','Sql732257_1');

?>

