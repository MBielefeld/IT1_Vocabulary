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
	
	<script>
		$(document).ready(function() {
			// Ein- und Ausklappen der Statistikfelder
			$('.panel-heading').click(function() {
				$(this).next().toggle("collapse");
			});
		});
	</script>
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
				<li><a href="index.php">Startseite</a></li>
				<li><a href="admin.php">Admin</a></li>
				<li class="active"><a href="statistik.php">Statistik</a></li>
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
				<li><a href="index.php">Startseite</a></li>
				<li><a href="admin.php">Admin</a></li>
				<li class="active"><a href="statistik.php">Statistik</a></li>
			</ul>
			
			<br />
		</div>
		<!-- Ende Navigationsmenue links -->
	
		<br />
    
		<!-- Start Anzeige Statistik -->
		<div class="col-sm-10">
			<div class="well">
				<legend>Statistiken</legend>
			
				<!-- Auflistung Statistiken -->
				<?php
					// Holen der Statistiken
					$lektionen = scandir('lektionen/statistik');
					
					// Keine Statistiken vorhanden -> Warnung
					if (count($lektionen) == 2)
							echo "<div class='alert alert-warning'>Es gibt derzeitig keine Statistiken vorhanden</div>";
					else
						// Iteration durch Dateien in Ordner
						foreach($lektionen as $lektion)
							// Nicht Anzeige von . und ..
							if ($lektion != ".." && $lektion != ".") {
								// Holen der Statistikdateiinhalts
								$statinhalt = file_get_contents("lektionen/statistik/$lektion");
								$statinhalt = explode(";", $statinhalt);
								
								// formatierte Anzeige der Lektionen
								echo '<ul class="panel panel-primary">';
								echo "<div class='panel-heading'>" . substr($lektion, 0, -4) . "</div>";
								echo "<div class='panel-body collapse'>";
								echo "Absolviert: " . ($statinhalt[0] + $statinhalt[1]) . "<br />";
								echo "Richtig: " . $statinhalt[1] . "<br />";
								echo "Falsch: " . $statinhalt[0];
								echo "</div>";
								echo "</ul>";
							}
				?>
			</div>
		</div>
		<!-- Ende Anzeige Statistik -->
	</div>
</div>
<!-- Ende Lektionscontainer -->

<!-- Start Navigavtionsmenue unten -->
<footer>
	<div class="navbar navbar-fixed-bottom">
		<ul class="nav nav-pills footer-menu">
			<li><a href="index.php">Startseite</a></li>
			<li><a href="admin.php">Admin</a></li>
			<li class="active"><a href="statistik.php">Statistik</a></li>
		</ul>
	</div>
</footer>
<!-- Ende Navigavtionsmenue unten -->

</body>
</html>