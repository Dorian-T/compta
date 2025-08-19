// === Global functions ===

function filterDataByYear(data, labels, year) {
	return data.filter((_, index) => labels[index].startsWith(year));
}

function autoColors(count) {
	const colors = [];
	for (let i = 0; i < count; i++) {
		const hue = i * 360 / count;
		colors.push(`hsl(${hue}, 100%, 50%)`);
	}
	return colors;
}


// === Balance chart ===

function filterDataForBalanceChart(labels, balances, incomes, expenses, year) {
	return [
		filterDataByYear(labels, labels, year),
		filterDataByYear(balances, labels, year),
		filterDataByYear(incomes, labels, year),
		filterDataByYear(expenses, labels, year),
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

function createFrequencyChart(canvas, chart, labels, frequencies) {
	if (chart !== null)
		chart.destroy();

	return new Chart(canvas, {
		type: 'pie',
		data: {
			labels: labels,
			datasets: [
				{
					label: 'Dépense',
					data: frequencies,
					backgroundColor: autoColors(frequencies.length),
					hoverOffset: 4
				}
			]
		}
	});
}


// === Category chart ===

function createCategoryChart(canvas, chart, labels, categories) {
	if (chart !== null)
		chart.destroy();

	return new Chart(canvas, {
		type: 'pie',
		data: {
			labels: labels,
			datasets: [
				{
					label: 'Dépense',
					data: categories,
					backgroundColor: autoColors(categories.length),
					hoverOffset: 4
				}
			]
		}
	});
}