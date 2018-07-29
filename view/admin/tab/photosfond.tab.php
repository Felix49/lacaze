<div class="box s100">
	
	<h1>Gallerie de photos de fond du site</h1>

	<p>
		Glisser les photos dans l'encadré
	</p>

	<div title="Ajouter une nouvelle photo à la gallerie" id="newphoto" categorie="2">
		<p>
			<span>Nouvelle photo de fond</span>
			<button class="abort">Annuler</button>
		</p>
		<div class="percentage"></div>
	</div>

	<div class="photos">
		<?php foreach($d['photos'] as $ph) : ?>

			<div>
				<a title="Supprimer la photo" href="/admin/deletephoto/<?= $ph['nom'] ?>">
					<img class="zoomIn animated" src="/web/img/gallerie/miniature/<?php echo $ph['nom'] ?>" alt="">
				</a>
			</div>

		<?php endforeach ?>
	</div>	

</div>