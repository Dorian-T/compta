import pandas as pd
from datetime import datetime

# Read the Excel file
df = pd.read_excel('database/Compta.xlsm', sheet_name='BDD')

# Create the SQL file
with open('database/migration.sql', 'w', encoding='utf-8') as file:
	# Insert the first line
	file.write('INSERT INTO transactions (date, banking_date, description, amount, bank_account, payment_method, frequency) VALUES\n')

	# Insert the values
	for i in range(len(df) - 1, -1, -1):
		row = df.iloc[i]
		string = '\t('
		string += '\'' + row['Date opération'].strftime('%Y-%m-%d') + '\', '
		string += 'NULL, ' if row['Date bancaire'] == row['Date opération'] else '\'' + row['Date bancaire'].strftime('%Y-%m-%d') + '\', '
		string += '\'' + row['Libellé'].replace('\'', '\'\'') + '\', '
		string += str(row['Montant']) + ', '
		string += ('2' if row['Compte'] == 'Livret A' else '3' if row['Compte'] == 'Swing' else '1') + ', '
		string += ('1' if row['Moyen de payement'] == 'CB' else '2' if row['Moyen de payement'] == 'Chèque' else '3' if row['Moyen de payement'] == 'Prélèvement' else '4') + ', '
		string += '2' if row['Catégorie'] == 'régulier' else '1'
		string += ')' + (',' if i > 0 else ';') + '\n'
		file.write(string)

