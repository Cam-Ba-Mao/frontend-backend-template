<?php
$custom_logo_id = get_theme_mod( 'custom_logo' );
$logoUrl = wp_get_attachment_image_url( $custom_logo_id , 'full' );
$mainMenu = iedg_get_menu_data('main-menu');
if( is_array($mainMenu) && count($mainMenu) > 0 ) {
    _wp_menu_item_classes_by_context( $mainMenu );
    $mainMenu = recursiveMenu($mainMenu);
}
// dd($mainMenu,false,false);
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/html/dist/js/jquery.min.js"><\/script>')</script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="iedg-container">
		
		<!-- START HEADER-->
		<header class="iedg-header iedg-header-transparents">
			<nav class="iedg-navbar js-iedg-navbar is-active">
				<div class="container">
					<div class="iedg-header-navbar-content">
						<a class="iedg-navbar-brand d-lg-none" href="<?= home_url(); ?>">
							<img class="iedg-navbar-brand__black lazy" data-src="<?= $logoUrl; ?>" alt="<?= sanitize_title(get_bloginfo( 'name' )); ?>">
						</a>
						<div class="iedg-navbar-hamburger">
							<div class="iedg-nav-language-mobile d-lg-none"> 
								<a href="#" id="iedg-language-mobile">
									<img class="lazy" data-src="<?php echo get_template_directory_uri(); ?>/html/dist/images/language-<?= pll_current_language(); ?>.png" alt="<?= pll_current_language(); ?>">
									<span class="iedg-submenu-expand">
										<svg role="img">
											<use xlink:href="#icon-arrow-menu"></use>
										</svg></span></a>
								<ul class="sub-menu">
									<?php pll_the_languages(['show_flags' => 0, 'display_names_as' => 'slug', 'hide_current' => 1]); ?>
								</ul>
							</div>
							<button class="iedg-navbar-toggler" type="button">
								<div class="iedg-icon-toggler"><span></span></div>
							</button>
						</div>
					</div>
					<div class="iedg-navbar-collapse">
						<div class="container">
							<div class="iedg-navbar-wrap">
								<a class="iedg-navbar-brand d-none d-lg-block" href="<?= home_url(); ?>">
									<img class="iedg-navbar-brand__black lazy" data-src="<?= $logoUrl; ?>" alt="<?= sanitize_title(get_bloginfo( 'name' )); ?>">
								</a>
								
								<ul class="iedg-navbar-nav">
								<?php if( is_array($mainMenu) && count($mainMenu) > 0 ): ?>
									<?php foreach($mainMenu as $key => $menu): ?>
									<li class="iedg-navbar-nav__item <?= is_array($menu->classes) && count($menu->classes) > 0 ? implode(' ', $menu->classes) : ''; ?>">
										<a href="<?= $menu->url; ?>"><?= $menu->title; ?></a>
										
										<ul class="sub-menu">
										<?php foreach($menu->children as $menu_child): ?>
											<li class="iedg-navbar-nav__item"> <a href="<?= $menu_child->url; ?>"><?= $menu_child->title; ?></a></li>
										<?php endforeach; ?>
										</ul>
										
									</li>
									<?php endforeach; ?>
								<?php endif; ?>
									<li class="iedg-navbar-nav__item iedg-nav-icon iedg-nav-none-border iedg-nav-language"> 
										<a href="#">
											<img class="lazy" data-src="<?php echo get_template_directory_uri(); ?>/html/dist/images/language-<?= pll_current_language(); ?>.png" alt="<?= pll_current_language(); ?>">
											<span class="iedg-submenu-expand">
												<svg role="img">
													<use xlink:href="#icon-arrow-menu"></use>
												</svg>
											</span>
										</a>
										<ul class="sub-menu">
											
											<?php pll_the_languages(['show_flags' => 0, 'display_names_as' => 'slug', 'hide_current' => 1]); ?>
										</ul>
									</li>
									<li class="iedg-navbar-nav__item iedg-navbar-nav__item--login">
										<a class="iedg-btn iedg-btn-outline-primary" href="#register">Đăng ký ngay</a>
									</li>
								</ul>
								
							</div>
						</div>
					</div>
				</div>
			</nav>
		</header>
		<!-- CLOSE HEADER-->
		
		<!-- START CONTENT-->
        <main class="iedg-content">