<?php

namespace BM\Core\School;

class SchoolFunctions {
    /**
     * Get Schools
     *
     * @param int|array $catId
     * @param int $page
     * @param int $limit
     * @param array $except
     * @param array $in
     * @return object
     */
    public static function getSchools($catId = 0, $page = 1, $limit = 0, $except = [], $in = []) {
        if (empty($limit)) {
            $limit = self::getSetting('limit', 9);
        }

        if (empty($catId) and is_tax('school_country_state')) {
            $object = get_queried_object();
            $catId = isset($object->term_id) ? $object->term_id : 0;
        }

        $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

        $args = [
            'post_type' => 'school',
            'posts_per_page' => $limit,
            'paged' => $page,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'ignore_sticky_posts' => 1,
            'offset' => $offset,
        ];

        $tax_query = [];

        if ($catId) {
            array_push($tax_query, [
                'terms' => $catId,
                'field' => 'term_id',
                'taxonomy' => 'school_country_state',
            ]);
        }

        $country = isset($_POST['country']) ? strval($_POST['country']) : 0;
        if ($country) {
            array_push($tax_query, [
                'field' => 'slug',
                'terms' => $country,
                'taxonomy' => 'school_country_state',
            ]);
        }

        $state = isset($_POST['state']) ? strval($_POST['state']) : 0;
        if ($state) {
            array_push($tax_query, [
                'field' => 'slug',
                'terms' => $state,
                'taxonomy' => 'school_country_state',
            ]);
        }

        $type = isset($_POST['type']) ? strval($_POST['type']) : 0;
        if ($type) {
            array_push($tax_query, [
                'terms' => $type,
                'field' => 'slug',
                'taxonomy' => 'school_type',
            ]);
        }

        if ($tax_query) {
            $args['tax_query'] = $tax_query;
        }

        $meta_query = [];

        $fees = isset($_POST['fees']) ? strval($_POST['fees']) : 0;
        if ($fees and strpos($fees, '-')) {
            $fees = explode('-', $fees);
            $feeMin = intval(array_shift($fees));
            $feeMax = intval(array_shift($fees));

            if ('min' == $feeMin) {
                array_push($meta_query, [
                    'key'     => 'school_fee',
                    'value'   => 0,
                    'compare' => '>=',
                    'type' => 'NUMERIC',
                ], [
                    'key'     => 'school_fee',
                    'value'   => $feeMax,
                    'compare' => '<',
                    'type' => 'NUMERIC',
                ]);
            }
            elseif ('max' == $feeMax) {
                array_push($meta_query, [
                    'key'     => 'school_fee',
                    'value'   => $feeMin,
                    'compare' => '>',
                    'type' => 'NUMERIC',
                ]);
            }
            else {
                $meta_query = array_merge($meta_query, [
                    'relation' => 'AND',
                    [
                        'key'     => 'school_fee',
                        'value'   => $feeMin,
                        'compare' => '>=',
                        'type' => 'NUMERIC',
                    ], [
                        'key'     => 'school_fee',
                        'value'   => $feeMax,
                        'compare' => '<=',
                        'type' => 'NUMERIC',
                    ]
                ]);
            }
        }

        if ($meta_query) {
            $args['meta_query'] = $meta_query;
        }

        if (is_array($except) and count($except) > 0) {
            $args['post__not_in'] = $except;
        }

        if (is_array($in) and count($in) > 0) {
            $args['post__in'] = $in;
        }

        $query = new \WP_Query($args);

        return $query->posts;
    }

    /**
     * @param: int $ID
     * @param: int $limit
     */
    public static function getSchoolsRelated($post_id = 0, $limit = 3)
    {
        $catId = wp_get_post_terms($post_id, 'school_country_state', ['ids']);
        if($catId) {
            $catId = end($catId);
        }
        return self::getSchools($catId, 1, $limit, [$post_id]);
    }

    /**
     * Get Schools
     *
     * @param int|array $catId
     * @param int $page
     * @param int $limit
     * @param array $except
     * @param array $in
     * @return int School Count
     */
    public static function getSchoolsCount($catId = 0, $page = 1, $limit = 0, $except = [], $in = []) {
        $args = [
            'post_type' => 'school',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
        ];

        $tax_query = [];

        if (empty($catId) and is_tax('school_country_state')) {
            $object = get_queried_object();
            $catId = isset($object->term_id) ? $object->term_id : 0;
        }

        if ($catId) {
            array_push($tax_query, [
                'terms' => $catId,
                'field' => 'term_id',
                'taxonomy' => 'school_country_state',
            ]);
        }

        $country = isset($_POST['country']) ? strval($_POST['country']) : 0;
        if ($country) {
            array_push($tax_query, [
                'field' => 'slug',
                'terms' => $country,
                'taxonomy' => 'school_country_state',
            ]);
        }

        $state = isset($_POST['state']) ? strval($_POST['state']) : 0;
        if ($state) {
            array_push($tax_query, [
                'field' => 'slug',
                'terms' => $state,
                'taxonomy' => 'school_country_state',
            ]);
        }

        $type = isset($_POST['type']) ? strval($_POST['type']) : 0;
        if ($type) {
            array_push($tax_query, [
                'terms' => $type,
                'field' => 'slug',
                'taxonomy' => 'school_type',
            ]);
        }

        if ($tax_query) {
            $args['tax_query'] = $tax_query;
        }

        $meta_query = [];

        $fees = isset($_POST['fees']) ? strval($_POST['fees']) : 0;
        if ($fees and strpos($fees, '-')) {
            $fees = explode('-', $fees);
            $feeMin = intval(array_shift($fees));
            $feeMax = intval(array_shift($fees));

            if ('min' == $feeMin) {
                array_push($meta_query, [
                    'key'     => 'school_fee',
                    'value'   => 0,
                    'compare' => '>=',
                    'type' => 'NUMERIC',
                ], [
                    'key'     => 'school_fee',
                    'value'   => $feeMax,
                    'compare' => '<',
                    'type' => 'NUMERIC',
                ]);
            }
            elseif ('max' == $feeMax) {
                array_push($meta_query, [
                    'key'     => 'school_fee',
                    'value'   => $feeMin,
                    'compare' => '>',
                    'type' => 'NUMERIC',
                ]);
            }
            else {
                array_push($meta_query, [
                    'key'     => 'school_fee',
                    'value'   => $feeMin,
                    'compare' => '>=',
                    'type' => 'NUMERIC',
                ], [
                    'key'     => 'school_fee',
                    'value'   => $feeMax,
                    'compare' => '<=',
                    'type' => 'NUMERIC',
                ]);
            }
        }

        if ($meta_query) {
            $args['meta_query'] = $meta_query;
        }

        if (is_array($except) and count($except) > 0) {
            $args['post__not_in'] = $except;
        }

        if (is_array($in) and count($in) > 0) {
            $args['post__in'] = $in;
        }

        $query = new \WP_Query($args);

        return $query->found_posts;
    }

    /**
     * @param: array $args
     * @param: bool $hide_empty
     */
    public static function getSchoolFees()
    {
        $terms = array(
            (object) array(
                'name' => __('Dưới $15,000', 'rt'),
                'slug' => 'min-15000',
            ),
            (object) array(
                'name' => __('$15,000 - $30,000', 'rt'),
                'slug' => '15000-30000',
            ),
            (object) array(
                'name' => __('$30,000 - $45,000', 'rt'),
                'slug' => '30000-45000',
            ),
            (object) array(
                'name' => __('$45,000 - $60,000', 'rt'),
                'slug' => '45000-60000',
            ),
            (object) array(
                'name' => __('Trên $60,000', 'rt'),
                'slug' => '60000-max',
            )
        );

        return $terms;
    }

    /**
     * @param: array $args
     * @param: bool $hide_empty
     */
    public static function getSchoolTypes($args = [], $hide_empty = false)
    {
        $args = wp_parse_args($args, [
            'taxonomy' => 'school_type',
            'hide_empty' => $hide_empty,
        ]);

        return get_terms($args);
    }

    /**
     * @param: array $args
     * @param: bool $hide_empty
     */
    public static function getSchoolCountries($args = [], $hide_empty = false)
    {
        $args = wp_parse_args($args, [
            'parent' => 0,
            'hide_empty' => $hide_empty,
            'taxonomy' => 'school_country_state',
        ]);

        return get_terms($args);
    }

    /**
     * @param: int $country_slug
     * @param: bool $hide_empty
     */
    public static function getSchoolCountry($country_slug = 0, $field = null)
    {
        $taxonomy = 'school_country_state';
        $country = get_term_by('slug', $country_slug, $taxonomy);
        if (empty($country)) {
            $country = get_term($country_slug, $taxonomy);
        }
        if (isset($country->term_id)) {
            $country->link = get_term_link($country->term_id, $taxonomy);
            $country->label = sprintf(pll__('Danh sách trường %s'), $country->name);
        }
        return isset($country->$field) ? $country->$field : $country;
    }

    /**
     * @param: array $args
     * @param: bool $hide_empty
     */
    public static function getSchoolStates($country_slug = 0, $args = [], $hide_empty = false)
    {
        $terms = [];
        $taxonomy = 'school_country_state';
        $country = get_term_by('slug', $country_slug, $taxonomy);
        if (empty($country) and is_tax($taxonomy)) {
            $country = get_queried_object();
        }
        if (isset($country->term_id)) {
            $args = wp_parse_args($args, [
                'parent' => $country->term_id,
                'hide_empty' => $hide_empty,
                'taxonomy' => $taxonomy,
            ]);
            $terms = get_terms($args);
        }
        return $terms;
    }

    /**
     * @param: $num
     * @param: $sap
     */
    public static function numberToString($num, $sap = ',')
    {
        return strrev(substr(chunk_split(strrev($num), 3, $sap), 0, -1));
    }

    /**
     * @param: string $key
     * @param: mixed $default
     */
    public static function getSetting($key, $default = null)
    {
        $value = $default;
        $ID = get_page_id_by_template('page-templates/school.php');
        $page = get_post($ID);
        if (isset($page->ID) and $key) {
            switch (strtolower($key)) {
                default:
                    if (isset($page->$key)) {
                        $value = $page->$key;
                    } else {
                        $value = get_field($key, $ID);
                    }
                    break;
                case 'url':
                case 'link':
                    $value = get_the_permalink($ID);
                    break;
                case 'limit':
                case 'number':
                case 'showposts':
                case 'posts_per_page':
                    $key = 'school_posts_per_page';
                    $value = get_field($key, $ID);
                    break;
            }
        }
        return $value;
    }

    /**
     * @param: array $args
     */
    public static function fillterBox($args = [])
    {
        $args = array_merge([
            'name' => '',
            'value' => '',
            'terms' => '',
            'label' => '',
            'button' => '',
            'hide_empty' => true,
        ], $args);

        $data = (object) $args;

        ob_start();
        get_template_part('template-parts/school/filter-box', null, $data);
        return ob_get_clean();
    }

    /**
     * @param: int $term_id
     * @param: string $field
     */
    public static function getSchoolType($term_id = 0, $field = null)
    {
        $term = get_term($term_id, 'school_type');
        return isset($term->$field) ? $term->$field : $term;
    }

    /**
     * @param: int $post_id
     * @param: string $unit
     */
    public static function getSchoolFeeByPostId($post_id = 0, $unit = '$')
    {
        $output = pll__('Liên hệ');
        $fee = get_field('school_fee', $post_id);
        if ($fee and $unit) {
            $fee = self::numberToString($fee);
            $output = sprintf('%s%s', $unit, $fee);
        }
        return $output;
    }

    /**
     * @param: int $post_id
     * @param: string $field
     */
    public static function getSchoolTypeByPostId($post_id = 0, $field = null)
    {
        $output = '';
        $terms = wp_get_post_terms($post_id, 'school_type');
        if ($terms) {
            $output = $terms;
            if ('name' == $field) {
                $terms = array_map(function ($term) {
                    return $term->name;
                }, $terms);
                $output = implode(', ', $terms);
            }
        }
        return $output;
    }

    /**
     * @param: int $post_id
     * @param: string $unit
     */
    public static function getSchoolCountryByPostId($post_id = 0, $field = null)
    {
        $output = '';
        $taxonomy = 'school_country_state';
        $terms = wp_get_post_terms($post_id, $taxonomy);
        if ($terms) {
            $output = $terms;
            if ('name' == $field) {
                $terms = array_map(function ($term) {
                    return empty($term->parent) ? $term->name : '';
                }, $terms);
                $terms = array_filter($terms);
                $output = implode(', ', $terms);
            }
        }
        return $output;
    }

    /**
     * @param: int $post_id
     * @param: string $unit
     */
    public static function getSchoolStateByPostId($post_id = 0, $field = null)
    {
        $output = '';
        $terms = wp_get_post_terms($post_id, 'school_country_state');
        if ($terms) {
            $output = $terms;
            if ('name' == $field) {
                $terms = array_map(function ($term) {
                    return ($term->parent) ? $term->name : '';
                }, $terms);
                $terms = array_filter($terms);
                $output = implode(', ', $terms);
            }
        }

        return $output;
    }

} // End class