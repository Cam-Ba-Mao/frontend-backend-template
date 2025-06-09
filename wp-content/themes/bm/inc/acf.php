<?php
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title'  => __('General Settings'),
		'menu_title'  => __('General Settings'),
		'menu_slug' 	=> 'theme-general-settings',
		'redirect'    => false,
	));

	acf_add_options_page(array(
		'page_title'  => __('Vietnamese Settings'),
		'menu_title'  => __('Vietnamese Settings'),
		'parent_slug' => 'theme-general-settings',
		'menu_slug'  => 'theme-general-setting-vi',
	));

	acf_add_options_page(array(
		'page_title'  => __('English Settings'),
		'menu_title'  => __('English Settings'),
		'parent_slug' => 'theme-general-settings',
		'menu_slug'  => 'theme-general-setting-en',
	));
}