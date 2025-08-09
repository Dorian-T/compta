<?php ob_start(); ?>

<main id="add">
	<h1>Ajouter une transaction</h1>
	<form action="./?action=add" method="post">
		<table>
			<thead>
				<tr>
					<th>Date</th>
					<th>Date banquaire</th>
					<th>Description</th>
					<th>Montant</th>
					<th>Compte</th>
					<th>Moyen de<br>paiement</th>
					<th>Fréquence</th>
					<th>Catégorie</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<input type="date" name="date" placeholder="Date" required />
					</td>
					<td>
						<input type="date" name="banking_date" placeholder="Date banquaire" />
					</td>
					<td>
						<input type="text" name="description" placeholder="Description" required/>
					</td>
					<td>
						<input type="number" name="amount" placeholder="Montant" step="0.01" required />
					</td>
					<td>
						<select name="bank_account" required>
							<?php foreach ($accounts as $account): ?>
								<option value="<?= $account->getId(); ?>"><?= $account->getName(); ?></option>
							<?php endforeach; ?>
						</select>
					</td>
					<td>
						<select name="payment_method" required>
							<?php foreach ($paymentMethods as $paymentMethod): ?>
								<option value="<?= $paymentMethod->getId(); ?>"><?= $paymentMethod->getName(); ?></option>
							<?php endforeach; ?>
						</select>
					</td>
					<td>
						<select name="frequency" required>
							<?php foreach ($frequencies as $frequency): ?>
								<option value="<?= $frequency->getID(); ?>"><?= $frequency->getName(); ?></option>
							<?php endforeach; ?>
						</select>
					</td>
					<td>
						<select name="category">
							<?php foreach ($categories as $category): ?>
								<option class="<?= $category->getType() ? '1' : '0' ?>" value="<?= $category->getID(); ?>"><?= $category->getName(); ?></option>
							<?php endforeach; ?>
							<option class="0 1" value="">Autre</option>
						</select>
					</td>
					<td>
						<button type="submit" name="submit" value="store">
							<img src="assets/plus.svg" alt="Ajouter" />
						</button>
					</td>
				</tr>
			</tbody>
		</table>
		<script defer>
			document.querySelector('input[name="amount"]').addEventListener('change', function(e) {
				var categorySelect = document.querySelector('select[name="category"]');
				console.log(categorySelect);
				var options = Array.from(categorySelect.getElementsByTagName('option'));
				console.log(options);
				var amount = e.target.value;
				console.log(amount);

				options.forEach(function(option) {
					if((option.classList.contains('0') && amount < 0) || (option.classList.contains('1') && amount > 0) || amount == 0)
						option.style.display = 'block';
					else
						option.style.display = 'none';
				});
			});
		</script>
	</form>

	<h1>10 dernières transactions</h1>
	<table aria-describedby="10 last transactions">
		<thead>
			<tr>
				<th>Date</th>
				<th>Date<br>banquaire</th>
				<th>Description</th>
				<th>Montant</th>
				<th>Compte</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($transactions as $transaction): ?>
				<tr>
					<td><?= $transaction->getDate()->format('d/m/Y'); ?></td>
					<td><?= $transaction->getBankingDate() === null ? '' : $transaction->getBankingDate()->format('d/m/Y'); ?></td>
					<td><?= $transaction->getDescription(); ?></td>
					<td><?= number_format((float) $transaction->getAmount(), 2, '.', ' '); ?> €</td>
					<td><?= $transaction->getBankAccount()->getName(); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</main>

<?php
$content = ob_get_clean();

require_once 'view/layout/layout.php';
?>
