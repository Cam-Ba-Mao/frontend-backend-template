<?php
namespace BM\Core\Common;

class CommonFunctions {
    public static function response( string $code, int $http_status, $message = '' , $data = null ) 
    {
        return new \WP_REST_Response( array(
            'code'    => $code,
            'message' => $message,
            'data'    => $data
        ), $http_status );
    }

    public static function getPageByChild($id, $except = []) {
        $args = [
            'post_type'         => 'page',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'post_parent'       => $id,
            'order'             => 'ASC',
            'orderby'           => 'menu_order'
        ];

        if (is_array($except) && count($except) > 0) {
            $args['post__not_in'] = $except;
        }

        return new \WP_Query($args);
    }

    public static function getTabs($id) 
    {
        $postInfo = get_post($id);
        $response = [];

        if( $postInfo) {
            if( $postInfo->post_parent == 0 ) {
                $pages = self::getPageByChild($postInfo->ID);
            } else {
                $pages = self::getPageByChild($postInfo->post_parent);
            }

            if( $pages->have_posts() ) {
                while( $pages->have_posts() ) {
                    $pages->the_post();

                    array_push($response,[
                        'active' => get_the_ID() == $id ? true : false,
                        'link'   => get_permalink(),
                        'title'  => get_the_title()
                    ]);
                }

                wp_reset_postdata();
            }

            return $response;
        }
    }
}