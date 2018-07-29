<div class="content">
	<h1>Réserver</h1>
	<h2>Grille de tarifs</h2>
	<table align="center">
		<tr>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<tr>
			<th rowspan="3" >Camping nuitée</th>
			<td>Emplacement + 2 personnes</td>
			<td>12 €</td>
		</tr>
		<tr>
			<td>Personne supplémentaire</td>
			<td>2 €</td>
		</tr>
		<tr>
			<td>Électricité</td>
			<td>2 €</td>
		</tr>
		<tr>
			<th rowspan="2">Chambre</th>
			<td>Hors saison</td>
			<td>30 €</td>
		</tr>
		<tr>
			<td>Haute saison</td>
			<td>35 €</td>
		</tr>
	</table>
    <i>
        * Haute saison : du 10/07 au 16/08
    </i>

	<h2>Vérifier les disponibilités</h2>
	<div class="ajaxchange leftcalendar">
		<?php Tool::renderCalendar($d['month'],$d['year']) ?>
	</div>
	<div class="rightcalendar">
<!--		<i style="font-size: 20px; padding-bottom: 30px;">Fonction en développement</i>-->
		<p class="legende" style="display: none;">
			<span style="background: #c5c5c5" class="c20_10"></span> : Disponible
			<span style="background: #ff5e24" class="c20_10"></span> : Complet
		</p>
		<br/>

		<form action="/reserver/send" method="post" class="resa">
			<div class="line">
				<label for="da">Arrivée</label><input required readonly name="da" id="da" type="text" placeholder="Date d'arrivée"/>
			</div>
			<div class="line"><label for="dd">Départ</label><input required readonly name="dd" id="dd" type="text" placeholder="Date de départ"/></div>
			<p class="reset">remettre les dates à zéro</p>
			<div class="line"><label for="n">Votre nom</label><input required name="nom" id="n" type="text"/></div>
			<div class="line">
				<label for="emp">Nombre d'emplacements</label>
				<select name="emp" id="emp">
					<option value="">Pas d'emplacement</option>
					<?php for($i=1;$i<=6;$i++) : ?>
						<option value="<?= $i ?>"><?= $i ?></option>
					<?php endfor ?>
				</select>
			</div>
			<div class="line">
				<label for="nb_ch">Nombre de chambre</label>
				<select name="room" id="nb_ch">
					<option value="0">Pas de chambre</option>
					<option value="1">Chambre d'hôte</option>
				</select>
			</div>
			<div class="line">
				<label for="nb_pers">Personnes supplémentaires</label><input type="number" name="nb_pers" min="0" max="18" value="0">
			</div>
			<div class="line"><label for="ad">Votre adresse mail</label><input required name="mail" id="ad" type="email"/></div>
			<div class="line">
                <label for="elec">Electricité</label>
                <input type="checkbox" id="elec" name="elec">
            </div>
            <div class="line" style="display: none;">
                <p class="est-price">Prix estimé : <span class="price"></span></p>
            </div>

            <button type="submit" class="btn">Demander une réservation</button>
		</form>
	</div>

	<div class="clear"></div>

	
</div>