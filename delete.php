<?php
	if (file_exists('lektionen/' . $_GET['datei']))
		unlink('lektionen/' . $_GET['datei']);
	
	if (file_exists('lektionen/statistik/' . $_GET['datei']))
		unlink('lektionen/statistik/' . $_GET['datei']);

	if (!file_exists('lektionen/' . $_GET['datei']) && !file_exists('lektionen/statistik/' . $_GET['datei']))
		echo true;
	else
		echo false;
?>