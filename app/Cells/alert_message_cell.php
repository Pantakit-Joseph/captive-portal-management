<?php if (!empty($messages)) : ?>
    <div class="alert alert-<?= $type; ?>">
        <?php if (is_array($messages)) : ?>
            <ul class="m-0 ps-3">
                <?php foreach ($messages as $message) : ?>
                    <li><?= $message; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <?= $messages; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>