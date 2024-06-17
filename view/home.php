<?php ob_start(); ?>

<main id="home">
    <table aria-label="Table of transactions">
        <thead>
            <tr>
                <th>Date</th>
                <th>Date banquaire</th>
                <th>Description</th>
                <th>Montant</th>
                <th>Compte</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td>
                        <?= $transaction['transaction_date']; ?>
                    </td>
                    <td>
                        <?= $transaction['banking_date'] ?? ''; ?>
                    </td>
                    <td>
                        <?= $transaction['description']; ?>
                    </td>
                    <td>
                        <?= $transaction['amount']; ?>
                    </td>
                    <td>
                        <?= $transaction['source_account']; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php
$content = ob_get_clean();


require_once 'view/layout/layout.php';
?>
