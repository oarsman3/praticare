<?php

// costanti query mysqli

define('MYSQLI_STD_FROM',			'FROM ((((Anagrafica_Contatto LEFT JOIN Anagrafica_Referente ON Anagrafica_Contatto.ID_Contatto = ' .
									'Anagrafica_Referente.FK_contatto) LEFT JOIN Interessamenti ON Anagrafica_Referente.ID_Referente = ' .
									'Interessamenti.FK_Referente) LEFT JOIN Lista_Attivita_Interessamenti ON Interessamenti.FK_Attivita_Referente = ' .
									'Lista_Attivita_Interessamenti.ID_Interessamento) LEFT JOIN Bambini ON Anagrafica_Contatto.ID_Contatto = ' .
									'Bambini.FK_Contatto) LEFT JOIN (Lista_Attivita_Adesioni RIGHT JOIN Adesioni ON Lista_Attivita_Adesioni.ID_attivita ' .
									'= Adesioni.FK_Attivita) ON Bambini.ID_Bambino = Adesioni.FK_bambino ');
			
define('MYSQLI_ATTIVITA_COMPLETO',	'SELECT DISTINCT Lista_Attivita_Adesioni.Tipo, Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.Inizio, ' .
									'Lista_Attivita_Adesioni.Fine, Adesioni.Stato, Bambini.Cognome, Bambini.Nome, Anagrafica_Contatto.Tipologia, ' .
									'Anagrafica_Contatto.Identificativo, Anagrafica_Referente.Cognome_Ref, Anagrafica_Referente.Nome_Ref, ' .
									'Anagrafica_Referente.NR_TEL, Anagrafica_Referente.E_MAIL, Anagrafica_Referente.Note_Ref ');
			
define('MYSQLI_BAMBINI_COMPLETO',	'SELECT DISTINCT Bambini.Cognome, Bambini.Nome, Bambini.Data_di_nascita, Adesioni.Stato, Lista_Attivita_Adesioni.Tipo, ' .
									'Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.Inizio, Lista_Attivita_Adesioni.Fine, ' .
									'Anagrafica_Contatto.Tipologia, Anagrafica_Contatto.Identificativo, Anagrafica_Referente.Cognome_Ref, ' .
									'Anagrafica_Referente.Nome_Ref, Anagrafica_Referente.NR_TEL, Anagrafica_Referente.E_MAIL, Anagrafica_Referente.Note_Ref ');

define('MYSQLI_CONTATTI_COMPLETO',	'SELECT DISTINCT Anagrafica_Contatto.Tipologia, Anagrafica_Contatto.Identificativo, Anagrafica_Contatto.Data_primo_contatto, ' .
									'Anagrafica_Contatto.Cliente, Anagrafica_Contatto.Ultimo_contatto, Anagrafica_Referente.Cognome_Ref, ' .
									'Anagrafica_Referente.Nome_Ref, Lista_Attivita_Interessamenti.Nome_Attivita_Interessamento, Anagrafica_Referente.Note_Ref, ' .
									'Anagrafica_Referente.P_IVA, Anagrafica_Referente.NR_TEL, Anagrafica_Referente.E_MAIL, Anagrafica_Referente.Indirizzo, ' .
									'Anagrafica_Referente.CAP, Anagrafica_Referente.Comune, Bambini.Cognome, Bambini.Nome, Bambini.Data_di_nascita, ' .
									'Adesioni.Stato, Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.Tipo, Lista_Attivita_Adesioni.Inizio, ' .
									'Lista_Attivita_Adesioni.Fine ');

define('MYSQLI_REFERENTI_COMPLETO',	'SELECT DISTINCT Anagrafica_Referente.Cognome_Ref, Anagrafica_Referente.Nome_Ref, Anagrafica_Contatto.Tipologia, ' .
									'Anagrafica_Contatto.Identificativo, Interessamenti.Stato, Interessamenti.Num_Partecipanti, ' .
									'Lista_Attivita_Interessamenti.Nome_Attivita_Interessamento, Anagrafica_Referente.Note_Ref, ' .
									'Anagrafica_Referente.P_IVA, Anagrafica_Referente.NR_TEL, Anagrafica_Referente.E_MAIL, Anagrafica_Referente.Indirizzo, ' .
									'Anagrafica_Referente.CAP, Anagrafica_Referente.Comune, Bambini.Cognome, Bambini.Nome, Bambini.Data_di_nascita, ' .
									'Adesioni.Stato, Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.Tipo, Lista_Attivita_Adesioni.Inizio, ' .
									'Lista_Attivita_Adesioni.Fine ');

define('MYSQLI_FULL_DATA_COMPLETO',	'SELECT DISTINCT Anagrafica_Contatto.Tipologia, Anagrafica_Contatto.Identificativo, Anagrafica_Contatto.Data_primo_contatto, ' .
									'Anagrafica_Contatto.Cliente, Anagrafica_Contatto.Ultimo_contatto, Anagrafica_Referente.Cognome_Ref, ' .
									'Anagrafica_Referente.Nome_Ref, Lista_Attivita_Interessamenti.Nome_Attivita_Interessamento, Anagrafica_Referente.Note_Ref, ' .
									'Anagrafica_Referente.P_IVA, Anagrafica_Referente.NR_TEL, Anagrafica_Referente.E_MAIL, Anagrafica_Referente.Indirizzo, ' .
									'Anagrafica_Referente.CAP, Anagrafica_Referente.Comune, Bambini.Cognome, Bambini.Nome, Bambini.Data_di_nascita, ' .
									'Adesioni.Stato, Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.Tipo, Lista_Attivita_Adesioni.Inizio, ' .
									'Lista_Attivita_Adesioni.Fine ');
				
define('SELECT_FROM_INTERESSAMENTI_REFERENTI_COMPLETO',
									'SELECT DISTINCT Anagrafica_Contatto.Tipologia, Anagrafica_Contatto.Identificativo, Anagrafica_Referente.ID_Referente, ' .
									'Anagrafica_Referente.FK_contatto, Anagrafica_Referente.Nome_Ref, Anagrafica_Referente.Cognome_Ref, Anagrafica_Referente.P_IVA, ' .
									'Anagrafica_Referente.NR_TEL, Anagrafica_Referente.E_MAIL, Anagrafica_Referente.Indirizzo, Anagrafica_Referente.CAP, ' .
									'Anagrafica_Referente.Comune, Anagrafica_Referente.Note_Ref, Interessamenti.stato, Interessamenti.Note, Interessamenti.Num_Partecipanti, ' .
									'Lista_Attivita_Interessamenti.tipo, Lista_Attivita_Interessamenti.nome_attivita_interessamento, Lista_Attivita_Interessamenti.stato, ' .
									'Lista_Attivita_Interessamenti.Capacita, Lista_Attivita_Interessamenti.Inizio, Lista_Attivita_Interessamenti.Fine, ' .
									'Lista_Attivita_Interessamenti.Note ' .
									'FROM (Interessamenti INNER JOIN (Anagrafica_Contatto INNER JOIN Anagrafica_Referente ON Anagrafica_Contatto.ID_Contatto = ' .
									'Anagrafica_Referente.FK_contatto) ON Interessamenti.FK_Referente = Anagrafica_Referente.ID_Referente) INNER JOIN ' .
									'Lista_Attivita_Interessamenti ON Interessamenti.FK_Attivita_Referente = Lista_Attivita_Interessamenti.ID_Interessamento ');

define('SRC_COMPL_INTERESS_ID_TIPO_CONTATTO',					0);
define('SRC_COMPL_INTERESS_ID_CONTATTO',						1);
define('SRC_COMPL_INTERESS_ID_REFERENTE',						2);
define('SRC_COMPL_INTERESS_FK_CONTATTO',						3);
define('SRC_COMPL_INTERESS_NOME_REF',							4);
define('SRC_COMPL_INTERESS_COGNOME_REF',						5);
define('SRC_COMPL_INTERESS_P_IVA',								6);
define('SRC_COMPL_INTERESS_NR_TEL', 							7);
define('SRC_COMPL_INTERESS_E_MAIL',								8);
define('SRC_COMPL_INTERESS_INDIRIZZO', 							9);
define('SRC_COMPL_INTERESS_CAP', 								10);
define('SRC_COMPL_INTERESS_COMUNE', 							11);
define('SRC_COMPL_INTERESS_NOTE_REF',							12);
define('SRC_COMPL_INTERESS_STATO_INTERESSAMENTO', 				13);
define('SRC_COMPL_INTERESS_NOTE_INTERESSAMENTO', 				14);
define('SRC_COMPL_INTERESS_NUM_PARTECIPANTI', 					15);
define('SRC_COMPL_INTERESS_TIPO_INTERESSAMENTO',				16);
define('SRC_COMPL_INTERESS_NOME_INTERESSAMENTO',		 		17);
define('SRC_COMPL_INTERESS_STATO_ATTIVITA',						18);
define('SRC_COMPL_INTERESS_CAPACITA', 							19);
define('SRC_COMPL_INTERESS_INIZIO',								20);
define('SRC_COMPL_INTERESS_FINE',								21);
define('SRC_COMPL_INTERESS_NOTE_ATTIVITA',						22);

define('SELECT_FROM_ATTIVITA_BAMBINI_COMPLETO',
									'SELECT DISTINCT Anagrafica_Contatto.Tipologia, Anagrafica_Contatto.Identificativo, Bambini.ID_Bambino, Bambini.FK_contatto, Bambini.Nome, ' .
									'Bambini.Cognome, Bambini.Data_di_Nascita, Bambini.Note, Adesioni.stato, Adesioni.Note, Lista_Attivita_Adesioni.tipo, ' .
									'Lista_Attivita_Adesioni.Nome_Attivita, Lista_Attivita_Adesioni.stato, Lista_Attivita_Adesioni.Capacita, Lista_Attivita_Adesioni.Inizio, ' .
									'Lista_Attivita_Adesioni.Fine, Lista_Attivita_Adesioni.Note ' .
									'FROM (Adesioni INNER JOIN (Anagrafica_Contatto INNER JOIN Bambini ON Anagrafica_Contatto.ID_Contatto = Bambini.FK_contatto) ON ' .
									'Adesioni.FK_Bambino = Bambini.ID_Bambino) INNER JOIN Lista_Attivita_Adesioni ON Adesioni.FK_Attivita = Lista_Attivita_Adesioni.ID_Attivita ');
									
					
define('SRC_COMPL_ADESIONI_TIPO_CONTATTO',						0);
define('SRC_COMPL_ADESIONI_ID_CONTATTO',						1);
define('SRC_COMPL_ADESIONI_ID_BAMBINO',							2); 
define('SRC_COMPL_ADESIONI_FK_CONTATTO',						3);
define('SRC_COMPL_ADESIONI_NOME',								4);
define('SRC_COMPL_ADESIONI_COGNOME', 							5);
define('SRC_COMPL_ADESIONI_DATA_DI_NASCITA', 					6);
define('SRC_COMPL_ADESIONI_NOTE',								7);
define('SRC_COMPL_ADESIONI_STATO_ADESIONE', 					8);
define('SRC_COMPL_ADESIONI_NOTE_ADESIONE', 						9);
define('SRC_COMPL_ADESIONI_TIPO_ATTIVITA', 						10);
define('SRC_COMPL_ADESIONI_NOME_ATTIVITA', 						11);
define('SRC_COMPL_ADESIONI_STATO_ATTIVITA',						12);
define('SRC_COMPL_ADESIONI_CAPACITA', 							13);
define('SRC_COMPL_ADESIONI_INIZIO', 							14);
define('SRC_COMPL_ADESIONI_FINE', 								15);
define('SRC_COMPL_ADESIONI_NOTE_ATTIVITA',						16);	

define('TITOLI_ATTIVITA_COMPLETO',		'<th>Tipo Attivita\'</th><th>Attivita\'</th><th>Stato Attivita\'</th><th>Capacita\'</th><th>Inizio</th><th>Fine</th><th>Note Attivita\'</th>' .
										'<th>Tipo Contatto</th><th>Nome Contatto</th>' .
										'<th>Tipo Partecipante</th>' .
										'<th>Cognome</th><th>Nome</th><th>data di nascita</th><th>Note</th><th>Numero Partecipanti</th>' .
										'<th>stato adesione</th><th>note adesione</th>');														

define('LEN_ATTIVITA_COMPLETO',									17);

define('SELECT_CONTATTO_COMPLETO',	'SELECT DISTINCT Anagrafica_Contatto.ID_Contatto, Anagrafica_Contatto.Tipologia, Anagrafica_Contatto.Identificativo, ' .
									'Anagrafica_Contatto.Data_primo_contatto, Anagrafica_Contatto.Cliente, Anagrafica_Contatto.Ultimo_contatto, Anagrafica_Contatto.Note ');
									
define('TITOLI_CONTATTO_COMPLETO',	'<th>Tipo Contatto</th><th>Nome Contatto</th><th>primo contatto</th><th>Cliente</th><th>Ultimo contatto</th><th>Note Contatto</th>');

define('LEN_CONTATTO_COMPLETO',			6);

define('SRC_COMPL_CONTATTO_ID',			0);
define('SRC_COMPL_CONTATTO_TIPO',		1);
define('SRC_COMPL_CONTATTO_NOME',		2);
define('SRC_COMPL_CONTATTO_PRIMO',		3);
define('SRC_COMPL_CONTATTO_CLIENTE',	4);
define('SRC_COMPL_CONTATTO_ULTIMO',		5);
define('SRC_COMPL_CONTATTO_NOTE',		6);

define('FROM_ANAGRAFICA_CONTATTO',	'FROM Anagrafica_Contatto ');




define('SELECT_REFERENTE_COMPLETO',	'SELECT DISTINCT Anagrafica_Referente.ID_Referente, Anagrafica_Referente.FK_contatto, Anagrafica_Referente.Cognome_Ref, ' .
									'Anagrafica_Referente.Nome_Ref, Anagrafica_Referente.P_IVA, Anagrafica_Referente.NR_TEL, Anagrafica_Referente.E_MAIL, ' .
									'Anagrafica_Referente.Indirizzo, Anagrafica_Referente.CAP, Anagrafica_Referente.Comune, Anagrafica_Referente.Note_Ref, ' .
									'Interessamenti.stato, Interessamenti.Note, Interessamenti.Num_Partecipanti, Lista_Attivita_Interessamenti.tipo, ' .
									'Lista_Attivita_Interessamenti.Nome_Attivita_Interessamento ');

define('LEN_REFERENTE_COMPLETO',		14);

define('SRC_COMPL_REF_ID',				0);
define('SRC_COMPL_REF_FK_CONTATTO',		1);
define('SRC_COMPL_REF_COGNOME',			2);
define('SRC_COMPL_REF_NOME',			3);
define('SRC_COMPL_REF_P_IVA',			4);
define('SRC_COMPL_REF_N_TEL',			5);
define('SRC_COMPL_REF_E_MAIL',			6);
define('SRC_COMPL_REF_INDIRIZZO',		7);
define('SRC_COMPL_REF_CAP',				8);
define('SRC_COMPL_REF_COMUNE',			9);
define('SRC_COMPL_REF_NOTE',			10);
define('SRC_COMPL_REF_STATO_ADES',		11);
define('SRC_COMPL_REF_NOTE_ADES',		12);
define('SRC_COMPL_REF_NUM_PARTEC',		13);
define('SRC_COMPL_REF_TIPO_ATT',		14);
define('SRC_COMPL_REF_ATT',				15);
									
define('TITOLI_REFERENTE_COMPLETO',		'<th>Cognome Referente</th><th>Nome Referente</th><th>P.IVA-C.F.</th><th>N.Tel</th><th>eMail</th><th>indirizzo</th>' .
										'<th>CAP</th><th>Comune</th><th>Note Referente</th><th>Tipo Attivita\' Referente</th><th>Attivita\' Referente</th>' .
										'<th>Stato Adesione</th><th>Numero Partecipanti</th><th>Note Adesione</th>');									

//define('FROM_ANAGRAFICA_REFERENTE',	'FROM Anagrafica_Referente LEFT JOIN (Lista_Attivita_Interessamenti RIGHT JOIN Interessamenti ON ' .
//										'Lista_Attivita_Interessamenti.ID_Interessamento = Interessamenti.FK_Attivita_Referente) ON ' .
//										'Anagrafica_Referente.ID_Referente = Interessamenti.FK_Referente ');									

define('FROM_ANAGRAFICA_REFERENTE',		'FROM Lista_Attivita_Interessamenti RIGHT JOIN (Anagrafica_Referente LEFT JOIN Interessamenti ON Anagrafica_Referente.ID_Referente = Interessamenti.FK_Referente) ON ' .
										'Lista_Attivita_Interessamenti.ID_Interessamento = Interessamenti.FK_Attivita_Referente ');
									
define('SELECT_BAMBINO_COMPLETO',	'SELECT DISTINCT Bambini.ID_Bambino, Bambini.FK_Contatto, Bambini.Cognome, Bambini.Nome, Bambini.Data_di_nascita, ' .
									'Bambini.Note, Adesioni.stato, Adesioni.Note, Lista_Attivita_Adesioni.tipo, Lista_Attivita_Adesioni.nome_attivita, ' .
									'Lista_Attivita_Adesioni.stato  ');

define('TITOLI_BAMBINO_COMPLETO',		'<th>Cognome Bambino</th><th>Nome Bambino</th><th>data di nascita</th><th>Note Bambino</th>' .
										'<th>tipo attivita\' Bambino</th><th>attivita\' Bambino</th><th>stato adesione</th><th>note adesione</th>');									

define('LEN_BAMBINO_COMPLETO',			8);

define('SRC_COMPL_BAMB_ID',				0);
define('SRC_COMPL_BAMB_FK_CONTATTO',	1);
define('SRC_COMPL_BAMB_COGNOME',		2);
define('SRC_COMPL_BAMB_NOME',			3);
define('SRC_COMPL_BAMB_D_NASCITA',		4);
define('SRC_COMPL_BAMB_NOTE',			5);
define('SRC_COMPL_BAMB_STATO_ADES',		6);
define('SRC_COMPL_BAMB_NOTE_ADES',		7);
define('SRC_COMPL_BAMB_TIPO_ATT',		8);
define('SRC_COMPL_BAMB_ATT',			9);
define('SRC_COMPL_BAMB_STATO_ATT',		10);
									
define('FROM_BAMBINI',				'FROM Lista_Attivita_Adesioni RIGHT JOIN (Bambini LEFT JOIN Adesioni ON Bambini.ID_Bambino = Adesioni.FK_bambino) ON ' .
									'Lista_Attivita_Adesioni.ID_attivita = Adesioni.FK_attivita ');

// titoli tabelle

$titoli_csv = 				array ("Tipo Contatto","Nome Contatto","primo contatto","Cliente","Ultimo contatto","Note Contatto",
								   "Cognome Referente","Nome Referente","P.IVA-C.F.","N.Tel","eMail","indirizzo","CAP","Comune","Note Referente",
								   "Tipo Attivita' Referente","Attivita' Referente","Stato Adesione","Numero Partecipanti","Note Adesione",
								   "Cognome Bambino","Nome Bambino","data di nascita","Note Bambino","tipo attivita' Bambino","attivita' Bambino",
								   "stato adesione","note adesione");

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
												<th>Numero Prtecipanti</th>
												<th>Attivita</th>
												<th>Tipo</th>
												<th>Inizio attivita</th>
												<th>Fine attivita</th></tr>');

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

// costanti

define('TUTTI',	  '-------------');
define('STRNGSEP',		  ' - ');				// Unicode Consortium zero widht non-joiner: separa elementi delle stinghe, es. cognome e nome
define('BY_NAME',				1);
define('BY_CONTACT_ID',			2);
define('COMPLETO',				1);
define('SINTESI',				2);
define('COLC',			"#FF8000");
define('COLR',			"#2EFE2E");
define('COLB',			"#2E9AFE");

											
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

