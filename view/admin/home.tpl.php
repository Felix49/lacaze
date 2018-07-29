<div class="notif"></div>


<div class="panel">
	<div class="user">
		<div class="pic">
			<a class="full" href="./logout"></a>
			<img src="/web/userpic/<?php echo $d['user']['picture'] ?>.png" alt="">
		</div>
		<p>Bienvenue dans le back office, 
		<span style="color: #2ad69f">
		<?php echo $d['user']['nom']; ?>
		</span></p>
		<a href="/logout">se déconnecter</a>
	</div>
	<ul class="menu">
		<a href="/admin"><li>Accueil</li></a>
		<a href="/admin/stats"><li>Statistiques</li></a>
		<a href="/admin/reservations"><li>Réservations</li></a>
		<a href="/admin/clients"><li>Clients</li></a>
		<li class="dad">
			Photos
			<ul class="son">
				<a href="/admin/photos-gallerie"><li>Gallerie</li></a>
				<a href="/admin/photos-fond"><li>Fonds</li></a>
			</ul>
		</li>
		<a href="/admin/alentours"><li>Aux alentours</li></a>
        <a href="/admin/textes"><li>Textes</li></a>
		<a href="/admin/contact"><li>Contact</li></a>
	</ul>
	<a href="/">Aller sur le site</a>
</div>
<div class="contentadmin">
	<?php include($d['tab']); ?>
</div>
<div class="clear"></div>
