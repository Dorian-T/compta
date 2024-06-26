<?php ob_start(); ?>

<main id="home">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<table>
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
		<canvas width="400" height="200"></canvas>
		<script defer>
			// Get data from PHP
			var labels = <?= json_encode(array_keys($balances)) ?>;
			var balances = <?= json_encode(array_values($balances)) ?>;
			var incomes = <?= json_encode(array_values($incomes)) ?>;
			var expenses = <?= json_encode(array_values($expenses)) ?>;

			// Declare variables outside the callback function
			var filteredLabels, filteredBalances, filteredIncomes, filteredExpenses;

			// Get canvas
			const balanceChart = document.querySelector('#balanceChart canvas');
			myChart = null;

			function filterData(year) {
				filteredLabels = labels.filter(label => label.startsWith(year));
				filteredBalances = balances.filter((_, index) => labels[index].startsWith(year));
				filteredIncomes = incomes.filter((_, index) => labels[index].startsWith(year));
				filteredExpenses = expenses.filter((_, index) => labels[index].startsWith(year));

				updateChart();
			}

			function updateChart() {
				if (myChart !== null)
					myChart.destroy();

				myChart = new Chart(balanceChart, {
					type: 'line',
					data: {
						labels: filteredLabels,
						datasets: [
							{
								label: 'Solde',
								data: filteredBalances,
								backgroundColor: 'rgb(0, 0, 0)',
								borderColor: 'rgb(0, 0, 0)',
								borderWidth: 1
							},
							{
								label: 'Revenus',
								data: filteredIncomes,
								backgroundColor: 'rgb(0, 255, 0)',
								borderColor: 'rgb(0, 255, 0)',
								borderWidth: 1
							},
							{
								label: 'Dépenses',
								data: filteredExpenses,
								backgroundColor: 'rgb(255, 0, 0)',
								borderColor: 'rgb(255, 0, 0)',
								borderWidth: 1
							}
						]
					}
				});
			}

			filterData('<?= date('Y') ?>');

			document.querySelector('#balanceChart select').addEventListener('change', function() {
				var year = this.value;

				filterData(year);
			});
		</script>
	</section>

	<canvas id="frequencyChart" width="400" height="200"></canvas>

	<canvas id="categoryChart" width="400" height="200"></canvas>
</main>

<?php
$content = ob_get_clean();


require_once 'view/layout/layout.php';
?>
