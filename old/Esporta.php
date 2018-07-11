
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Praticare Il Futuro - Ricerche</title>
  
  <link type="text/css" rel="stylesheet" href="praticare.php">

</head>
<body>


		<h1>prova esportazione</h1>


** inizio php **
<?php
	echo "<div class=\"main\">";

	echo "inizio";
	$tbl_pnt=0;

	$tbl_len=count($table);
	echo"++++tbl_len++++=$tbl_len<br />";
	while ($tbl_pnt < $tbl_len) {
			$row_pnt=0;
			$row_len=count($table[$tbl_pnt]);
			if ($row_len>0) {
				while ($row_pnt<$row_len) {
					echo "$table[$tbl_pnt][$row_pnt]-";
					$row_pnt += 1;
				}
				$tbl_pnt += 1;
			}
			else {
				$tbl_pnt += 1;
			}
	}
	
	echo "</div>";
?>
** fine php **
</body>
</html>
