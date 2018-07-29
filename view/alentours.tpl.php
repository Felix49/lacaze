<div class="content">
	
	<h1>Aux alentours</h1>

	<p>Découvrez toutes les activités à faire dans la région. Balades, musées, baignades, points de vues et plus encore. N’hésitez pas à nous écrire si vous en connaissez qui n’apparaissent pas sur cette page.</p>

	<?php if(!empty($d['spots'])) : ?>

		<?php foreach($d['spots'] as $id => $cat) : ?>
			<h3><?php echo $d['categories'][$id] ?></h3>
			<?php foreach ($cat as $id => $spot) : ?>

			<a title="Voir le détail" class="spot-mini" href="/alentours/details/<?php echo $spot['id'] ?>">
				<img src="/web/img/spots/miniature/<?php echo $spot['image'] ?>" alt="">
				<div class="details">
					<p class="detail dnom"><?php echo $spot['nom'] ?></p>
					<p class="detail ddist"><?php echo $spot['km'] ?> KM - <?php echo $spot['minute'] ?> MIN</p>
				</div>
			</a>

			<?php endforeach ?>
			<div class="clear"></div>
		<?php endforeach ?>

	<?php endif ?>
	
</div>