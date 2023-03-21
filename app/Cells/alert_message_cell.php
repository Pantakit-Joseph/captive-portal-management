<?php if (!empty($message)) : ?>
    <div class="alert alert-<?= $type; ?>">
        <?php if (is_array($message)) : ?>
            <ul class="m-0 ps-3">
                <?php foreach ($message as $item) : ?>
                    <li><?= $item; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <?= $message; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>