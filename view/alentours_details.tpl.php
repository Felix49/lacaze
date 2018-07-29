<div class="content">
	<input type="hidden" value="<?= $d['le_spot']['latitude'] ?>" name="latitude"/>
	<input type="hidden" value="<?= $d['le_spot']['longitude'] ?>" name="longitude"/>
	<h1>Aux alentours</h1>
	<h3><?php echo $d['le_spot']['nom'] ?> - <i><?php echo $d['categories'][$d['le_spot']['id_categorie']] ?></i></h3>
	<div class="left">
		<img src="/web/img/spots/<?php echo $d['le_spot']['image'] ?>" alt="">
	</div>
	<div class="right description">
		<p><?php echo $d['le_spot']['description'] ?></p>
	</div>
	<div class="clear"></div>

	<?php if(!empty($d['le_spot']['latitude'])) : ?>
		<p class="infomap">
			À <span class="emp"><?= $d['le_spot']['km'] ?></span> km de la Caze, soit <span class="emp"><?= $d['le_spot']['minute'] ?></span> minutes.
		</p>
	<div id="map-canvas">
		<div id="mapalentours"></div>
	</div>
	<?php endif ?>

</div>

<script src="https://maps-api-ssl.google.com/maps/api/js"></script>
<script language="javascript" src="/web/js/mapalentours.js"></script>