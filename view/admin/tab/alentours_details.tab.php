<div class="box s100">
	
	<?php if($d['le_spot']) : ?>

	<h1>Aux alentours de : <i><?php echo $d['le_spot']['nom'] ?></i></h1>
	
	<?php $d['form']['spots']->render() ?>

	<?php else : ?>

	<h1>Aux alentours de .. introuvable</h1>
	
	<p>Cet endroit est introuvable, <a href="/admin/alentours">essayez-en un autre</a></p>
	<?php endif ?>

</div>

<?php if(isset($d['trumbo'])) : ?>
	<script>
		$(document).ready(function(){
			var desc = <?php echo '\''.preg_replace('#\r\n#', '', (addslashes($d['trumbo']))).'\'' ?>;
			$('#trumbowysiwyg').trumbowyg('html',desc);
		})
	</script>
<?php endif ?>

<script src="https://maps-api-ssl.google.com/maps/api/js"></script>
<script language="javascript" src="/web/js/map.js"></script>
