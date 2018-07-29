<div class="box s100">
	
	<h1>Gallerie de photos</h1>

	<p>
		Glisser les photos dans l'encadré
	</p>

	<div title="Ajouter une nouvelle photo à la gallerie" id="newphoto">
		<p>
			<span>Nouvelle photo</span>
			<button class="abort">Annuler</button>
		</p>
		<div class="percentage"></div>
	</div>


	<div class="photos">
	<?php foreach($d['photos'] as $ph) : ?>

		<div>
			<a title="Supprimer la photo" href="/admin/deletephoto/<?php echo base64_encode($ph) ?>">
				<img class="zoomIn animated" src="/web/img/gallerie/miniature/<?php echo $ph ?>" alt="">
			</a>
		</div>

	<?php endforeach ?>
	</div>	

</div>