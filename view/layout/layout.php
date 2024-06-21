<!DOCTYPE html>

<html lang="fr">

<head>
	<meta charset="utf-8">
	<title>Compta</title>

	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<header>
		<nav>
			<ul>
				<li><a href="./">Accueil</a></li>
				<li><a href="index.php?action=add">Ajouter</a></li>
				<li><a href="index.php?action=bdd">Base de données</a></li>
			</ul>
		</nav>
	</header>

	<?= $content; ?>
</body>

</html>
