<?php $pager->setSurroundCount(1) ?>
<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
  <ul class="pagination justify-content-center">
    <?php if ($pager->hasPrevious()) : ?>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getPrevious() ?>"><?= lang('Pager.previous') ?></a>
      </li>
    <?php endif ?>

    <?php if ($pager->hasNext()) : ?>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getNext() ?>"><?= lang('Pager.next') ?></a>
      </li>
    <?php endif ?>
  </ul>
</nav>
