<?php
$options = RT\Core\Common\Options::getOption();
$logoId = get_theme_mod('custom_logo');
$logoUrl = wp_get_attachment_image_url($logoId, 'full');
$whiteUrl = get_theme_mod('footer_logo');
$lang = 'en'; // get_locale()
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script>
        window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/html/dist/js/jquery.min.js"><\/script>')
    </script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div class="rt-container">
        <!-- START HEADER-->
        <header class="rt-header">
            <?php do_action('before_header'); ?>
            <div class="container">
                <div class="rt-header__inner">
                    <?php if ($logoUrl): ?>
                        <div class="rt-header__logo">
                            <a href="<?= home_url(); ?>" title="<?= get_bloginfo('name'); ?>">
                                <img src="<?= $logoUrl ?>" alt="<?= get_bloginfo('name'); ?>">
                            </a>
                        </div>
                    <?php endif; ?>

                    <?= wp_nav_menu([
                        'theme_location' => 'main-menu',
                        'menu_class' => 'rt-navbar-nav',
                        'container_class' => 'rt-header__menu d-none d-lg-block',
                    ]); ?>

                    <div class="rt-header__controls">
                        <div class="icons">
                            <button class="rt-icon icon-search" type="button" aria-label="Search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                                    <path d="M11.9167 20.5833C16.7031 20.5833 20.5833 16.7031 20.5833 11.9167C20.5833 7.1302 16.7031 3.25 11.9167 3.25C7.1302 3.25 3.25 7.1302 3.25 11.9167C3.25 16.7031 7.1302 20.5833 11.9167 20.5833Z" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M23.9957 22.75L19.2832 18.0375" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <?php if (!empty($options['menu_cta']) && !empty($options['menu_cta']['url'])): ?>
                            <div class="buttons">
                                <a class="rt-btn d-none d-md-block btn-primary" href="<?= $options['menu_cta']['url']; ?>"><?= $options['menu_cta']['title']; ?></a>
                            </div>
                        <?php endif; ?>
                        <div class="rt-header__toggler d-lg-none">
                            <div class="rt-header__toggler--icon"><span></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="rt-header__bottom d-lg-none">
            <?= wp_nav_menu([
                'theme_location' => 'main-menu',
                'menu_class' => 'rt-navbar-nav',
                'container_class' => 'rt-header__bottom--wrap',
            ]); ?>
        </div>
        <!-- CLOSE HEADER-->
        <!-- START CONTENT-->
        <main class="rt-content">