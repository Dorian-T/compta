USE `compta`;

INSERT INTO `bank_accounts` (`name`) VALUES
    ('CCP'),
    ('Livret A'),
    ('Livret Swing');

-- Payment methods table
INSERT INTO `payment_methods` (`name`) VALUES
    ('CB'),
    ('Chèque'),
    ('Prélèvement'),
    ('Virement');

-- Frequencies table
INSERT INTO `frequencies` (`name`) VALUES
    ('Ponctuel'),
    ('Régulier');

-- Categories table
INSERT INTO `categories` (`name`, `type`) VALUES
    ('Epargne', 0),
    ('Loisir', 0),
    ('Polyenco', 0),
    ('Primaire', 0),
    ('Sport', 0),
    ('Scolaire', 0),
    ('Aide', 1),
    ('Epargne', 1),
    ('Remboursement', 1),
    ('Salaire', 1);