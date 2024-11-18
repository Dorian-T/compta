<?php ob_start(); ?>

<main id="bdd">
	<table>
		<thead>
			<tr>
				<th>Date</th>
				<th>Date banquaire</th>
				<th>Description</th>
				<th>Montant</th>
				<th>Compte</th>
				<th>Moyen de paiement</th>
				<th>Fréquence</th>
				<th>Catégorie</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($transactions as $transaction): ?>
				<tr>
					<form action="index.php?action=bdd" method="post">
						<input type="hidden" name="id" value="<?= $transaction->getId(); ?>" />
						<td>
							<input type="date" name="date" value="<?= $transaction->getDate()->format('Y-m-d'); ?>" required />
						</td>
						<td>
							<input type="date" name="banking_date" value="<?= $transaction->getBankingDate() === null ? '' : $transaction->getBankingDate()->format('Y-m-d'); ?>" />
						</td>
						<td>
							<input type="text" name="description" value="<?= $transaction->getDescription(); ?>" required />
						</td>
						<td>
							<input type="number" name="amount" step="0.01" value="<?= $transaction->getAmount(); ?>" required />
						</td>
						<td>
							<select name="bank_account" required>
								<?php foreach ($bankAccounts as $bankAccount): ?>
									<option value="<?= $bankAccount->getId(); ?>" <?= $transaction->getBankAccount()->getId() === $bankAccount->getId() ? 'selected' : ''; ?>><?= $bankAccount->getName(); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td>
							<select name="payment_method" required>
								<?php foreach ($paymentMethods as $paymentMethod): ?>
									<option value="<?= $paymentMethod->getId(); ?>" <?= $transaction->getPaymentMethod()->getId() === $paymentMethod->getId() ? 'selected' : ''; ?>><?= $paymentMethod->getName(); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td>
							<select name="frequency" required>
								<?php foreach ($frequencies as $frequency): ?>
									<option value="<?= $frequency->getId(); ?>" <?= $transaction->getFrequency()->getId() === $frequency->getId() ? 'selected' : ''; ?>><?= $frequency->getName(); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td>
							<select name="category">
								<option value="">Autre</option>
								<?php foreach ($categories as $category): ?>
									<option value="<?= $category->getId(); ?>" <?= $transaction->getCategory() !== null && $transaction->getCategory()->getId() === $category->getId() ? 'selected' : ''; ?>><?= $category->getName(); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td>
							<button type="submit" name="submit" value="update">
								<img src="assets/check.svg" alt="Valider" />
							</button>
						</td>
						<td>
							<button type="submit" name="submit" value="delete">
								<img src="assets/x.svg" alt="Supprimer" />
							</button>
						</td>
					</form>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</main>

<?php
$content = ob_get_clean();

require_once 'view/layout/layout.php';
?>
