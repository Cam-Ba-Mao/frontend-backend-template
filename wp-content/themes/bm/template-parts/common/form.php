<?php
    $form_data = RT\Core\Common\Options::getOption();
    $lang = pll_current_language();
?>
<?php if( !empty($form_data["general_scholarship_form_title_" . $lang]) ): ?>
<section class="rt-form" id="registForm">
    <div class="rt-form__inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-6">
                    <?php if( !empty($form_data["general_scholarship_form_image_" . $lang]['url']) ): ?>
                    <div class="img-wrapper">
                        <img class="lazy" data-src="<?= $form_data["general_scholarship_form_image_" . $lang]['url']; ?>" alt="<?= $form_data["general_scholarship_form_image_" . $lang]['alt']; ?>">
                        <div class="rt-form__lines">
                            <div class="line line-pink"><img class="lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/single/pink-line.svg" alt=""></div>
                            <div class="line line-blue"><img class="lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/single/blue-line.svg" alt=""></div>
                            <div class="line line-yellow"><img class="lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/single/yellow-line.svg" alt=""></div>
                            <div class="line line-purple"><img class="lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/single/purple-line.svg" alt=""></div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="d-none d-xl-block col-xl-auto"></div>
                <div class="col-lg-6 col-xl-5">
                    <div class="rt-form__form">
                        <h2 class="rt-title"><?= $form_data["general_scholarship_form_title_" . $lang]; ?></h2>
                        <?php if( !empty($form_data["general_scholarship_form_desc_" . $lang]) ): ?>
                        <h3 class="rt-subtitle"><?= $form_data["general_scholarship_form_desc_" . $lang]; ?></h3>
                        <?php endif; ?>
                        <?php if( !empty($form_data["general_scholarship_form_" . $lang]) ): ?>
                        <?= do_shortcode('[wpforms id="' . $form_data["general_scholarship_form_" . $lang] . '"]'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif;