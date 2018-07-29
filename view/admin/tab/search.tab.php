<div class="box s100">
	
	<h1>Recherche</h1>

	<form class="search" action="/admin/search" method="post">
		<select name="type" id="">
			<option value="client">Client</option>
		</select>
		<p><input type="text" placeholder="Rechercher" name="search"><button href="" class="searchmore" title="Recherche approfondie">+</button></p>
		<div class="clear"></div>
	</form>

	<?php if(!empty($d['found'])) : ?>
	
		<h3><?php echo  sizeof($d['found']) ?> client(s) trouvé(s)</h3>
		<ul>
		<?php foreach ($d['found'] as $key => $value) : ?>
				<li><a class="aline" href="/admin/detail_client/<?php echo $value['id'] ?>"><?php echo $value['nom'].' '.$value['prenom'].' / '.$value['mail'].'' ?></a></li>
		<?php endforeach ?> 
		</ul>

	<?php else : ?>
		<p>Aucun résultat</p>
	<?php endif ?>

</div>