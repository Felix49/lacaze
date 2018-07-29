<div class="box s75">

	<h1>Contact</h1>
	<h3>Adresses mail enregistrées pour la newsletter</h3>

	<p class="info"><?php echo sizeof($d['contacts']) ?> adresses inscrites</p>
	<ul class="liste">
	<?php foreach($d['contacts'] as $ct) : ?>
		<li><?php echo $ct['mail'] ?></li>
	<?php endforeach ?>
	</ul>

</div>