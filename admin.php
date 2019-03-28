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
			$('.delete').click(function() {
				$.get('delete.php', { datei: $(this).parent('a').attr('data-datei') }, function(data) {
					if (data == 1)
						$('.meldung').addClass("alert alert-success").text("Lektion wurde erfolgreich gelöscht");
					else
						$('.meldung').addClass("alert alert-danger").text("Lektion konnt nicht gelöscht werden");
					
					setTimeout(function() {
						location.reload();
					}, 3000);
				});
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
				<li class="active"><a href="admin.php">Admin</a></li>
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
				<li><a href="index.php">Startseite</a></li>
				<li class="active"><a href="admin.php">Admin</a></li>
				<li><a href="statistik.php">Statistik</a></li>
			</ul>
			
			<br />
		</div>
		<!-- Ende Navigationsmenue links -->
	
		<br />
    
		<!-- Start Anzeige Lektionen -->
		<div class="col-sm-10">
			<div class="well">
				<legend>Neue Lektion</legend>
				
				<?php
					// Hochladen
					if (isset($_POST['submit'])) {
						// Test Datei txt Datei
						if (substr($_FILES['file']['name'], -3) == "txt") {
							$schlecht = array('ö', 'Ö', 'ä', 'Ä', 'ü', 'Ü', 'ß', ' ');
							$gut = array('oe', 'Oe', 'ae', 'Ae', 'ue', 'Ue', 'ss', '_');
							$dateiname = str_replace($schlecht, $gut, basename($_FILES['file']['name']));
							$upload_dir = "lektionen/$dateiname";
							
							// Test Datei erfolgreich hochgeladen
							if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir)) {
								file_put_contents("lektionen/statistik/$dateiname", "0;0");
								echo "<div class='alert alert-success'>Die Datei wurde erfolgreich hochgeladen</div>";
							} else {
								echo "<div class='alert alert-danger'>Die Datei konnte nicht hochgeladen werden</div>";
							}
						} else {
							echo "<div class='alert alert-danger'>Die hochzuladende Datei ist keine txt-Datei</div>";
						}
					}
				?>
				
				<!-- Upload-Formular -->
				<form action="" method="POST" enctype="multipart/form-data">
					<input type="file" name="file" class="form-control" accept="text/plain" />
					
					<br />
					
					<input type="submit" name="submit" class="form-control btn btn-primary" value="Hochladen" />
				</form>
			</div>
			<!-- Ende Anzeige Lektionen -->
			
			<!-- Start Anzeige Loeschlektionen -->
			<div class="well">
				<legend>Lektion löschen</legend>
				
				<div class="meldung"></div>
				
				<ul class="list-group">
					<?php
						// Holen der Statistiken
						$lektionen = scandir('lektionen');
						
						// Keine Statistiken vorhanden -> Warnung
						if (count($lektionen) == 3)
								echo "<div class='alert alert-warning'>Es gibt Lektionen zum Löschen</div>";
						else
							// Iteration durch Dateien in Ordner
							foreach($lektionen as $lektion)
								// Nicht Anzeige von . und ..
								if ($lektion != ".." && $lektion != "." && $lektion != 'statistik')
									// formatierte Anzeige der Lektionen
									echo "<div><a href='#' data-datei='$lektion' class='list-group-item delete-liste'>" . substr($lektion, 0, -4) . "<button class='btn btn-danger center-block pull-right delete'>Löschen</button></a></div>";
					?>
				</ul>
			</div>
			<!-- Ende Anzeige Loeschlektionen -->
			
		</div>
	</div>
</div>
<!-- Ende Lektionscontainer -->

<!-- Start Navigavtionsmenue unten -->
<footer>
	<div class="navbar navbar-fixed-bottom">
		<ul class="nav nav-pills footer-menu">
			<li><a href="index.php">Startseite</a></li>
			<li class="active"><a href="admin.php">Admin</a></li>
			<li><a href="statistik.php">Statistik</a></li>
		</ul>
	</div>
</footer>
<!-- Ende Navigavtionsmenue unten -->

</body>
</html>