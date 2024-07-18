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
		</head>
	<body>
		<div id="page">
<?php
	if (isset($_POST['pseudo']) && isset($_POST['MDP']))
	{
		$pseudo=md5($_POST['pseudo']);
		$mdp=md5($_POST['MDP']);
		if ($pseudo=="174570f23df70fdcf2c0957c356327c9" && $mdp=="37f0de6944176a3f7bad42c410a2a99c")
		{
			$jour=1;
			$mois=1;
			$an=date("Y");
			$annee=$an;
			$heure=0;
			$minute=0;
			if (isset($_POST['nom']))
			{
				$jour=$_POST['jour'];
				$mois=$_POST['mois'];
				$annee=$_POST['annee'];
				$heure=$_POST['heure'];
				$minute=$_POST['minute'];
				if($_POST['nom']!="")
				{
					mysql_connect($db['hostName'], $db['userName'], $db['password']);
					mysql_select_db($db['dataBase']);
					$nom=htmlentities($_POST['nom'], ENT_QUOTES);
					$date=$annee.'-'.$mois.'-'.$jour;
					$reponse=mysql_query("SELECT date FROM evenement");
					$i=0;
					while ($donnees=mysql_fetch_array($reponse))
					{
						$dateBase=explode('-',$donnees['date']);
						$anneeBase=$dateBase[0];
						$moisBase=$dateBase[1];
						$jourBase=$dateBase[2];
						if ($anneeBase==$annee && $moisBase==$mois && $jourBase==$jour)
							$i=1;
					}
					$description=htmlentities($_POST['description'], ENT_QUOTES);
					if (isset($_POST['horaire']))
					{
						$horaire=$_POST['horaire'];
						if ($horaire=="on")
							$passage="00:00:01";
					}
					else
						$passage=$heure.':'.$minute.':00';
					$lieu=htmlentities($_POST['lieu'], ENT_QUOTES);
					$adresse=htmlentities($_POST['adresse'], ENT_QUOTES);
					$lien=htmlentities($_POST['lien'], ENT_QUOTES);
					if ($i==0)
					{
						mysql_query("INSERT INTO evenement VALUES('', '$nom', '$date', '$description', '$passage', '$lieu', '$adresse', '$lien')");
						echo "Message enregistré";
					}
					mysql_close();
				}
			}
?>
			<p id="admin">
				<a href="index.php">deconnexion</a>
			</p>
			<div id="header">
			</div>
			<div id="corpsAdmin">
				<form method="post" action="admin.php">
					<fieldset>
						<legend>Ajouter un évènement</legend>
						<p>
							<input type="hidden" name="pseudo" value="tonai"/>
							<input type="hidden" name="MDP" value="chouchou"/>
						</p>
						<p>
							<label for="nom"><strong>nom (*) :
<?php
if(isset($_POST['nom']))
{
	if ($_POST['nom']=="")
		echo '<span class="erreur">Ce champ doit être renseigné</span>';
}
?>
							</strong></label><br/>
							<input type="text" name="nom" size="92" value="<?php	if(isset($_POST['nom']))	echo $_POST['nom'];	?>"/>
						</p>
						<p>
							<label for="description"><strong>description : </strong></label><br/>
							<textarea name="description" rows="3" cols="69"><?php	if(isset($_POST['description']))	echo $_POST['description'];	?></textarea>
						</p>
						<p>
							<strong>date (*) : </strong><?php if (isset($i)) {if ($i==1) echo '<span class="erreur">Un évènement éxiste déjà à cette date</span>';} ?><br/>
<?php
	echo "<label for=\"jour\">jour : </label>";
	echo "\n<select name=\"jour\">";
	for ($i=1;$i<=31;$i++)
	{
		if ($jour==$i)
			echo "\n\t<option selected=\"selected\" value=\"".$i."\">".$i."</option>";
		else
			echo "\n\t<option value=\"".$i."\">".$i."</option>";
	}
	echo "\n</select>";
	
	$tableauMois=array("janvier","février","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","décembre");
	echo "\n<label for=\"mois\"> mois : </label>";
	echo "\n<select name=\"mois\">";
	for ($i=1;$i<=12;$i++)
	{
		if ($mois==$i)
			echo "\n\t<option selected=\"selected\" value=\"".$i."\">".$tableauMois[$i-1]."</option>";
		else
			echo "\n\t<option value=\"".$i."\">".$tableauMois[$i-1]."</option>";
	}
	echo "\n</select>";
	
	echo "\n<label for=\"annee\"> annee : </label>";
	echo "\n<select name=\"annee\">";
	for ($i=0;$i<=2;$i++)
	{
		if ($annee==($an+$i))
			echo "\n\t<option selected=\"selected\" value=\"".($an+$i)."\">".($an+$i)."</option>";
		else
			echo "\n\t<option value=\"".($an+$i)."\">".($an+$i)."</option>";
	}
	echo "\n</select>\n"
?>
						</p>
						<p>
							<strong>horaire de passage (**) : </strong><br/>
<?php
	echo "<label for=\"heure\">heure : </label>";
	echo "\n<select name=\"heure\">";
	for ($i=0;$i<=23;$i++)
	{
		if ($heure==$i)
			echo "\n\t<option selected=\"selected\" value=\"".$i."\">".$i."</option>";
		else
			echo "\n\t<option value=\"".$i."\">".$i."</option>";
	}
	echo "\n</select>";
	
	echo "\n<label for=\"minute\"> minute : </label>";
	echo "\n<select name=\"minute\">";
	for ($i=0;$i<=59;$i++)
	{
		if ($minute==$i)
			echo "\n\t<option selected=\"selected\" value=\"".$i."\">".$i."</option>";
		else
			echo "\n\t<option value=\"".$i."\">".$i."</option>";
	}
	echo "\n</select>\n";
?>
							<input type="checkbox" name="horaire"/><label for="horaire">Ne pas renseigner l'horaire de passage</label>
						</p>
						<p>
							<label for="lieu"><strong>lieu : </strong></label><br/>
							<input type="text" name="lieu" size="92" value="<?php	if(isset($_POST['lieu']))	echo $_POST['lieu'];	?>"/>
						</p>
						<p>
							<label for="adresse"><strong>adresse : </strong></label><br/>
							<textarea name="adresse"  rows="3" cols="69"><?php	if(isset($_POST['adresse']))	echo $_POST['adresse'];	?></textarea>
						</p>
						<p>
							<label for="lien"><strong>lien : </strong></label><br/>
							<input type="text" name="lien" size="92" value="<?php	if(isset($_POST['lien']))	echo $_POST['lien'];	?>"/>
						</p>
						<p>
							<input type="submit">
							<input type="reset"/>
						</p>
						<p class="petit">
							Les champs suivis de (*) doivent obligatoirement être renseignés.<br/>
							/!\ En cas d'oubli, la date est automatiquement fixé par défault au 1er janvier de l'année en cours.<br/>
							Le champ suivi de (**) peut ne pas être renseigné en cochant la case "Ne pas renseigner l'horaire de passage".<br/>
							/!\ En cas d'oubli, l'heure de passage est automatiquement fixé par défault à 00H00.
						</p>
					</fieldset>
				</form>
			</div>
<?php
		}
		else
		{
?>
			<p id="admin">
			</p>
			<div id="header">
			</div>
			<div id="corpsAdmin">
<?php
			echo "\n\t\t\t\t<p class=\"erreur\">Mauvais identifiant et/ou mauvais mot de passe</p>\n";
?>
				<form method="post" action="admin.php">
					<p>
						<label for="pseudo">identifiant : </label><br/>
						<input type="text" name="pseudo" size="15"/>
					</p>
					<p>
						<label for="MDP">mot de passe : </label><br/>
						<input type="password" name="MDP" size="15"/>
					</p>
					<p>
						<input  type="submit">
					</p>
				</form>
				<p><a href="index.php">Retour à l'accueil</a></p>
			</div>
<?php
		}
	}
	else
	{
?>
			<p id="admin">
			</p>
			<div id="header">
			</div>
			<div id="corpsAdmin">
				<form method="post" action="admin.php">
					<p>
						<label for="pseudo">identifiant : </label><br/>
						<input type="text" name="pseudo" size="15"/>
					</p>
					<p>
						<label for="MDP">mot de passe : </label><br/>
						<input type="password" name="MDP" size="15"/>
					</p>
					<p>
						<input  type="submit">
					</p>
				</form>
				<p><a href="index.php">Retour à l'accueil</a></p>
			</div>
<?php
	}
?>
		</div>
	<body>
</html>