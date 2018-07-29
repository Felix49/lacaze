<div class="box s75">
	<h1>Clients</h1>
	<p class="info"><?php echo $d['nb_clients'] ?> clients</p>
	<form class="search" action="/admin/search" method="post">
		<input type="hidden" name="type" value="client">
		<p><input type="text" placeholder="Rechercher" name="search"><button href="" class="searchmore" title="Recherche approfondie">+</button></p>
		<div class="clear"></div>
	</form>
	<table class="table">
		<tr>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Adresse mail</th>
			<th>Téléphone</th>
			<th>Adresse</th>
		</tr>

		<?php foreach ($d['clients'] as $cl) : ?>
		<tr>
			<td><?php echo $cl->getNom() ?></td>
			<td><?php echo $cl->getPrenom() ?></td>
			<td><?php echo $cl->getMail() ?></td>
			<td><?php echo $cl->getTelephone() ?></td>
			<td><?php echo $cl->getPostale() ?></td>
			<td><a title="Supprimer ce client" class="crudline confirm" href="delclient/<?php echo $cl->getId() ?>">X</a><a title="Modifier le client" class="crudline" href="detail_client/<?php echo $cl->getId() ?>">Editer</a></td>
		</tr>
		<?php endforeach ?>
	</table>
</div>
<div class="box s25">
	<h1>Créer un client</h1>

	<?php $d['form']['newclient']->render() ?>
	
</div>