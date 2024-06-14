<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'db.php';

$coins = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $symbols = strtoupper($_POST['symbols']);
    $api_key = "aaaa677a-2563-4bdd-8c9b-356283f40089";
    $url = "https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?symbol=$symbols";

    $headers = [
        'Accepts: application/json',
        'X-CMC_PRO_API_KEY: ' . $api_key,
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => 1,
    ]);

    $response = curl_exec($curl);
    $data = json_decode($response, true);
    curl_close($curl);

    if (isset($data['data'])) {
        $coins = $data['data'];

        // Log search history
        $stmt = $conn->prepare("INSERT INTO search_history (user_id, symbols) VALUES (?, ?)");
        $stmt->bind_param("is", $_SESSION['user_id'], $symbols);
        $stmt->execute();
        $stmt->close();
    } else {
        $error = "Failed to fetch data.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="img/Cashrich_logo_2.png">
    <script src="js/search.js" defer></script>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <form action="search.php" method="POST" class="search-form">
            <h1>Search</h1>
            <?php if (isset($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
            <div class="search-bar-container">
                <input type="text" name="symbols" placeholder="Enter coin symbols (e.g. BTC,ETH)" required>
                <button type="submit">Search</button>
            </div>
        </form>
        <?php if (!empty($coins)): ?>
            <div class="results">
                <?php foreach ($coins as $coin): ?>
                    <div class="coin-card">
                        <div class="coin-header">
                            <h3><?= $coin['name'] ?></h3>
                            <span class="change <?= $coin['quote']['USD']['percent_change_24h'] >= 0 ? 'positive' : 'negative' ?>">
                                <?= $coin['quote']['USD']['percent_change_24h'] >= 0 ? '↑' : '↓' ?> <?= number_format($coin['quote']['USD']['percent_change_24h'], 2) ?>%
                            </span>
                        </div>
                        <div class="coin-details">
                            <div class="price-rank">
                                <p class="price">Price: $<?= number_format($coin['quote']['USD']['price'], 2) ?></p>
                                <p class="rank">Rank: <?= $coin['cmc_rank'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
