<h3>
    <?= htmlspecialchars($advertiser_id) ?>
</h3>
<?php if (!empty($adsCounts)) : ?>
    <table>
        <thead>
            <tr>
                <th>Region Name</th>
                <th>Region Code</th>
                <th>Ad Count</th>
                <th>Link</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($adsCounts as $regionCode => $count) : ?>
                <tr>
                    <td><?= htmlspecialchars($regions[$regionCode]->getRegionName()) ?></td>
                    <td><?= htmlspecialchars($regions[$regionCode]->getRegionCode()) ?></td>
                    <td><?= htmlspecialchars($count) ?></td>
                    <td>
                        <a href="https://adstransparency.google.com/advertiser/<?= htmlspecialchars($advertiser_id) ?>?region=<?= htmlspecialchars($regions[$regionCode]->getRegionAlpha2()) ?>&hl=en_US" target="_blank">View Ads
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>No data available. Please ensure all parameters are correctly provided.</p>
<?php endif; ?>