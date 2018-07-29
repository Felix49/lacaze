<div class="box s75">
	<h1>Dernières réservations</h1>
	<table>
	<?php if(isset($d['reservations'])){
		echo '
			<tr>
				<th>Nom</th>
				<th>Date d\'arrivée</th>
				<th>Nombre de personnes</th>
				<th>Type réservations</th>
			</tr>
		';
		foreach ($d['reservations'] as $resa) {
			$res = $resa->render();
			echo '<tr><td>'.
				$res['client']['prenom'].' '.$res['client']['nom'].'</td><td>'.
				$res['dateDebut'].'</td><td>'.
				$res['nbPersonne'].'</td><td>'.
				$res['typeBien'].'</td><td>'.
				'</td></tr>';
		}
	} ?>
	</table>
</div>