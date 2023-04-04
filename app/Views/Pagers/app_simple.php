<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(0);
?>
<nav>
	<ul class="pagination">
		<li class="page-item <?= $pager->hasPrevious() ? '' : 'disabled' ?>">
			<a href="<?= $pager->getPrevious() ?? '#' ?>" class="page-link" aria-label="<?= lang('Pager.previous') ?>">
				<span aria-hidden="true"><?= lang('Pager.newer') ?></span>
			</a>
		</li>
		<li class="page-item <?= $pager->hasNext() ? '' : 'disabled' ?>">
			<a href="<?= $pager->getnext() ?? '#' ?>" class="page-link" aria-label="<?= lang('Pager.next') ?>">
				<span aria-hidden="true"><?= lang('Pager.older') ?></span>
			</a>
		</li>
	</ul>
</nav>
