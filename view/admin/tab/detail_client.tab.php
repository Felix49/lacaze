<div class="box s100">
	
	<h1>Détail du client</h1>

	<?php if($d['client'] !== null) : ?>

		<h3>ID Client : <?php echo $d['client']->getId() ?>, créé le <?php echo $d['client']->getDate_creation() ?></h3>

		<form class="fullform onchange" action="/admin/update_client/<?php echo $d['client']->getId() ?>" method="post">

			<label for="prenom">Prénom</label>
			<input id="prenom" type="text" name="prenom" value="<?php echo $d['client']->getPrenom() ?>">
			
			<label for="nom">Nom</label>
			<input id="nom" type="text" name="nom" value="<?php echo $d['client']->getNom() ?>">
			
			<label for="depart">Adresse mail</label>
			<input id="depart" type="text" name="mail" value="<?php echo $d['client']->getMail() ?>">
			
			<label for="postale">Adresse postale</label>
			<textarea name="postale" id="postale" cols="30" rows="10"><?php echo $d['client']->getPostale() ?></textarea>

			<label for="telephone">Téléphone</label>
			<input id="telephone" type="text" name="telephone" value="<?php echo $d['client']->getTelephone() ?>">

			<input class="btn" type="submit" value="Sauvegarder" style="display: none">
		</form>

	<?php else : ?>
		<h3>Client introuvable</h3>
	<?php endif ?>

</div>