<?php ob_start(); ?>

<main id="add">
	<form action="./?action=add" method="post">
		<label for="date" autofocus>Date</label>
		<input type="date" id="date" name="date" placeholder="Date" required />

		<label for="banking_date">Date banquaire</label>
		<input type="date" name="banking_date" placeholder="Date banquaire" />

		<input type="text" name="description" placeholder="Description" required/>

		<input type="number" name="amount" placeholder="Montant" required />

		<label for="bank_account">Compte</label>
		<select id="bank_account" name="bank_account" required>
			<?php foreach ($accounts as $account): ?>
				<option value="<?= $account->getId(); ?>"><?= $account->getName(); ?></option>
			<?php endforeach; ?>
		</select>

		<label for="payment_method">Moyen de paiement</label>
		<select id="payment_method" name="payment_method" required>
			<?php foreach ($paymentMethods as $paymentMethod): ?>
				<option value="<?= $paymentMethod->getId(); ?>"><?= $paymentMethod->getName(); ?></option>
			<?php endforeach; ?>
		</select>

		<label for="frequency">Fréquence</label>
		<select id="frequency" name="frequency" required>
			<?php foreach ($frequencies as $frequency): ?>
				<option value="<?= $frequency->getID(); ?>"><?= $frequency->getName(); ?></option>
			<?php endforeach; ?>
		</select>

		<label for="category">Catégorie</label>
		<select id="category" name="category">
			<?php foreach ($categories as $category): ?>
				<option class="<?= $category->getType() ?>" value="<?= $category->getID(); ?>"><?= $category->getName(); ?></option>
			<?php endforeach; ?>
		</select>
		<script defer> <!-- TODO: Fix this -->
			document.getElementById('amount').addEventListener('change', function(e) {
				var categorySelect = document.getElementById('category');
				console.log(categorySelect);
				var options = Array.from(categorySelect.getElementsByTagName('option'));
				console.log(options);
				var amount = e.target.value;
				console.log(amount);

				options.forEach(function(option) {
					if((option.classList.contains('0') && amount < 0) || (option.classList.contains('1') && amount > 0))
						option.style.display = 'block';
					else
						option.style.display = 'none';
				});
						
			});
		</script>

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
</main>

<?php
$content = ob_get_clean();

require_once 'view/layout/layout.php';
?>
