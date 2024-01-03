-- Test data for the transaction table
INSERT INTO transactions (banking_date, transaction_date, description, amount, account, payment_method, category, subcategory)
VALUES
    ('2022-01-01', '2022-01-01', 'Test transaction 1', 100.00, 'Compte courant', 'Carte bancaire', 'Régulier', 'Courses'),
    ('2022-01-02', '2022-01-02', 'Test transaction 2', 200.00, 'Compte courant', 'Carte bancaire', 'Régulier', 'Courses'),
    ('2022-01-03', '2022-01-03', 'Test transaction 3', 300.00, 'Compte courant', 'Carte bancaire', 'Régulier', 'Courses');