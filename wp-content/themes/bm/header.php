<?php
$options = RT\Core\Common\Options::getOption();
$logoId = get_theme_mod('custom_logo');
$logoUrl = wp_get_attachment_image_url($logoId, 'full');
$whiteUrl = get_theme_mod('footer_logo');
$lang = pll_current_language();

$search_action = site_url('/');
$mainMenu = iedg_get_menu_data('main-menu');

if (is_array($mainMenu) && count($mainMenu) > 0) {
    $mainMenu = recursiveMenu($mainMenu);
    $mainMenu = _iedg_menu_item_classes_by_context($mainMenu);
}

$lang = get_locale() == 'vi' ? 'vi' : 'en';
$color_cart = is_front_page() ? 'white' : 'black';
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
            <div class="container">
                <div class="rt-header__wrap">
                    <div class="rt-header__head">
                        <div class="rt-header__left">
                            <?php if ($logoUrl) : ?>
                            <div class="rt-header__brand">
                                <a href="<?= home_url(); ?>">
                                    <img src="<?= $logoUrl; ?>" alt="<?= get_bloginfo('name'); ?>">
                                </a>
                            </div>
                            <?php endif; ?>

                            <div class="rt-header__hamburger">
                                <button class="btn" data-label="Menu" data-close="<?php _e('Đóng', 'rt'); ?>">
                                    <span>Menu</span>
                                </button>
                            </div>
                        </div>

                        <?php if (is_array($mainMenu) && count($mainMenu) > 0) : ?>
                        <div class="rt-header__nav">
                            <ul class="rt-header__nav--items">
                                <?php foreach ($mainMenu as $key => $menu) : ?>
                                    <li class="<?= is_array($menu->classes) && count($menu->classes) > 0 ? implode(' ', $menu->classes) : ''; ?>">
                                        <a target="<?= $menu->target; ?>" href="<?= $menu->url; ?>"><?= $menu->title; ?></a>
                                        <?php if (isset($menu->children) && is_array($menu->children) && count($menu->children) > 0) : ?>
                                            <ul class="sub-menu">
                                                <?php foreach ($menu->children as $menu_child) : ?>
                                                    <li class="<?= is_array($menu_child->classes) && count($menu_child->classes) > 0 ? implode(' ', $menu_child->classes) : ''; ?>">
                                                        <a href="<?= $menu_child->url; ?>" target="<?= $menu_child->target; ?>"><?= $menu_child->title; ?></a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <?php if( isset($options['general_register_for_consultation_' . $lang]['title']) ): ?>
                            <hr>
                            <div class="rt-header__nav--cta">
                                <a class="btn" href="<?= $options['general_register_for_consultation_' . $lang]['url']; ?>" target="<?= $options['general_register_for_consultation_' . $lang]['target']; ?>">
                                    <span><?= $options['general_register_for_consultation_' . $lang]['title']; ?></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M11.5 19C11.5 19.276 11.276 19.5 11 19.5H5C2.71 19.5 1.5 18.29 1.5 16V7C1.5 4.71 2.71 3.5 5 3.5H17C19.29 3.5 20.5 4.71 20.5 7V10C20.5 10.276 20.276 10.5 20 10.5C19.724 10.5 19.5 10.276 19.5 10V7C19.5 5.271 18.729 4.5 17 4.5H5C3.271 4.5 2.5 5.271 2.5 7V16C2.5 17.729 3.271 18.5 5 18.5H11C11.276 18.5 11.5 18.724 11.5 19ZM16.9041 7.70599C16.7411 7.48199 16.4271 7.43399 16.2061 7.59599L11.2939 11.168C11.1179 11.296 10.8821 11.295 10.7061 11.168L5.79395 7.59599C5.57095 7.43399 5.25895 7.48199 5.09595 7.70599C4.93395 7.92899 4.98305 8.24201 5.20605 8.40401L10.1179 11.976C10.3819 12.168 10.69 12.264 11 12.264C11.309 12.264 11.6181 12.168 11.8821 11.976L16.7939 8.40401C17.0179 8.24201 17.0661 7.92899 16.9041 7.70599ZM22.5 14.881C22.499 15.253 22.3541 15.601 22.0911 15.863L16.575 21.354C16.481 21.447 16.3539 21.5 16.2219 21.5H14C13.724 21.5 13.5 21.276 13.5 21V18.778C13.5 18.646 13.553 18.519 13.646 18.425L19.137 12.909C19.399 12.645 19.7479 12.5 20.1189 12.5C20.1199 12.5 20.1201 12.5 20.1211 12.5C20.4911 12.5 20.8401 12.645 21.1021 12.907L22.092 13.898C22.355 14.16 22.5 14.51 22.5 14.881ZM19.864 16.67L18.3311 15.136L14.5 18.984V20.5H16.0171L19.864 16.67ZM21.5 14.88C21.5 14.776 21.459 14.678 21.386 14.605L20.396 13.614C20.323 13.54 20.2251 13.5 20.1221 13.5H20.1211C20.0171 13.5 19.9199 13.541 19.8469 13.614L19.0381 14.427L20.574 15.964L21.387 15.154C21.459 15.081 21.5 14.984 21.5 14.88Z" fill="white"/>
                                    </svg>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="rt-header__language">
                        <div class="dropdown iedg-navbar-language">
                            <button class="dropdown-toggle" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false" href="#">
                                <img class="lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/language-<?= pll_current_language(); ?>.png" alt="">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <?php pll_the_languages(['show_flags' => 0, 'display_names_as' => 'slug', 'hide_current' => 1]); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- CLOSE HEADER-->

        <!-- START CONTENT-->
        <main class="rt-content">