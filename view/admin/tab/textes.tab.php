<div class="box s100">
    <h2>Gestion des textes</h2>
	<ul class="linklist" >
		<?php foreach($d['textes'] as $t) : ?>
			<a href="/admin/textes/<?= $t['nom'] ?>">
				<li>
					<?= $t['nom'] ?>
				</li>
			</a>
		<?php endforeach ?>
	</ul>
</div>