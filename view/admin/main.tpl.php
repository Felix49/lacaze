<html>
	<head>
		<meta charset="UTF-8">
		<link rel="icon" type="image/png" href="/web/img/favicon.png" />
		<title><?php echo $d['title']; ?></title>
		<script language="javascript" src="/web/lib/jquery.js"></script>
		<script language="javascript" src="/web/lib/messenger/messenger.min.js"></script>
		<script language="javascript" src="/web/lib/trumbowyg.min.js"></script>
		<script language="javascript" src="/web/js/admin.js"></script>
		<script language="javascript" src="/web/lib/autosearch.js"></script>
		<script language="javascript" src="/web/lib/jquery-ui.js"></script>
		<script language="javascript" src="/web/js/upload.js"></script>
		<script src="/web/js/upload.js"></script>
		<link rel="stylesheet" href="/web/css/style.css">
		<link rel="stylesheet" href="/web/css/admin.css">
		<link rel="stylesheet" href="/web/css/animate.css">
		<link rel="stylesheet" href="/web/lib/messenger/messenger.css">
		<link rel="stylesheet" href="/web/lib/messenger/messenger-theme-flat.css">
		<link rel="stylesheet" href="/web/css/trumbowyg.css">
		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
		<script>
		$(document).ready(function(){
			Messenger.options = {
				theme : 'flat',
				extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
			};

			$('#trumbowyg').trumbowyg();

			var drop = $('#newphoto').dropable();

		})
		</script>
	</head>
	<body class="<?php if(isset($d['bodyclass'])) echo $d['bodyclass']; ?>">
		<?php 
		
		include($meta['template']);

		?>
	</body>
</html>


<?php if(!empty($msg)) : ?>
<script>
$(document).ready(function(){
	
	<?php foreach ($msg as $ms) : ?>
	Messenger().post(
		<?php echo $ms ?>
		)
	<?php endforeach ?>
})
</script>
<?php endif ?>
