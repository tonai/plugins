<?php
	include('menu.php');
?>
			<div id="corps">
				<script type="text/javascript">
<!--

/* Merci � "RAD ZONE" pour son script : http://radservebeer.free.fr */

var P,T;
var over = -1;
var fontSize = 42;

function zoom(s)
{
	if(s!=over)
	{
		over = s;
		for(var i=0;i<T;i++)
		{
			if (Math.abs(i - s)<10)
				P[i].style.fontSize=Math.floor(fontSize / (0.3*Math.abs(i - s) + 1))+"px";
			else
				P[i].style.fontSize=Math.floor(fontSize / 4)+"px";
		}
	}
}

onload = function()
{
	P = document.getElementById("corps").getElementsByTagName("a");
	T = P.length;
	for (var i=0;i<T;i++)
	{
		P[i].style.width = "100%";
		P[i].onmouseover=new Function("zoom("+i+");");
	}
zoom(0);
}
//-->
				</script>
				<h1>Les morceaux joués</h1>
					<p class="center">
<?php
	$dossier=opendir("musique");
	$i=0;
	while ($file=readdir($dossier))
	{
		if ($i>=2)
		{
			$longueurChaine=strlen($file)-4;
			$extension=substr($file, $longueurChaine, 4);
			$nom=substr($file, 0, $longueurChaine);
			if ($extension==".mp3")
			{
				echo "\n\t\t\t\t\t<a href=\"morceaux.php?mp3=".$file."\">".$nom."</a><br/>";
			}
		}
		$i++;
	}
	echo "\n";
?>
				</p>
			</div>
		</div>
	</body>
</html>