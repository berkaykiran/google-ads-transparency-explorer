<!-- View/AdsDashboard.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Competitor Ads Dashboard</title>
</head>

<body>
    <h1>Competitor Ads Dashboard</h1>
    <?php if (!empty($adsCounts)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Region Name</th>
                    <th>Ad Count</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($adsCounts as $regionCode => $count) : ?>
                    <tr>
                        <td><?= htmlspecialchars($regions[$regionCode]) ?></td>
                        <td><?= htmlspecialchars($count) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No data available. Please ensure all parameters are correctly provided.</p>
    <?php endif; ?>
</body>

</html>