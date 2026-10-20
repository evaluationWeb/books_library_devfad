<nav class="container-fluid">
	<ul>
		<li><strong>Books Library</strong></li>
	</ul>
	<ul>
		<li><a href="/">Accueil</a></li>
		<li><a href="/categories">Liste des catégories</a></li>
		<?php if (!isset($_SESSION["user"]["id"])) : ?>
			<li><a href="/register">Inscription</a></li>
			<li><a href="/login">Connexion</a></li>
		<?php else : ?>
			<li><a href="/category/new">Ajouter une catégorie</a></li>
			<li><a href="/logout"><?= htmlspecialchars($_SESSION["user"]["firstname"] . " connecté ",  ENT_QUOTES, 'UTF-8') ?></a></li>
		<?php endif ?>
	</ul>
</nav>
