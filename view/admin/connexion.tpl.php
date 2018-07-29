<?php $er = !empty($errors); ?>
<div class="connexion <?php echo ($er) ? 'animated shake' : ''; ?>">
	<h1>Enter the Caze</h1>
	<!-- 
	<div class="pic <?php echo ($er) ? 'animated shake' : ''; ?>">
		<img src="web/img/userpic/default.png" alt="">
	</div>
	 -->
	<form action="./admin" method="post">
		<p><input type="text" name="name" placeholder="Nom"></p>
		<p><input type="password" name="pw" placeholder="Mot de passe"></p>
		<input type="hidden" name="hid" value="connection">
		<p><button type="submit">Connexion</button></p>
	</form>

	<?php if($er) : ?>
		<div class="error">
			<?php foreach ($errors as $value) : ?>
				<p><?php echo $value ?></p>
			<?php endforeach ?>
		</div>
	<?php endif ?>
</div>