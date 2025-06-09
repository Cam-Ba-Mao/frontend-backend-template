<?php
$count = \RT\Core\Event\EventFunctions::getEvents('', 1, 0, '', true);
$limit = intval(\RT\Core\Event\EventFunctions::getSettings('limit'));
?>
<?php if ($count > $limit) : ?>
    <div class="rt-event__list--more">
        <button class="btn rt-button__loadmore" type="button"><?= __('Xem thêm', 'rt'); ?></button>
    </div>
<?php endif; ?>