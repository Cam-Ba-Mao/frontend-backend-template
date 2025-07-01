<?php
$options = RT\Core\Common\Options::getOption();
$logoUrl = get_theme_mod('footer_logo');
$desc = $options['site_desc'];
$socials = $options['social_channels'];
$platforms = $options['platform'];
$hotline = $options['hotline'];
$footerMenu = iedg_get_menu_data('footer-menu');

if (is_array($footerMenu) && count($footerMenu) > 0) {
    $footerMenu = recursiveMenu($footerMenu);
}
?>
</main>

<!-- START FOOTER-->
<footer class="gobs-footer">
    <div class="container">
        <div class="gobs-footer__row">
            <div class="gobs-footer__col">
                <?php if (!empty($logoUrl)): ?>
                    <div class="gobs-footer__logo">
                        <img src="<?= $logoUrl; ?>" alt="<?= get_bloginfo('name'); ?>">
                    </div>
                <?php endif; ?>
                <?php if (!empty($desc)): ?>
                    <div class="gobs-footer__desc"><?= $desc; ?></div>
                <?php endif; ?>
            </div>
            <?php if (is_array($footerMenu) && count($footerMenu) > 0) : ?>
                <div class="gobs-footer__col">
                    <div class="gobs-footer__links">
                        <ul>
                            <li class="menu-item-has-children">
                                <a href="#1"><?= __('PAGE', 'rt'); ?></a>
                                <ul class="sub-menu">
                                    <?php foreach ($footerMenu as $key => $menu) : ?>
                                        <li>
                                            <a href="<?= $menu->url; ?>"><?= $menu->title; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            <div class="gobs-footer__col">
                <?php if (!empty($socials) && is_array($socials)): ?>
                    <div class="gobs-footer__links">
                        <ul>
                            <li class="menu-item-has-children">
                                <a href="javascript:void(0);"><?= __('CONTACT', 'rt'); ?></a>
                                <ul class="sub-menu">
                                    <?php foreach ($socials as $channel): ?>
                                        <?php if (!empty($channel['link']) && !empty($channel['icon'])): ?>
                                            <li>
                                                <a href="<?= $channel['link']['url']; ?>" title="<?= $channel['link']['title']; ?>">
                                                    <img src="<?= $channel['icon']['url']; ?>" alt="<?= $channel['icon']['title']; ?>">
                                                    <span><?= $channel['link']['title']; ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($platforms) && is_array($platforms)): ?>
                    <div class="gobs-footer__social">
                        <?php foreach ($platforms as $platform): ?>
                            <?php if (!empty($platform['link']) && !empty($platform['icon'])): ?>
                                <a href="<?= $platform['link']['url']; ?>" title="<?= $platform['link']['title']; ?>" target="_blank">
                                    <img src="<?= $platform['icon']['url']; ?>" alt="<?= $platform['icon']['title']; ?>">
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="gobs-footer__bottom">
        <div class="container">
            <div class="gobs-footer__text"><?= sprintf('&copy; %s by %s. All rights reserved.', date('Y'), strtoupper(get_bloginfo('name'))); ?></div>
        </div>
    </div>
</footer>
<?php if (!empty($hotline)): ?>
    <div class="fixed_hotline">
        <a class="icon-phone" href="tel:<?= $hotline; ?>" target="_blank">
            <img src="<?= get_template_directory_uri(); ?>/html/dist/images/contact-phone.png" alt="<?= $hotline; ?>">
        </a>
    </div>
<?php endif; ?>
<!-- CLOSE FOOTER-->

<?php get_search_form(); ?>

</div>
<?php wp_footer(); ?>
</body>

</html>