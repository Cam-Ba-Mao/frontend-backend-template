<?php

namespace BM\Core\School;

use \BM\Core\School\SchoolFunctions as Helper;

class SchoolHook
{
    const slug = 'truong';
    const module = 'school';
    
    /**
     * @param: void
     */
    public static function init()
    {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->setupAction();
        }

        return $init;
    }

    /**
     * @param: void
     */
    private function setupAction()
    {
        add_action('init', [$this, 'registerPostType']);
        add_action('init', [$this, 'registerTaxonomy']);
        
        add_action('wp_ajax_rt_school_loaddata', [$this, 'ajaxLoadData']);
        add_action('wp_ajax_nopriv_rt_school_loaddata', [$this, 'ajaxLoadData']);
        add_action('wp_ajax_rt_school_country_change', [$this, 'ajaxCountryChange']);
        add_action('wp_ajax_nopriv_rt_school_country_change', [$this, 'ajaxCountryChange']);
        
        add_action('init', [$this, 'rewriteRuleTaxonomy']);
        add_filter('term_link', [$this, 'linkTaxonomy'], 999);
        add_filter('pll_the_language_link', [$this, 'linkTaxonomy']);
        add_action('template_redirect', [$this, 'redirectTaxonomy']);
    }

    /**
     * @param: void
     */
    public static function registerPostType()
    {
        $args = [
            'supports' => [
                'title',
                'editor',
                'thumbnail',
                'excerpt',
            ],
            'labels' => [
                'name' => 'Schools',
                'singular_name' => 'Schools',
                'menu_name' => 'Schools',
                'name_admin_bar' => 'Schools',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New School',
                'new_item' => 'New School',
                'edit_item' => 'Edit School',
                'view_item' => 'View School',
                'all_items' => 'All Schools',
                'search_items' => 'Search School',
                'not_found' => 'No School Found.',
            ],
            'public' => true,
            'show_in_rest' => true,
            'query_var' => true,
            'has_archive' => false,
            'hierarchical' => true,
            'publicly_queryable' => true,
            'rewrite' => ['slug' => self::slug],
            'menu_icon' => 'dashicons-building'
        ];

        register_post_type(self::module, $args);
    }

    /**
     * @param: void
     */
    public static function registerTaxonomy() {
        register_taxonomy( self::module.'_type', self::module, array(
            'hierarchical' => true,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => self::module.'-type' ),
            'labels' => array(
                'name' => 'School Type',
                'singular_name' => 'School Type',
                'search_items' => 'Search School Type',
                'all_items' => 'All School Type',
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => 'Edit School Type',
                'update_item' => 'Update School Type',
                'add_new_item' => 'Add New School Type',
                'new_item_name' => 'School Type',
                'menu_name' => 'School Type',
            ),
        ));

        register_taxonomy( self::module.'_country_state', self::module, array(
            'hierarchical' => true,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => __('tim-truong', 'rt') ),
            'labels' => array(
                'name' => 'Country & State',
                'singular_name' => 'Country & State',
                'search_items' => 'Search Country & State',
                'all_items' => 'All Country & State',
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => 'Edit Country & State',
                'update_item' => 'Update Country & State',
                'add_new_item' => 'Add New Country & State',
                'new_item_name' => 'Country & State',
                'menu_name' => 'Country & State',
            ),
        ));
    }

    /**
     * @param: void
     */
    public static function rewriteRuleTaxonomy()
    {
        add_rewrite_rule('en/school-search/([^/]*)/?','index.php?school_country_state=$matches[1]','top');
    }

    /**
     * @param: void
     */
    public static function redirectTaxonomy()
    {
        global $wp;
        $link = home_url($wp->request);
        if(strpos($link, '/en/tim-truong/')) {
            $link = str_replace('/en/tim-truong/', '/en/school-search/', $link);
            wp_redirect($link); exit;
        }
    }

    /**
     * @param: string $link
     */
    public static function linkTaxonomy($link)
    {
        if(strpos($link, '/en/tim-truong/')) {
            $link = str_replace('/en/tim-truong/', '/en/school-search/', $link);
        }
        return $link;
    }

    /**
     * @param: void
     */
    public static function ajaxLoadData()
    {
        $redirect = '';
        $loadmore = '';
        $posts = \BM\Core\School\SchoolFunctions::getSchools();
        $count = \BM\Core\School\SchoolFunctions::getSchoolsCount();
        if($count and $posts) {
            foreach($posts as $i => $post) {
                ob_start();
                get_template_part('template-parts/school/loop', null, $post);
                $posts[$i] = ob_get_clean();
            }

            ob_start();
            get_template_part('template-parts/school/loadmore');
            $loadmore = ob_get_clean();
        }
        else {
            ob_start();
            get_template_part('template-parts/school/empty');
            $posts[] = ob_get_clean();
        }

        wp_send_json([
            'success' => true,
            'results' => array(
                'posts' => $posts,
                'count' => $count,
                'redirect' => $redirect,
                'loadmore' => $loadmore,
            ),
        ]);
        exit;
    }

    /**
     * @param: void
     */
    public static function ajaxCountryChange()
    {
        $label = pll__('Danh sách trường');
        $redirect = Helper::getSetting('url');
        $country_slug = isset($_POST['country']) ? $_POST['country'] : 0;
        $country = Helper::getSchoolCountry($country_slug);
        if(isset($country->link)) {
            $label = $country->label;
            $redirect = $country->link;
        }
        $schoolStates = Helper::getSchoolStates($country_slug);
        $states = Helper::fillterBox([
            'name' => 'state',
            'terms' => $schoolStates,
            'label' => pll__('Chọn Tỉnh bang/Thành phố'),
        ]);
        wp_send_json([
            'success' => true,
            'results' => array(
                'label' => $label,
                'states' => $states,
                'redirect' => $redirect,
                'country' => $country,
            ),
        ]);
    }

} // End Class