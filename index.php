<!DOCTYPE html>
<html lang="de">
<head>
	<!-- Webseitentitel -->
	<title>Vokabeltrainer</title>
	
	<!-- Metaangaben Webseite -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Einbindung CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/styles.css">
	
	<!-- Einbindung JS -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body>

<!-- Start Navigavtionsmenue kleine Geraete -->
<nav class="navbar navbar-inverse visible-xs">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			<a class="navbar-brand" href="index.php">Vokabeltrainer</a>
		</div>
		
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li class="active"><a href="index.php">Startseite</a></li>
				<li><a href="admin.php">Admin</a></li>
				<li><a href="statistik.php">Statistik</a></li>
			</ul>
		</div>
	</div>
</nav>
<!-- Ende Navigavtionsmenue kleine Geraete -->

<!-- Start Lektionscontainer -->
<div class="container-fluid">
	<div class="row content">
		<!-- Start Navigationsmenue links -->
		<div class="col-sm-2 sidenav hidden-xs">
			<h2>Vokabeltrainer</h2>
			
			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="index.php">Startseite</a></li>
				<li><a href="admin.php">Admin</a></li>
				<li><a href="statistik.php">Statistik</a></li>
			</ul>
			
			<br />
		</div>
		<!-- Ende Navigationsmenue links -->
	
		<br />
    
		<!-- Start Anzeige Lektionen -->
		<div class="col-sm-10">
			<div class="well">
				<legend>Lektionen</legend>
			
				<!-- Auflicstung Lektionen -->
				<ul class="list-group">
					<?php
						// Holen der Lektionen
						$lektionen = scandir('lektionen/');
						
						// Keine Lektionen vorhanden -> Warnung
						if (count($lektionen) == 3)
								echo "<div class='alert alert-warning'>Es gibt derzeitig keine Lektionen zum Üben</div>";
						else
							// Iteration durch Dateien in Ordner
							foreach($lektionen as $lektion)
								// Nicht Anzeige von ., .. und statistik
								if ($lektion != ".." && $lektion != "." && $lektion != "statistik")
									echo "<a href='lektion.php?lektion=$lektion' class='list-group-item'>" . substr($lektion, 0, -4) . "</a>";	// Anzeige der Lektionen
					?>
				</ul>
			</div>
		</div>
		<!-- Ende Anzeige Lektionen -->
	</div>
</div>
<!-- Ende Lektionscontainer -->

<!-- Start Navigavtionsmenue unten -->
<footer>
	<div class="navbar navbar-fixed-bottom">
		<ul class="nav nav-pills footer-menu">
			<li class="active"><a href="index.php">Startseite</a></li>
			<li><a href="admin.php">Admin</a></li>
			<li><a href="statistik.php">Statistik</a></li>
		</ul>
	</div>
</footer>
<!-- Ende Navigavtionsmenue unten -->

</body>
</html>