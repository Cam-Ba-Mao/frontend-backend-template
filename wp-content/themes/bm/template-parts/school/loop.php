<?php if(! empty($args->ID)) : $ID = $args->ID; ?>
<a class="rt-school__post" href="<?= get_the_permalink($ID); ?>">
    <div class="rt-school__post--image">
        <div class="rt-school__post--image__large">
            <img class="lazy" data-src="<?= get_the_post_thumbnail_url($ID, 'rt_blog_large'); ?>" alt="<?= get_the_title($ID); ?>">
        </div>
        <?php if(! empty(get_field('school_logo', $ID)['url']) and isset(get_field('school_logo', $ID)['alt'])) : ?>
        <div class="rt-school__post--image__small">
            <img class="school-logo lazy" data-src="<?= get_field('school_logo', $ID)['url']; ?>" alt="<?= get_field('school_logo', $ID)['alt']; ?>">
        </div>
        <?php endif; ?>
    </div>
    <div class="rt-school__post--entry">
        <h3 class="rt-school__post--title"><?= get_the_title($ID); ?></h3>
        <ul class="rt-school__post--meta">
            <?php if($schoolCountry = \RT\Core\School\SchoolFunctions::getSchoolCountryByPostId($ID, 'name')) : ?>
            <li>
                <span><?= pll__('Quốc gia'); ?></span>
                <strong><?= $schoolCountry; ?></strong>
            </li>
            <?php if($schoolState = \RT\Core\School\SchoolFunctions::getSchoolStateByPostId($ID, 'name')) : ?>
            <li>
                <span><?= pll__('Tỉnh bang/Thành phố'); ?></span>
                <strong><?= $schoolState; ?></strong>
            </li>
            <?php endif; ?>
            <?php endif; ?>
            <?php if($schoolTypes = \RT\Core\School\SchoolFunctions::getSchoolTypeByPostId($ID, 'name')) : ?>
            <li>
                <span><?= pll__('Bậc học'); ?></span>
                <strong><?= $schoolTypes; ?></strong>
            </li>
            <?php endif; ?>
            <?php if($schoolFee = \RT\Core\School\SchoolFunctions::getSchoolFeeByPostId($ID)) : ?>
            <li>
                <span><?= pll__('Học phí tham khảo'); ?></span>
                <strong><?= $schoolFee; ?></strong>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</a>
<?php endif; ?>