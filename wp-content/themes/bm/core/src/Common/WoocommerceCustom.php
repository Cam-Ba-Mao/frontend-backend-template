<?php

namespace BM\Core\Common;

class WoocommerceCustom
{
    public static function init()
    {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->setupAction();
            $init->setupFilter();
        }

        return $init;
    }

    private function setupAction()
    {
        /**
         * ------------------------------------------------------------------------------------------------
         * Ajax add to cart
         * ------------------------------------------------------------------------------------------------
         */
        add_action("wp_ajax_pennacademy_add_to_cart", [$this, "ajaxAddToCart"]);
        add_action("wp_ajax_nopriv_pennacademy_add_to_cart", [$this, "ajaxAddToCart"]);

        // Custom columns product dashboard
        add_action('manage_product_posts_custom_column' , [$this, 'extraProductColumnDetail'], 10, 2);

        // Custom url course cat
        // add_action( 'init', [$this, 'addRewriteRuleProductCategoryIntro']);

        // Remove breadcrumb product single
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb' , 20 );
        
        // Add breadcrumb product single
        add_action( 'woocommerce_before_main_content', [$this, 'customBreadcrumb'] , 30 );

        add_action( 'comment_form_top', [$this, 'customCommentFormTop'], 10);

        add_action( 'pennacademy_related_products', 'woocommerce_output_related_products', 10 );

        add_action( 'comment_post', [$this, 'saveCommentRating'] );

        add_action('woocommerce_product_query', [$this, 'customProductQuery'], 10, 2);

        remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);

        // Checkout page
        remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10);
        remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
        remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);
        
    }

    private function setupFilter()
    {
        // Add columns on product in admin
        add_filter('manage_edit-product_columns' , [$this, 'extraProductColumn']);

        // Disable style woocommerce frontend
        add_filter('woocommerce_enqueue_styles', '__return_empty_array');     

        // 
        add_filter('woocommerce_output_related_products_args', [$this, 'customOutputRelatedProductsArgs']);
        
        /**
        * ------------------------------------------------------------------------------------------------
        * Comment
        * ------------------------------------------------------------------------------------------------
        */
        add_filter( 'comment_form_fields', [$this, 'moveCommentFieldToBottom'] );

        add_filter( 'woocommerce_product_query_tax_query', [$this, 'customWoocommerceProductQueryTaxQuery'], 10, 2 );
        add_filter( 'woocommerce_product_query_meta_query', [$this, 'customWoocommerceProductQueryMetaQuery'], 10, 2 );

        /**
         * ------------------------------------------------------------------------------------------------
         * Cart fragment
         * ------------------------------------------------------------------------------------------------
         */
        add_filter('woocommerce_add_to_cart_fragments', [$this, 'customCartFragment']);

        // Checkout field
        add_filter( 'woocommerce_checkout_fields', [$this, 'customOverrideCheckoutFields']);
        add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 99 );
    }

    function extraProductColumn($columns) 
    {
        $columns['open_date'] = 'Open Date';
        return $columns;
    }
    
    function extraProductColumnDetail($column, $post_id ) 
    {
        if ( $column == 'open_date' ) {
            echo get_field('open_day', $post_id);
        }
    }

    public static function addRewriteRuleProductCategoryIntro( $wp_rewrite ) 
    {
        add_rewrite_tag("%target%", "([a-z\-_]+)");
        add_rewrite_rule('^course-category/(.+?)/'. __('gioi-thieu', 'pennacademy') .'/?$','index.php?product_cat=$matches[1]&target=intro','top');
        add_rewrite_rule('^course-category/(.+?)/'. __('lich-khai-giang', 'pennacademy') .'/?$','index.php?product_cat=$matches[1]&target=schedule','top');
        add_rewrite_rule('^course-category/(.+?)/'. __('lich-khai-giang', 'pennacademy') .'/page/(.+?)/?$','index.php?product_cat=$matches[1]&target=schedule&page=$matches[2]','top');
    }

    function customBreadcrumb() {
        get_template_part('template-parts/common/breadcrumb');
    }

    function moveCommentFieldToBottom( $fields ) 
    {
       $comment_field = $fields['comment'];
        unset( $fields['comment'] );

        $fields['comment'] = $comment_field;
        return $fields;
    }

    function customCommentFormTop() {
        if( wc_review_ratings_enabled() && is_singular( 'product' ) ) {
            echo '<p class="comment-reply-desc">' . sprintf( __( 'Bạn đang nhận xét và đánh giá cho khóa học "%s"', 'pennacademy' ), get_the_title() ) . '</p>';

            echo 
            '<div class="comment-form-rating">
                <select name="rating" id="rating" required>
                    <option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
                    <option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
                    <option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
                    <option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
                    <option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
                    <option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
                </select>
            </div>';
        } if( wc_review_ratings_enabled() && is_singular( 'post' ) ) {
            echo '<p class="comment-reply-desc">' . sprintf( __( 'Bạn đang nhận xét và đánh giá cho bài viết "%s"', 'pennacademy' ), get_the_title() ) . '</p>';

            echo 
            '<div class="comment-form-rating">
                <select name="rating" id="rating" required>
                    <option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
                    <option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
                    <option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
                    <option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
                    <option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
                    <option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
                </select>
            </div>';
        }
    }

    function customOutputRelatedProductsArgs($args) {
        $args['posts_per_page'] = 4;
        return $args;
    }

    function saveCommentRating($comment_id) {
        if( isset($_POST['rating']) && !empty($_POST['rating']) ) {
            update_comment_meta($comment_id, 'rating', $_POST['rating']);
        }
    }

    function customProductQuery($q, $instance) 
    {
        if(isset($_GET['key'])) {
            $q->set( '_meta_or_title', $_GET['key'] );
        }
    }

    function customWoocommerceProductQueryTaxQuery( $taxQuery, $instance) 
    {
        $tax_query = [];

        $cat_filter = isset($_GET['cat']) && !empty($_GET['cat']) ? explode(',', $_GET['cat']) : [];
        $duration_filter = isset($_GET['duration']) && !empty($_GET['duration']) ? explode(',', $_GET['duration']) : [];
        $level_filter = isset($_GET['level']) && !empty($_GET['level']) ? explode(',', $_GET['level']) : [];
        $teacher_filter = isset($_GET['teacher']) && !empty($_GET['teacher']) ? explode(',', $_GET['teacher']) : [];

        if( is_array($cat_filter) && count($cat_filter) > 0 ) {
            array_push($tax_query, [
                'taxonomy' => 'product_cat',
                'terms' => $cat_filter,
                'field' => 'slug',
                'operator' => 'IN'
            ]);
        }

        if( is_array($duration_filter) && count($duration_filter) > 0 ) {
            array_push($tax_query, [
                'taxonomy' => 'pa_course-duration',
                'terms' => $duration_filter,
                'field' => 'slug',
                'operator' => 'IN'
            ]);
        }

        if( is_array($level_filter) && count($level_filter) > 0 ) {
            array_push($tax_query, [
                'taxonomy' => 'pa_level',
                'terms' => $level_filter,
                'field' => 'slug',
                'operator' => 'IN'
            ]);
        }

        if( is_array($teacher_filter) && count($teacher_filter) > 0 ) {
            array_push($tax_query, [
                'taxonomy' => 'pa_teacher',
                'terms' => $teacher_filter,
                'field' => 'slug',
                'operator' => 'IN'
            ]);
        }

        if( count($tax_query) > 0 ) {
            $taxQuery = [
                // 'relation' => 'OR', 
                $tax_query
            ];
        }

        return $taxQuery;
    }

    function customWoocommerceProductQueryMetaQuery($metaQuery, $instance)
    {
        if(isset($_GET['key'])) {
            $metaQuery[] = array(
                'relation' => 'OR', 
                array(
                    'key'     => '_sku',
                    'value' => $_GET['key'],
                    'compare' => 'like'
                )
            );
        }
        
        return $metaQuery;
    }

    function ajaxAddToCart() 
    {
        $productID = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;            
        $variationID = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;

        if($productID == 0 || $quantity == 0) {
            wp_send_json_error(array(
                'message' => 'Add to cart is failure.'
            ), 400);
            exit();
        }

        $cart = WC()->cart->add_to_cart( $productID, $quantity, $variationID );

        if ( $cart ) {
            $product = wc_get_product($productID);
            wp_send_json_success(array(
                'message' => 'Add to cart is success',
                'cart' => $cart,
                'title' => $product->get_title(),
                'link_checkout' => wc_get_checkout_url()
            ));
            exit();
        } else {
            $all_notices  = WC()->session->get( 'wc_notices', array() );
            wc_clear_notices();

            $message = 'This product cannot be added to cart';
            if($all_notices['error'][0]['notice']) {
                $message = $all_notices['error'][0]['notice'];
            }

            wp_send_json_error(array(
                'message' => $message,
            ), 400);
            exit();
        }
    }

    function customCartFragment($fragments)
    {
        // Item in cart header
        $fragments['.cart-badge'] = '<span class="cart-badge">'. WC()->cart->get_cart_contents_count() .'</span>';
        return $fragments;
    }

    public function customOverrideCheckoutFields( $fields ) 
    {
        $fields['billing']['billing_first_name']['class'] = array('rt-form-group');
        $fields['billing']['billing_phone']['class'] = array('rt-form-group');
        $fields['billing']['billing_email']['class'] = array('rt-form-group');

        $fields['billing']['billing_first_name']['label_class'] = array('rt-form-label');
        $fields['billing']['billing_phone']['label_class'] = array('rt-form-label');
        $fields['billing']['billing_email']['label_class'] = array('rt-form-label');

        $fields['billing']['billing_first_name']['input_class'] = array('rt-form-control');
        $fields['billing']['billing_phone']['input_class'] = array('rt-form-control');
        $fields['billing']['billing_email']['input_class'] = array('rt-form-control');

        $fields['billing']['billing_first_name']['label'] = __('Họ tên', 'pennacademy');
        $fields['billing']['billing_phone']['label'] = __('Điện thoại liên hệ', 'pennacademy');
        $fields['billing']['billing_email']['label'] = __('Email của bạn', 'pennacademy');

        

        unset($fields['billing']['billing_last_name']);
        unset($fields['billing']['billing_address_1']);
        unset($fields['billing']['billing_postcode']);
        unset($fields['billing']['billing_city']);
        unset($fields['billing']['billing_country']);
        return $fields;
    }

}