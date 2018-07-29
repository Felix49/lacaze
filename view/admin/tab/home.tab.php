<script>
	$(document).ready(function(){
		var clients = [
		<?php echo implode(', ', $d['clientsname']) ?>
		];
		$('#clientautocomplete').autocomplete({
			source : clients,
			appendTo : 'form#newres #lineauto',
			delay : 0
		});
		
	})

</script>
<div class="box s100">
	<h1>Dernières réservations</h1>
		<?php if(isset($d['few_reservations'])) : ?>
		<table class="table">

			<tr>
				<th>Nom</th>
				<th>Date d'arrivée</th>
				<th>Date de départ</th>
				<th>Nombre de personnes</th>
				<th>Type réservations</th>
			</tr>
			
			<?php foreach($d['few_reservations'] as $resa) : ?>

				<?php if(!$resa->getClient()){
					$cl = 'AUCUN CLIENT' ;
				}else{
					$cl = '<a title="Détails client" class="aline" href="/admin/detail_client/'.$resa->getClient()->getId().'">'.$resa->getClient()->getPrenom().' '.$resa->getClient()->getNom().'</a>';
				} ?>

				<tr>
					<td><?php echo $cl ?></td>
					<td><?php echo $resa->getDateDebut('Y-m-d') ?></td>
					<td><?php echo $resa->getDateFin('Y-m-d') ?></td>
					<td><?php echo $resa->getNbPersonne() ?></td>
					<td><?php echo $resa->getTypeBien() ?></td>
					<td><a title="Supprimer cette réservation" class="crudline confirm" href="admin/delreservation/<?php echo $resa->getId() ?>">X</a><a title="Modifier la réservation" class="confirm crudline" href="admin/detail_reservation/<?php echo $resa->getId() ?>">Editer</a></td>
				</tr>
			
			<?php endforeach ?>

		</table>
		<?php endif ?>
</div>

<div class="box s50">
	<h1>Nouvelle réservation</h1>
	<form id="newres" action="admin/addreservation" method="post">
		<div class="line" id="lineauto">
			<label for="clientautocomplete">Client</label>
			<input type="text" name="client" placeholder="Client" id="clientautocomplete">
		</div>
		<div class="line">
			<label for="dar">Arrivée</label>
			<input id="dar" type="date" name="arrive" placeholder="Arrivée">
		</div>
		<div class="line">
			<label for="dd">Départ</label>
			<input id="dd" type="date" name="depart" placeholder="Départ">
		</div>
		<div class="line">
			<label for="nbp">Nb personnes</label>
			<input type="number" name="nbp" placeholder="Nombre de personnes">
		</div>
		<div class="line">
			<label for="">Hébergement</label>
			<select name="typebien" id="">
				<?php foreach ($d['typebien'] as $type) : ?>
				
				<option value="<?php echo $type['id'] ?>"><?php echo $type['nom'] ?></option>

				<?php endforeach?>
			</select>
		</div>
		<?php if(isset($errors)) : ?>
			<ul class="errors">
			<?php foreach ($errors as $err) : ?>
				<li><?php echo $err ?></li>
			<?php endforeach ?>
			</ul>
		<?php endif ?>
		<input type="submit" class="btn" value="Créer">
	</form>
</div>

<div class="box s50">
	<h1>Créer un client</h1>
	<form action="admin/addclient" method="post">

		<div class="line">
			<label for="">Nom</label>
			<input type="text" name="nom" placeholder="Nom">
		</div>
		<div class="line">
			<label for="">Prénom</label>
			<input type="text" name="prenom" placeholder="Prénom">
		</div>
		<div class="line">
			<label for="">Adresse mail</label>
			<input type="text" name="mail" placeholder="Adresse mail">
		</div>
		<div class="line">
			<label for="">Téléphone</label>
			<input type="text" name="telephone" placeholder="Téléphone">
		</div>
		<div class="line">
			<label for="">Adresse postale</label>
			<input type="text" name="postale" placeholder="Adresse postale">
		</div>

		<?php if(isset($errors)) : ?>
			<ul class="errors">
			<?php foreach ($errors as $err) : ?>
				<li><?php echo $err ?></li>
			<?php endforeach ?>
			</ul>
		<?php endif ?>

		<input type="submit" class="btn" value="Créer">
	</form>
</div>
