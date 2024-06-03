<!-- View/AdsCountByCompetitor.php -->
<h3>
    <?php
    //TODO: Competitor Name and Info 
    ?>
</h3>
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