<?php if($posts = \RT\Core\School\SchoolFunctions::getSchoolsRelated(get_the_ID())) : ?>
<section class="rt-school__list rt-school__related">
    <div class="container">
        <div class="rt-block__heading">
            <h3 class="rt-title"><?= __('Trường tương tự', 'rt'); ?></h3>
            <a href="<?= \RT\Core\School\SchoolFunctions::getSetting('url'); ?>" class="view-all">
                <?= __('Xem thêm', 'rt'); ?>
            </a>
        </div>
        <div class="rt-school__list--posts">
            <?php
                foreach($posts as $post) {
                    get_template_part('template-parts/school/loop', null, $post);
                }
            ?>
        </div>
    </div>
</section>
<?php endif; ?>