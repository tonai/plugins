<?php
	include('menu.php');
?>
			<div id="corps" class="center">
				<h1>Livre d'or</h1>
<?php
	if (isset($_POST['nom']) and isset($_POST['message']))
	{
		if ($_POST['nom']!=null and $_POST['message']!=null)
		{
			$nom=htmlentities($_POST['nom'], ENT_QUOTES);
			$message=htmlentities($_POST['message'], ENT_QUOTES);
			mysql_connect($db['hostName'], $db['userName'], $db['password']);
			mysql_select_db($db['dataBase']);
			mysql_query("INSERT INTO livredor VALUES('', '$nom', '$message')");
			mysql_close();
		}
		elseif ($_POST['nom']==null)
		{
			echo '<p class="erreur">Il faut rentrer un nom!</p>';
		}
		elseif ($_POST['message']==null)
		{
			echo '<p class="erreur">Il faut écrire un message...</p>';
		}
	}
?>
				<form action="livredor.php" method="post" id="formulaire">
					<fieldset>
						<legend>Pour ajouter un message :</legend>
						<p><label for="nom" >Nom : </label><input type="text" name="nom" /></p>
						<p><label for="message" >Message : </label><br/>
						<textarea type="text" name="message" rows="5" cols="60" ></textarea></p>
						<p><input type="submit" value="envoyer" />	<input type="reset" value="effacer" /></p>
					</fieldset>
				</form>
				<div id="messagesLivreDOr">
<?php
	mysql_connect($db['hostName'], $db['userName'], $db['password']);
	mysql_select_db($db['dataBase']);
	$reponse=mysql_query("SELECT COUNT(*) AS nb_messages FROM livredor");
	$donnees=mysql_fetch_row($reponse);
	$messageParPage=10;
	if (!isset($_GET['page']))
	{
		$message=0;
		$pageActuelle=1;
	}
	else
	{
		$message=$messageParPage*($_GET['page']-1);
		$pageActuelle=$_GET['page'];
	}
	$pagesTotales=ceil(($donnees[0])/$messageParPage);
	$pages=$pagesTotales;
	echo '<p>';
	if ($pageActuelle!=1)
	{
		$pagePrec=$pageActuelle-1;
		echo "\n\t<a href=\"?page=".$pagePrec."\" title=\"page précédante\"><</a>&nbsp&nbsp;";
	}
	echo "\n\t<a href=\"?page=1\" title=\"première page\">1..</a>&nbsp&nbsp;";
	$i=2;
	if ($pageActuelle<=5)
	{
		$i=2;
		if ($pages>9)
			$pages=9;
	}
	elseif ($pageActuelle>=($pagesTotales-4) and $pageActuelle>5)
	{
		if ($pagesTotales>=6)
			$i=$pagesTotales-7;
	}
	else
	{
		$i=$pageActuelle-3;
		$pages=$pageActuelle+3;
	}
	for ($i;$i<$pages;$i++)
	{
		echo "\n\t<a href=\"?page=".$i."\">".$i."</a>&nbsp&nbsp;";
	}
	if ($pagesTotales!=1)
		echo "\n\t<a href=\"?page=".$pagesTotales."\" title=\"dernière page\">..".$pagesTotales."</a>&nbsp&nbsp;";
	if ($pageActuelle!=$pagesTotales)
	{
		$pageSuiv=$pageActuelle+1;
		echo "\n\t<a href=\"?page=".$pageSuiv."\" title=\"page suivante\">></a>";
		}
	echo "\n<p/>";
	$reponse=mysql_query('SELECT pseudo, message FROM livredor ORDER BY id DESC LIMIT '.$message.','.$messageParPage.' ');
	while($donnees=mysql_fetch_array($reponse))
	{
		echo "\n<dl>";
		echo "\n<dt><strong>".nl2br($donnees['pseudo'])." :</strong></dt>";
		echo "\n\t<dd>".nl2br($donnees['message'])."</dd>";
		echo "\n</dl>";
	}
	echo "\n<p>page ".$pageActuelle."</p>\n";
	mysql_close();
?>
				</div>
			</div>
		</div>
	</body>
</html>