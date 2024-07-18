<?php
	include('menu.php');
?>
			<div id="corps">
				<h1>Galerie photo</h1>	
<?php

if (isset($_GET['galerie']))
{
	echo "<h2>".$_GET['galerie']."</h2>";
	echo "\n<div id=\"mini\">";
	echo "\n\t<ul class=\"floatLeft\">";
	$lien="photos/".$_GET['galerie'];
	$dossier=opendir($lien);
	$nbPhotos=0;
	$i=0;
	$j=0;
	$cote=0;
	while ($file=readdir($dossier))
	{
		if ($i>=2)
		{
			$n=strlen($file)-10;
			$extension=substr($file, $n+1, 9);
			if ($extension=="petit.jpg")
			{
				$src[$nbPhotos]=$lien.'/'.$file;
				$dimension=getimagesize($src[$nbPhotos]);
				$largeur=$dimension[0];
				$hauteur=$dimension[1];
				if ($hauteur==100)
				{
					$liste[$cote]=$nbPhotos;
					$cote++;
				}
				$nbPhotos++;
			}
		}
		$i++;
	}
	if (!isset($liste))
		$liste=array(999);
	$j=0;
	$k=0;
	for ($i=0;$i<$nbPhotos;$i++)
	{
		if ($j==ceil(ceil($nbPhotos)/2))
		{
			echo "\n\t</ul>";
			echo "\n\t<ul class=\"floatLeft\">";
		}
		if ($i!=$liste[$k])
		{
			$n=strlen($src[$i])-10;
			$image=substr($src[$i],0,$n).'_maxi.jpg';
			echo "\n\t\t<li>";
			echo "<a href=\"javascript:;\" onClick=\"document.maxi.src='".$image."';\"><img style=\"margin-top:12px;\" src=\"".$src[$i]."\"/></a>";
			echo "</li>";
			$j++;
		}
		else
		{
			if ($k<($cote-1))
				$k++;
		}
	}
	for ($i=0;$i<$cote;$i++)
	{
		if ($j==ceil(ceil($nbPhotos)/2))
		{
			echo "\n\t</ul>";
			echo "\n\t<ul class=\"floatLeft\">";
		}
		$n=strlen($src[$liste[$i]])-10;
		$image=substr($src[$liste[$i]],0,$n).'_maxi.jpg';
		echo "\n\t\t<li>";
		echo "<a href=\"javascript:;\" onClick=\"document.maxi.src='".$image."';\"><img src=\"".$src[$liste[$i]]."\"/></a>";
		echo "</li>";
		$j++;
	}
	echo "\n\t</ul>";
	echo "\n</div>";
	echo "\n";
	closedir($dossier);
}
else
	echo "erreur de chargement de la page!"
?>
				<div id="maxi">
					<img name="maxi" src="<?php echo $image; ?>"/>
				</div>
			</div>
		</div>
	</body>
</html>