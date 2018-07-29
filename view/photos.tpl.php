<div class="nested">
		<?php foreach ($d['photos'] as $ph) : ?>
			<div class="brick" style="background-image : url(/web/img/gallerie/miniature/<?= $ph['nom'] ?>)">
				<a title="Agrandir la photo" class="box fresco" data-fresco-group="photo" href="/web/img/gallerie/<?php echo $ph['nom'] ?>">
				</a>
			</div>
		<?php endforeach ?>
	<div class="clear"></div>
</div>