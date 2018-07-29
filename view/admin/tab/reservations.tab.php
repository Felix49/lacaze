<script>
	$(document).ready(function(){
		var clients = [
		<?php echo implode(', ', $d['clientsname']) ?>
		];
		$('#clientautocomplete').autocomplete({
			source : clients,
			appendTo : '#box-newclient form',
			delay : 0
		});

	})

</script>

<div class="box s75">
	<h1>Réservations</h1>
	<p class="info"><?php echo sizeof($d['resa']) ?> Réservations</p>
	<?php if(isset($d['reservations'])) : ?>
	<table class="table">

		<tr>
			<th>Nom</th>
			<th>Date d'arrivée</th>
			<th>Date de départ</th>
			<th>Nombre de personnes</th>
			<th>Type réservations</th>
		</tr>
		
		<?php foreach($d['reservations'] as $resa) : ?>

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
				<td><a title="Supprimer cette réservation" class="crudline" href="delreservation/<?php echo $resa->getId() ?>">X</a><a title="Modifier la réservation" class="crudline" href="detail_reservation/<?php echo $resa->getId() ?>">Editer</a></td>
			</tr>
		
		<?php endforeach ?>

	</table>
	<?php endif ?>

</div>

<div class="box s25" id="box-newclient">
	<h1>Nouvelle réservation</h1>
	
	<?php $d['form']['newreservation']->render() ?>
	
</div>