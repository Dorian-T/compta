// === Global functions ===

function filterDataByYear(data, year) {
	return data.filter((_, index) => labels[index].startsWith(year));
}


// === Balance chart ===

function filterDataForBalanceChart(labels, balances, incomes, expenses, year) {
	return [
		filterDataByYear(labels, year),
		filterDataByYear(balances, year),
		filterDataByYear(incomes, year),
		filterDataByYear(expenses, year)
	];
}

function createBalanceChart(canvas, chart, labels, balances, incomes, expenses) {
	if (chart !== null)
		chart.destroy();

	return new Chart(canvas, {
		type: 'line',
		data: {
			labels: labels,
			datasets: [
				{
					label: 'Solde',
					data: balances,
					backgroundColor: 'rgb(0, 0, 0)',
					borderColor: 'rgb(0, 0, 0)',
					borderWidth: 1
				},
				{
					label: 'Revenus',
					data: incomes,
					backgroundColor: 'rgb(0, 255, 0)',
					borderColor: 'rgb(0, 255, 0)',
					borderWidth: 1
				},
				{
					label: 'Dépenses',
					data: expenses,
					backgroundColor: 'rgb(255, 0, 0)',
					borderColor: 'rgb(255, 0, 0)',
					borderWidth: 1
				}
			]
		}
	});
}


// === Frequency chart ===