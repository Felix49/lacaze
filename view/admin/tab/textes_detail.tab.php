<div class="box s100">
	<a class="back" href="/admin/textes">retour à la liste de textes</a>
	<h1>Texte : <?= $d['texte']['nom'] ?></h1>

	<form action="/admin/updatetextes/<?= $d['texte']['id'] ?>" method="post">
		<div id="trumbowyg">
			<?= $d['texte']['contenu'] ?>
		</div>
		<button class="btn">Enregistrer</button>
	</form>
</div>