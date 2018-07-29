<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<title><?= $d['title'] ?></title>
		<link rel="icon" href="/web/img/favicon.png" />
		<link rel="icon" type="image/png" href="/web/img/favicon.png" />
		<link rel="stylesheet" href="/web/css/style.css">
		<link rel="stylesheet" href="/web/css/responsive.css">
		<link rel="stylesheet" href="/web/css/jquery.vegas.css">
		<link rel="stylesheet" href="/web/css/messenger.css">
		<link rel="stylesheet" href="/web/css/messenger-theme-flat.css">
		<link rel="stylesheet" href="/web/lib/owl/owl.carousel.css">
		<link rel="stylesheet" href="/web/lib/fresco/fresco.css">
		<script src="/web/lib/jquery.js"></script>
		<script src="/web/js/css.js"></script>
		<script src="/web/js/calendar.js"></script>
		<script src="/web/js/responsive.js"></script>
        <script src="/web/lib/messenger.js"></script>
        <!-- <script src="/web/lib/freewall/freewall.js"></script> -->
        <script src="/web/lib/jquery.vegas.js"></script>
		<script src="/web/lib/backstretch.js"></script>
		<script src="/web/lib/fresco/fresco.js"></script>
		<script src="/web/lib/owl/owl.carousel.min.js"></script>
        <script src="/web/js/owl.js"></script>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-54437632-4', 'auto');
			ga('send', 'pageview');

		</script>
		<script>
		$(document).ready(function(){
			Messenger.options = {
				theme : 'flat',
				extraClasses: 'messenger-fixed messenger-on-top',
				showCloseButton: true
			};

			var wall = new freewall('.nested');

			wall.reset({
				selector: '.brick',
				animate: true,
				cellW: 230,
				gutterX : 5 ,
				gutterY : 5 ,
				fixSize : null,
				cellH: 'auto',
				onResize: function() {
					wall.fitWidth();
				}
			});

			wall.fitWidth();
		});
		</script>
	</head>
	<body class="<?php if(isset($d['bodyclass'])) echo $d['bodyclass']; ?>">
		<header>
			<div class="header-wrapper">
				<div class="logo" title="Retour à l'accueil">
					<a href="/">
						<img src="/web/img/logo4.png" alt="">
						<h1>La Caze</h1>
						<h3>Hébergements</h3>
					</a>
				</div>
				<ul class="hidden">
					<li><a href="/le-camping" class="full">Le camping</a></li>
					<li><a href="/la-chambre" class="full">La chambre</a></li>
					<li><a href="/photos" class="full">Photos</a></li>
					<li><a href="/alentours" class="full">Aux alentours</a></li>
					<li><a href="/reserver" class="full">Tarifs/Réserver</a></li>
					<li><a href="/contact" class="full">Contact</a></li>
				</ul>
				<div class="btn-menu">
					<img src="/web/img/menusmall.png" alt=""/>
					Menu
				</div>
			</div>
		</header>
		<div class="body">
			
			<div class="wrap">
				<?php include $meta['template'] ?>
			</div>

		</div>
		<div class="clear"></div>
		<footer>
			<div class="wrap">
				<div class="bloc">
					<h4>Camping de la caze</h4>
					<p>
                        Gamping en Aveyron, hébergements chez l'habitant.
					</p>
				</div>
				<div class="bloc">
					<h4>Contact</h4>
					<p>
						lieu dit " LA CAZE " <br> 12200 La bastide l'Eveque <br> contact@camping-lacaze.fr <br> 05 81 39 17 81
						<br/>
						06 16 16 07 31
						<br/>
<!--						<img style="width: 20px;" src="/web/img/facebook.png" alt=""/>-->
						<a class="fb" href="https://www.facebook.com/pages/Gamping-de-La-Caze/1642447289302721?ref=ts&fref=ts">Rejoignez nous sur facebook</a>
					</p>
				</div>
				<div class="bloc">
				</div>
				<div class="bloc right small-full">
                    <div id="cont_MTIwMjF8MnwxfDN8MXwwMDAwMDB8M3xGRkZGRkZ8Y3wx"><div id="spa_MTIwMjF8MnwxfDN8MXwwMDAwMDB8M3xGRkZGRkZ8Y3wx"><a id="a_MTIwMjF8MnwxfDN8MXwwMDAwMDB8M3xGRkZGRkZ8Y3wx" href="http://www.meteocity.com/france/la-bastide-l-eveque_v12021/" rel="nofollow" target="_blank" style="color:#333;text-decoration:none;">Météo La Bastide-l'Évêque</a></div><script type="text/javascript" src="http://widget.meteocity.com/js/MTIwMjF8MnwxfDN8MXwwMDAwMDB8M3xGRkZGRkZ8Y3wx"></script></div>

                    <!--					<h4>Newsletter</h4>-->
<!--					<p>Entrez votre mail pour recevoir les nouvelles de la Caze</p>-->
<!--					<form action="addnewsletter" method="post">-->
<!--						<input type="text" name="mail" palceholder="Adresse e-mail">-->
<!--						<input type="submit" class="confirm small-right" value="inscription">-->
<!--					</form>-->
				</div>

				<div class="clear"></div>
			</div>
			<div style="background-color: #444; color: #e5e5e5">
				<div class="wrap">
					<p class="sign">site soigneusement développé par <a href="http://felixmarchenay.fr">Félix Marchenay</a></p>
				</div>
			</div>
		</footer>
		<script>
				$('body').not('.photos').find('.body').backstretch([
					<?php if(isset($d['fonds'])) : ?>
						<?php foreach($d['fonds'] as $f ) : ?>

							'/web/img/gallerie/<?= $f['nom'] ?>',

						<?php endforeach ?>
					<?php else : ?>
						'/web/img/back.jpg',
						'/web/img/back2.JPG',
						'/web/img/back3.JPG',
					<?php endif ?>
					],{duration : 3000, fade : 600})
		</script>
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