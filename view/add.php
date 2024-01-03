<?php ob_start(); ?>

<main id="add">
	<form action="./?action=add" method="post">
		<input type="date" name="banking_date" placeholder="Date banquaire" required />
		<input type="date" name="transaction_date" placeholder="Date" />
		<input type="text" name="description" placeholder="Description" required/>
		<input type="number" name="amount" placeholder="Montant" required />
		<select name="source_account" required>
			<option value="CCP">CCP</option>
			<option value="Livret A">Livret A</option>
			<option value="Livret Swing">Livret Swing</option>
		</select>
		<input type="text" name="target"placeholder="Cible" />
		<select name="payment_method" required>
			<option value="CB">CB</option>
			<option value="Chèque">Chèque</option>
			<option value="Prélèvement">Prélèvement</option>
			<option value="Virement">Virement</option>
		</select>
		<div>
			<label for="category">Exceptionnelle</label>
			<input type="radio" name="exceptionnal" value="true" />
		</div>
		<div>
			<label for="loisir">Loisir</label>
			<input type="radio" name="loisir" value="true" />
		</div>
		<input type="text" name="category" placeholder="Sous-catégorie" />

		<input type="submit" name="submit" value="Ajouter" />
	</form>

	<table aria-describedby="10 last transactions">
		<caption>10 dernières transactions</caption>
		<thead>
			<tr>
				<th>Date</th>
				<th>Description</th>
				<th>Montant</th>
				<th>Compte</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($transactions as $transaction): ?>
				<tr>
					<td><?= $transaction['transaction_date']; ?></td>
					<td><?= $transaction['banking_date'] ?? ''; ?></td>
					<td><?= $transaction['description']; ?></td>
					<td><?= $transaction['amount']; ?></td>
					<td><?= $transaction['source_account']; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php $content = ob_get_clean(); ?>

<?php require_once 'view/layout/layout.php'; ?>
