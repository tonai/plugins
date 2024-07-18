<?php
	include ("admin/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head>
		<title>Plugin's</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="author" content="Tony CABAYE" />
		<meta name="description" content="Site de l'association musicale plugin's" />
		<meta name="keywords" content="musique, association, plugin's" />
		<meta name="reply-to" content="tonai59@hotmail.fr" />
		<link rel="stylesheet" media="screen" type="text/css" title="Style" href="css/style.css" />
		<script type="text/javascript" src="ajaxCalendrier.js"></script>
		<script language="javascript">
			function presentation()
			{
				var disp=document.getElementById("sousMenuPresentation").style.display;
				if (disp=='none')
					document.getElementById("sousMenuPresentation").style.display='block';
				else
					document.getElementById("sousMenuPresentation").style.display='none';
			}
			function programme()
			{
				var disp=document.getElementById("sousMenuProgramme").style.display;
				if (disp=='none')
					document.getElementById("sousMenuProgramme").style.display='block';
				else
					document.getElementById("sousMenuProgramme").style.display='none';
			}
			function galerie()
			{
				var disp=document.getElementById("sousMenuGalerie").style.display;
				if (disp=='none')
					document.getElementById("sousMenuGalerie").style.display='block';
				else
					document.getElementById("sousMenuGalerie").style.display='none';
			}
		</script>
	</head>
	<body>
		<div id="page">
			<p id="admin">
				<a href="admin.php">admin</a>
			</p>
			<div id="header">
			</div>
			<div id="menu">
				<ul>
					<li><a href="index.php" id="accueil"></a></li>
					<li>
						<a href="javascript:;" id="presentation" onClick="javascript:presentation();"></a>
						<ul id="sousMenuPresentation">
							<li style="display:none;"><a href="association.php">association</a></li>
							<li style="display:none;"><a href="membres.php">membres</a></li>
						</ul>
					</li>
					<li>
						<a href="javascript:;" id="programme" onClick="javascript:programme()"></a>
						<ul style="display:none;" id="sousMenuProgramme">
							<li><a href="concerts.php">concerts</a></li>
							<li><a href="morceaux.php">morceaux joués</a></li>
						</ul>
					</li>
					<li>
						<a href="javascript:;" id="galerie" onClick="javascript:galerie();"></a>
<?php
	if (isset($_GET['galerie']))
		echo '<ul id="sousMenuGalerie">';
	else
		echo '<ul style="display: none;" id="sousMenuGalerie">';
	$dossier=opendir('mediatheque');
	$i=0;
	while ($file=readdir($dossier))
	{
		if ($i>=2)
		{
			echo '<li><a href="galerie.php?galerie='.$file.'">'.$file.'</a></li>';
		}
		$i++;
	}
	echo '</ul>';
?>
					</li>
					<li><a href="calendrier.php" id="calendrier"></a></li>
					<li><a href="livredor.php" id="livredor"></a></li>
				</ul>
<?php
	if (isset($_GET['mp3']))
	{
		$mp3=$_GET['mp3'];
		echo '<object type="application/x-shockwave-flash" data="dewplayer-mini.swf?mp3=musique/'.$mp3.'&amp;autoplay=1&amp;bgcolor=336699" width="150" height="20"><param name="bgcolor" value="#000000"><param name="movie" value="dewplayer-mini.swf?mp3=musique/'.$mp3.'&amp;autoplay=1&amp;bgcolor=336699" /></object>';
		$longueurChaine=strlen($mp3)-4;
		$nom=substr($mp3, 0, $longueurChaine);
		echo '<p>';
		echo 'Vous écoutez actuellement :<br/>';
		echo '<strong>'.$nom.'</strong>';
		echo '</p>';
	}
	echo '</div>';
?>