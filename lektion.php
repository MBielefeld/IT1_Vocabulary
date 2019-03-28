<?php
	// Test Lektion uebergeben
	if (!isset($_GET['lektion']) || $_GET['lektion'] == "")
		header("Location: index.php");
?>

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
			var lektionen = [],
				statistik = [],
				antwortarray = [],
				antwort;
			
			// Vokabeldaten
			$.get('lektionen/<?php echo $_GET['lektion']; ?>', function(lektion) {
				lektionen = lektion.split("\n");
				
				$.each(lektionen, function(key) {
					lektionen[key] = lektionen[key].split(";");
				});
				
				// Statistikdaten
				$.get('lektionen/statistik/<?php echo $_GET['lektion']; ?>', function(stat) {
					statistik = stat.split(";");
					
					erzeugeQuizlet();
					anzeigen();
				});
			});
			
			// Pruefen Antwort korren
			$('#prufen').click(function() {
				var antwortBenutzer = $('input:checked').parent().attr('data-antwort'),
					stat;
				
				// Neutrale Farbe entfernen
				$('.frage-container').removeClass("frage-neutral");
				
				// Pruefen Antwort korrekt
				if (antwortBenutzer == antwort) {
					$('.frage-container').addClass("frage-richtig");
					statistik[1] = parseInt(statistik[1]) + 1;
				} else {
					$('.frage-container').addClass("frage-falsch");
					statistik[0] = parseInt(statistik[0]) + 1;
				}
				
				// Statistikstring erstellen
				stat = statistik[0] + ';' + statistik[1];
				
				//Statistik schreiben
				$.get('statistik_schreiben.php', { stat: stat, datei: '<?php echo $_GET['lektion']; ?>' });
				
				// Pruefbutton ausblenden, Weiterbutton einblenden
				$(this).addClass("hidden");
				$('#weiter').removeClass("hidden");
			});
			
			// Weiter
			$('#weiter').click(function() {
				$(this).addClass("hidden");
				$('#prufen').removeClass("hidden");
				
				$('.frage-container').removeClass("frage-richtig");
				$('.frage-container').removeClass("frage-falsch");
				$('.frage-container').addClass("frage-neutral");
				
				// Quiz neustarten
				erzeugeQuizlet();
				anzeigen();
			});
			
			$('#tauschen').click(function() {
				$.each(lektionen, function(key) {
					var old = lektionen[key][0];
					lektionen[key][0] = lektionen[key][1];
					lektionen[key][1] = old;
				});
				
				anzeigen();
			});
			
			// Zufallszahl erzeugen
			function random(max) {
				return Math.floor(Math.random() * (max - 1));
			};
			
			// Antworten und Antwort erzeugen
			function erzeugeQuizlet() {
				antwortarray = [];
				
				// Antowrtenarray fuellen
				do {
					var tmp = random(lektionen.length);					// Zufallsantwort erzeugen
					
					// Test Antwort bereits in Array
					if ($.inArray(tmp, antwortarray) == -1)
						antwortarray.push(tmp);							// Speichern Antwort in Antwortarray
				} while (antwortarray.length < 5);
				
				antwort = antwortarray[random(antwortarray.length)];	// richtige Antwort erzeugen
			};
			
			// Quiz anzeigen
			function anzeigen() {
				$('#frage').text(lektionen[antwort][0]);		// Frage anzeigen
				$('#frage').attr("data-antwort", antwort);		// Antwortattribut hinzufuegen
				
				$('.antwortliste').children().remove();			// alte Antworten entfernen
				
				// Anzeigen neuen Antworten
				$.each(antwortarray, function(key) {
					$('.antwortliste').append("<a href='#' class='list-group-item' data-antwort='" + antwortarray[key] + "'><input type='radio' name='optradio' class='pull-left radio' />" + lektionen[antwortarray[key]][1] + "</a>");
				});
			};
		});
		
		$(document).on("click", '.list-group-item', function() {
			$('.list-group-item').children('.radio').attr("checked", false);
			$(this).children('.radio').attr("checked", true);
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
		
		<!-- Start Anzeige Frage -->
		<div class="col-sm-10">
			<div class="well">
				<button id="tauschen" class="btn btn-primary btn-block">Tauschen</button>
			</div>
		</div>
		<!-- Ende Anzeige Frage -->
		
		<!-- Start Anzeige Frage -->
		<div class="col-sm-2 col-sm-offset-4">
			<div class="well text-center frage-container frage-neutral">
				<span id="frage"></span>
			</div>
		</div>
		<!-- Ende Anzeige Frage -->
    
		<!-- Start Anzeige Lektionen -->
		<div class="col-sm-10">
			<div class="well">
				<!-- Auflistung Antworten -->
				<ul class="list-group antwortliste">
				</ul>
				
				<br />
				
				<button id="prufen" class="btn btn-primary btn-block">Antwort prüfen</button>
				<button id="weiter" class="btn btn-primary btn-block hidden">Weiter</button>
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