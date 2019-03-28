<?php
	if (!isset($_GET['stat']) || $_GET['stat'] == "" || !isset($_GET['datei']) || $_GET['datei'] == "")
		header("Location: index.php");
	
	file_put_contents('lektionen/statistik/' . $_GET['datei'], $_GET['stat']);
?>