<script>
	$(document).ready(function(){
		var clients = [
		<?php echo implode(', ', $d['clientsname']) ?>
		];
		$('#clientautocomplete').autocomplete({
			source : clients,
			appendTo : 'form.fullform',
			delay : 0
		});
		
	})

</script>
<div class="box s100">
	<h1>Détail de la réservation</h1>

	<?php if(isset($d['reservation'])) : ?>
	<?php $ncl = ($d['reservation']->getClient() !== null) ? $d['reservation']->getClient()->getId().' - '.$d['reservation']->getClient()->getPrenom().' '.$d['reservation']->getClient()->getNom() : 'Aucun client'?>
	<h3>Réservation <?php echo $d['reservation']->getId() ?></h3>
	<form class="fullform onchange" action="/admin/update_reservation/<?php echo $d['reservation']->getId() ?>" method="post">

		<label for="clientautocomplete">Client</label>
		<input type="text" name="client" placeholder="Client" id="clientautocomplete" value="<?php echo $ncl ?>">
		
		<label for="arrive">Date d'arrivé</label>
		<input id="arrive" type="date" name="arrive" value="<?php echo $d['reservation']->getDateDebut('Y-m-d') ?>">
		
		<label for="depart">Date de départ</label>
		<input id="depart" type="date" name="depart" value="<?php echo $d['reservation']->getDateFin('Y-m-d') ?>">
		
		<label for="type">Type de location</label>
		<select id="type" name="type">
			<?php foreach($d['types'] as $t) : ?>
			<?php $selected = ''; ?>
			<?php if(strtolower($t['nom']) == strtolower(Tool::getTypeById($d['reservation']->getTypeBien()))) $selected = 'selected'; ?>
			<option <?php echo $selected ?> value="<?php echo $t['id'] ?>"><?php echo $t['nom'] ?></option>
			<?php endforeach?>
		</select>

		<label for="nb">Nombre de personne</label>
		<input id="nb" type="text" name="nbp" value="<?php echo $d['reservation']->getNbPersonne() ?>">
	
		<input class="btn" type="submit" value="Sauvegarder" style="display: none">
	</form>
	<?php else : ?>
	<h3>Réservation introuvable</h3>
	<?php endif?>
</div>