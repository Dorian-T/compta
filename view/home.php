<?php ob_start(); ?>

<main id="home">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/mermaid@11/dist/mermaid.min.js"></script>
	<script>
		mermaid.initialize({ startOnLoad: true });
	</script>
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
			<?php $sum = 0.0; ?>
			<?php foreach ($accounts as $account): ?>
				<?php $balance = $account->getBalance(); ?>
				<?php $sum += $balance; ?>
				<tr>
					<td><?= $account->getName() ?></td>
					<td><?= number_format($balance, 2, '.', ' ') ?> €</td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td><strong>Total</strong></td>
				<td><strong><?= number_format($sum, 2, '.', ' ') ?> €</strong></td>
			</tr>
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

	<section id="categoryChart">
		<h2>Flux d'argent par catégorie</h2>

		<select>
			<?php
			$years = array_keys($category_csv);
			sort($years);
			?>
			<?php foreach ($years as $year): ?>
				<option value="<?= $year ?>" <?= $year == date('Y') ? 'selected' : '' ?>><?= $year ?></option>
			<?php endforeach; ?>
		</select>

		<div class="mermaid"></div>

		<script defer>
			async function mermaidDraw(definition, element) {
				const {svg} = await mermaid.render('graphDiv', definition);
				element.innerHTML = svg;
			}

			// Get data from PHP
			var categoryData = <?= json_encode($category_csv) ?>;

			// Create the Sankey diagram
			document.querySelector('#categoryChart .mermaid').innerHTML = "sankey-beta\n" + categoryData[(new Date().getFullYear())].join('\n');

			// Update the Sankey diagram when the year changes
			document.querySelector('#categoryChart select').addEventListener('change', function() {
				var year = this.value;
				diagram = document.querySelector('#categoryChart .mermaid');
				graphDefinition = "sankey-beta\n" + categoryData[year].join('\n');
				mermaidDraw(graphDefinition, diagram);
			});
		</script>
	</section>

	<section id="incomeFrequencyChart">
		<h2>Revenus par fréquence</h2>

		<select>
			<?php
			$years = array_keys($incomesByFrequency);
			sort($years);
			?>
			<?php foreach ($years as $year): ?>
				<option value="<?= $year ?>" <?= $year == date('Y') ? 'selected' : '' ?>><?= $year ?></option>
			<?php endforeach; ?>
		</select>

		<canvas></canvas>

		<script defer>
			// Get data from PHP
			var i_frequencies = <?= json_encode($frequencies) ?>;
			var i_transactions = <?= json_encode($incomesByFrequency) ?>;

			// Create the chart
			const i_canvas = document.querySelector('#incomeFrequencyChart canvas');
			i_chart = null;
			i_chart = createFrequencyChart(i_canvas, i_chart, i_frequencies, Object.values(i_transactions[(new Date().getFullYear())]));

			// Update the chart when the year changes
			document.querySelector('#incomeFrequencyChart select').addEventListener('change', function() {
				var year = this.value;
				i_chart = createFrequencyChart(i_canvas, i_chart, i_frequencies, Object.values(i_transactions[year]));
			});
		</script>
	</section>

	<section id="expenseFrequencyChart">
		<h2>Dépenses par fréquence</h2>

		<select>
			<?php
			$years = array_keys($expensesByFrequency);
			sort($years);
			?>
			<?php foreach ($years as $year): ?>
				<option value="<?= $year ?>" <?= $year == date('Y') ? 'selected' : '' ?>><?= $year ?></option>
			<?php endforeach; ?>
		</select>

		<canvas></canvas>

		<script defer>
			// Get data from PHP
			var e_frequencies = <?= json_encode($frequencies) ?>;
			var e_transactions = <?= json_encode($expensesByFrequency) ?>;

			// Create the chart
			const e_canvas = document.querySelector('#expenseFrequencyChart canvas');
			e_chart = null;
			e_chart = createFrequencyChart(e_canvas, e_chart, e_frequencies, Object.values(e_transactions[(new Date().getFullYear())]));

			// Update the chart when the year changes
			document.querySelector('#expenseFrequencyChart select').addEventListener('change', function() {
				var year = this.value;
				e_chart = createFrequencyChart(e_canvas, e_chart, e_frequencies, Object.values(e_transactions[year]));
			});
		</script>
	</section>
</main>

<?php
$content = ob_get_clean();


require_once 'view/layout/layout.php';
?>
