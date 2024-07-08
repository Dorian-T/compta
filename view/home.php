<?php ob_start(); ?>

<main id="home">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="js/home.js"></script>

	<table>
		<caption>
			<h2>Soldes</h2>
		</caption>
		<thead>
			<tr>
				<th>Compte</th>
				<th>Solde</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($accounts as $account): ?>
				<tr>
					<td><?= $account->getName() ?></td>
					<td><?= $account->getBalance() ?> €</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<section id="balanceChart">
		<h2>Évolution du solde</h2>

		<select>
			<?php
			$years = array_unique(array_map(function($date) {
				return substr($date, 0, 4);
			}, array_keys($balances)));
			sort($years);
			?>
			<?php foreach ($years as $year): ?>
				<option value="<?= $year ?>" <?= $year === date('Y') ? 'selected' : '' ?>><?= $year ?></option>
			<?php endforeach; ?>
		</select>

		<canvas></canvas>

		<script defer>
			// Get data from PHP
			var months = <?= json_encode(array_keys($balances)) ?>;
			var balances = <?= json_encode(array_values($balances)) ?>;
			var incomes = <?= json_encode(array_values($incomes)) ?>;
			var expenses = <?= json_encode(array_values($expenses)) ?>;

			// Filter the data by year
			var [filteredMonths, filteredBalances, filteredIncomes, filteredExpenses] = filterDataForBalanceChart(months, balances, incomes, expenses, '<?= date('Y') ?>');

			// Create the chart
			const balanceCanvas = document.querySelector('#balanceChart canvas');
			balanceChart = null;
			balanceChart = createBalanceChart(balanceCanvas, balanceChart, filteredMonths, filteredBalances, filteredIncomes, filteredExpenses);

			// Update the chart when the year changes
			document.querySelector('#balanceChart select').addEventListener('change', function() {
				var year = this.value;
				[filteredMonths, filteredBalances, filteredIncomes, filteredExpenses] = filterDataForBalanceChart(months, balances, incomes, expenses, year);
				balanceChart = createBalanceChart(balanceCanvas, balanceChart, filteredMonths, filteredBalances, filteredIncomes, filteredExpenses);
			});
		</script>
	</section>

	<section id="frequencyChart">
		<h2>Dépenses par fréquence</h2>

		<select>
			<?php
			var_dump($transactionsByFrequency[$frequency[0]]);
			$years = array_unique(array_map(function($date) {
				return substr($date, 0, 4);
			}, array_keys(reset($transactionsByFrequency))));
			sort($years);
			?>
			<?php foreach ($years as $year): ?>
				<option value="<?= $year ?>" <?= $year === date('Y') ? 'selected' : '' ?>><?= $year ?></option>
			<?php endforeach; ?>
		</select>

		<canvas></canvas>

		<script defer>
			// Get data from PHP
			var frequencies = <?= json_encode(array_keys($transactionsByFrequency)) ?>;
			var transactionsByFrequency = <?= json_encode(array_values($transactionsByFrequency)) ?>;

			// Filter the data by year
			var filteredTransactionsByFrequency = filterDataByCategoryAndYear(transactionsByFrequency, '<?= date('Y') ?>');

			// Create the chart
			const frequencyCanvas = document.querySelector('#frequencyChart canvas');
			frequencyChart = null;
			frequencyChart = createFrequencyChart(frequencyCanvas, frequencyChart, frequencies, filteredTransactionsByFrequency);

			// Update the chart when the year changes
			document.querySelector('#frequencyChart select').addEventListener('change', function() {
				var year = this.value;
				filteredTransactionsByFrequency = filterDataByCategoryAndYear(transactionsByFrequency, year);
				frequencyChart = createFrequencyChart(frequencyCanvas, frequencyChart, frequencies, filteredTransactionsByFrequency);
			});
		</script>
	</section>

	<section id="categoryChart">
		<h2>Dépenses par catégorie</h2>

		<select>
			<?php
			$years = array_unique(array_map(function($date) {
				return substr($date, 0, 4);
			}, array_keys(reset($transactionsByCategory))));
			sort($years);
			?>
			<?php foreach ($years as $year): ?>
				<option value="<?= $year ?>" <?= $year === date('Y') ? 'selected' : '' ?>><?= $year ?></option>
			<?php endforeach; ?>
		</select>

		<canvas></canvas>

		<script defer>
			console.log("Hello world");
			// Get data from PHP
			var categories = <?= json_encode(array_keys($transactionsByCategory)) ?>;
			var transactionsByCategory = <?= json_encode(array_values($transactionsByCategory)) ?>;

			// Filter the data by year
			var filteredTransactionsByCategory = filterDataByCategoryAndYear(transactionsByCategory, '<?= date('Y') ?>');

			// Create the chart
			const categoryCanvas = document.querySelector('#categoryChart canvas');
			categoryChart = null;
			console.log("oui");
			console.log(categories, filteredTransactionsByCategory);
			categoryChart = createCategoryChart(categoryCanvas, categoryChart, categories, filteredTransactionsByCategory);

			// Update the chart when the year changes
			document.querySelector('#categoryChart select').addEventListener('change', function() {
				var year = this.value;
				filteredTransactionsByCategory = filterDataByCategoryAndYear(transactionsByCategory, year);
				categoryChart = createCategoryChart(categoryCanvas, categoryChart, categories, filteredTransactionsByCategory);
			});
		</script>
	</section>

	<section>
		<h2>Recettes par fréquence</h2>
	</section>

	<section>
		<h2>Recettes par catégorie</h2>
	</section>
</main>

<?php
$content = ob_get_clean();


require_once 'view/layout/layout.php';
?>
