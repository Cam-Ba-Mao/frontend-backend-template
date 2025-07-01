<?php
$options = RT\Core\Common\Options::getOption();
?>
<?php if ($options['top_bar_visible'] && (!empty($options['top_bar_title']) || !empty($options['top_bar_cta']))): ?>
    <section class="rt-topbar">
        <?php if (!empty($options['top_bar_title'])): ?>
            <span><?= $options['top_bar_title']; ?></span>
        <?php endif; ?>

        <?php if (!empty($options['top_bar_cta']) && !empty($options['top_bar_cta']['title']) && !empty($options['top_bar_cta']['url'])): ?>
            <a class="rt-btn btn-primary" href="<?= $options['top_bar_cta']['url']; ?>"><?= $options['top_bar_cta']['title']; ?></a>
        <?php endif; ?>
    </section>
<?php endif; ?>