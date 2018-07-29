<div class="box s100">
	
	<h1>Aux alentours</h1>

	<h3>Catégories (<?= sizeof($d['spots']) ?>)</h3>
	
	Nouvelle catégorie
	<form class="oneline" action="/admin/add_alentourscategorie" method="post">
		<input type="text" name="nom" placeholder="Nom de la catégorie">
		<input type="submit" value="Créer">
		<div class="clear"></div>
	</form>

	<ul class="liste">
	<?php foreach ($d['categories'] as $id => $cat) : ?>
		<li><?php echo $cat ?><a class="crudline" title="Supprimer" href="/admin/del_alentourscategorie/<?php echo $id ?>">X</a></li>
	<?php endforeach ?>
	</ul>
	
	<h3>Tous les spots (<?= $d['nbspots'] ?>)</h3>
	<p>
		<a class="small" href="/admin/newalentours">Nouveau spot</a>
	</p>
	<?php foreach($d['spots'] as $id => $cat) : ?>
		<?php $cate = isset($d['categories'][$id]) ? $d['categories'][$id] : 'Sans catégorie' ?>
		<h4><?php echo $cate ?></h4>

		<ul class="liste">
		<?php foreach ($cat as $id => $spot) : ?>
			<li>
				<p>
					<a href="/admin/alentours_details/<?php echo $spot['id'] ?>"><?php echo $spot['nom'] ?></a>
					<a title="Supprimer" href="/admin/del_alentours/<?php echo $spot['id'] ?>" class="crudline">X</a>
				</p>
			</li>
		<?php endforeach ?>
		</ul>

		<div class="clear"></div>

	<?php endforeach ?>
</div>