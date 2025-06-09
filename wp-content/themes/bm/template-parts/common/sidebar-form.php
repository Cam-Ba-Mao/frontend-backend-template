<?php
    $options = RT\Core\Common\Options::getOption();
    $lang = pll_current_language();
?>
<?php if(empty($options['general_sidebar_form_hide_'.$lang]) and ! empty($options['general_sidebar_form_id_'.$lang])) : ?>
<div id="rt-details__form" class="rt-details__form">
    <div class="rt-details__form--inner">
        <div class="rt-details__form--head">
            <?php if(! empty($options['general_sidebar_form_note_'.$lang])) : ?>
            <h2 class="rt-subtitle"><?= $options['general_sidebar_form_note_'.$lang]; ?></h2>
            <div class="rt-details__head--border"></div>
            <?php endif; ?>
            <?php if(! empty($options['general_sidebar_form_title_'.$lang])) : ?>
            <h2 class="rt-title rt-title__medium"><?= $options['general_sidebar_form_title_'.$lang]; ?></h2>
            <?php endif; ?>
        </div>
        <div class="rt-details__form--body">
            <?= do_shortcode('[wpforms id="'.$options['general_sidebar_form_id_'.$lang].'"]'); ?>
        </div>
    </div>
</div>
<?php endif; ?>