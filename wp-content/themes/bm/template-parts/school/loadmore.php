<?php
    $count = \RT\Core\School\SchoolFunctions::getSchoolsCount();
    $limit = \RT\Core\School\SchoolFunctions::getSetting('limit');
?>
<?php if($count > $limit) : ?>
<div class="rt-school__list--more">
    <button class="btn btn-primary rt-button__loadmore"><?= __('Xem thêm', 'rt'); ?></button>
</div>
<?php endif; ?>