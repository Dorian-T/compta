-- Test data for the transaction table
INSERT INTO transactions (banking_date, transaction_date, description, amount, source_account, target, payment_method, category, subcategory)
VALUES
    ('2022-01-01', '2022-01-01', 'Test transaction 1', 100.00, 'Compte courant', 'Compte épargne', 'Virement', 'Régulier', 'Salaire'),
    ('2022-01-02', '2022-01-02', 'Test transaction 2', 200.00, 'Compte courant', 'Compte épargne', 'Virement', 'Régulier', 'Loyer'),
    ('2022-01-03', '2022-01-03', 'Test transaction 3', 300.00, 'Compte courant', 'Compte épargne', 'Virement', 'Régulier', 'Courses'),
    ('2022-01-04', '2022-01-04', 'Test transaction 4', 400.00, 'Compte courant', 'Compte épargne', 'Virement', 'Régulier', 'Essence'),
    ('2022-01-05', '2022-01-05', 'Test transaction 5', 500.00, 'Compte courant', 'Compte épargne', 'Virement', 'Régulier', 'Loisir'),
    ('2022-01-06', '2022-01-06', 'Test transaction 6', 600.00, 'Compte courant', 'Compte épargne', 'Virement', 'Régulier', 'Salaire'),
    ('2022-01-07', '2022-01-07', 'Test transaction 7', 700.00, 'Compte courant', 'Compte épargne', 'Virement', 'Régulier', 'Loyer'),
    ('2022-01-08', '2022-01-08', 'Test transaction 8', 800.00, 'Compte courant', 'Compte épargne', 'Virement', 'Régulier', 'Courses'),
    ('2022-01-09', '2022-01-09', 'Test transaction 9', 900.00, 'Compte courant', 'Compte épargne', 'Virement', 'Régulier', 'Essence'),
    ('2022-01-10', '2022-01-10', 'Test transaction 10', 1000.00, 'Compte courant', 'Compte épargne', 'Virement', 'Régulier', 'Loisir');