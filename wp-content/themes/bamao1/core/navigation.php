<?php

if (!function_exists('iedg_create_menu_location')) {
    add_action('init', 'iedg_create_menu_location');
    /**
     * Create Menu Location.
     */
    function iedg_create_menu_location()
    {
        register_nav_menu('main-menu', __('Main Menu'));
        register_nav_menu('footer-menu', __('Footer Menu'));
    }
}

if (!function_exists('iedg_get_menu_data')) {
    /**
     * Get Menu Data by Location.
     */
    function iedg_get_menu_data($location)
    {
        $menu_locations = get_nav_menu_locations();

        if(isset($menu_locations[$location])) {
            $menu_id = $menu_locations[$location];
            $menu_items = wp_get_nav_menu_items($menu_id);

            return $menu_items;
        }

        return false;
    }

    function _iedg_menu_item_classes_by_context( &$menu_items ) {
        global $wp_query, $wp_rewrite;

        $queried_object    = $wp_query->get_queried_object();
        $queried_object_id = (int) $wp_query->queried_object_id;

        $active_object               = '';
        $active_ancestor_item_ids    = array();
        $active_parent_item_ids      = array();
        $active_parent_object_ids    = array();
        $possible_taxonomy_ancestors = array();
        $possible_object_parents     = array();
        $home_page_id                = (int) get_option( 'page_for_posts' );

        if ( $wp_query->is_singular && ! empty( $queried_object->post_type ) && ! is_post_type_hierarchical( $queried_object->post_type ) ) {
            foreach ( (array) get_object_taxonomies( $queried_object->post_type ) as $taxonomy ) {
                if ( is_taxonomy_hierarchical( $taxonomy ) ) {
                    $term_hierarchy = _get_term_hierarchy( $taxonomy );
                    $terms          = wp_get_object_terms( $queried_object_id, $taxonomy, array( 'fields' => 'ids' ) );
                    if ( is_array( $terms ) ) {
                        $possible_object_parents = array_merge( $possible_object_parents, $terms );
                        $term_to_ancestor        = array();
                        foreach ( (array) $term_hierarchy as $anc => $descs ) {
                            foreach ( (array) $descs as $desc ) {
                                $term_to_ancestor[ $desc ] = $anc;
                            }
                        }

                        foreach ( $terms as $desc ) {
                            do {
                                $possible_taxonomy_ancestors[ $taxonomy ][] = $desc;
                                if ( isset( $term_to_ancestor[ $desc ] ) ) {
                                    $_desc = $term_to_ancestor[ $desc ];
                                    unset( $term_to_ancestor[ $desc ] );
                                    $desc = $_desc;
                                } else {
                                    $desc = 0;
                                }
                            } while ( ! empty( $desc ) );
                        }
                    }
                }
            }
        } elseif ( ! empty( $queried_object->taxonomy ) && is_taxonomy_hierarchical( $queried_object->taxonomy ) ) {
            $term_hierarchy   = _get_term_hierarchy( $queried_object->taxonomy );
            $term_to_ancestor = array();
            foreach ( (array) $term_hierarchy as $anc => $descs ) {
                foreach ( (array) $descs as $desc ) {
                    $term_to_ancestor[ $desc ] = $anc;
                }
            }
            $desc = $queried_object->term_id;
            do {
                $possible_taxonomy_ancestors[ $queried_object->taxonomy ][] = $desc;
                if ( isset( $term_to_ancestor[ $desc ] ) ) {
                    $_desc = $term_to_ancestor[ $desc ];
                    unset( $term_to_ancestor[ $desc ] );
                    $desc = $_desc;
                } else {
                    $desc = 0;
                }
            } while ( ! empty( $desc ) );
        }

        $possible_object_parents = array_filter( $possible_object_parents );

        $front_page_url         = home_url();
        $front_page_id          = (int) get_option( 'page_on_front' );
        $privacy_policy_page_id = (int) get_option( 'wp_page_for_privacy_policy' );

        foreach ( (array) $menu_items as $key => $menu_item ) {

            $menu_items[ $key ]->current = false;

            $classes   = (array) $menu_item->classes;
            $classes[] = 'menu-item';
            $classes[] = 'menu-item-type-' . $menu_item->type;
            $classes[] = 'menu-item-object-' . $menu_item->object;

            // This menu item is set as the 'Front Page'.
            if ( 'post_type' === $menu_item->type && $front_page_id === (int) $menu_item->object_id ) {
                $classes[] = 'menu-item-home';
            }

            // This menu item is set as the 'Privacy Policy Page'.
            if ( 'post_type' === $menu_item->type && $privacy_policy_page_id === (int) $menu_item->object_id ) {
                $classes[] = 'menu-item-privacy-policy';
            }

            // If the menu item corresponds to a taxonomy term for the currently queried non-hierarchical post object.
            if ( $wp_query->is_singular && 'taxonomy' === $menu_item->type
                && in_array( (int) $menu_item->object_id, $possible_object_parents, true )
            ) {
                $active_parent_object_ids[] = (int) $menu_item->object_id;
                $active_parent_item_ids[]   = (int) $menu_item->db_id;
                $active_object              = $queried_object->post_type;

                // If the menu item corresponds to the currently queried post or taxonomy object.
            } elseif (
                $menu_item->object_id == $queried_object_id
                && (
                    ( ! empty( $home_page_id ) && 'post_type' === $menu_item->type
                        && $wp_query->is_home && $home_page_id == $menu_item->object_id )
                    || ( 'post_type' === $menu_item->type && $wp_query->is_singular )
                    || ( 'taxonomy' === $menu_item->type
                        && ( $wp_query->is_category || $wp_query->is_tag || $wp_query->is_tax )
                        && $queried_object->taxonomy == $menu_item->object )
                )
            ) {
                $classes[]                   = 'current-menu-item';
                $menu_items[ $key ]->current = true;
                $_anc_id                     = (int) $menu_item->db_id;

                while (
                    ( $_anc_id = (int) get_post_meta( $_anc_id, '_menu_item_menu_item_parent', true ) )
                    && ! in_array( $_anc_id, $active_ancestor_item_ids, true )
                ) {
                    $active_ancestor_item_ids[] = $_anc_id;
                }

                if ( 'post_type' === $menu_item->type && 'page' === $menu_item->object ) {
                    // Back compat classes for pages to match wp_page_menu().
                    $classes[] = 'page_item';
                    $classes[] = 'page-item-' . $menu_item->object_id;
                    $classes[] = 'current_page_item';
                }

                $active_parent_item_ids[]   = (int) $menu_item->menu_item_parent;
                $active_parent_object_ids[] = (int) $menu_item->post_parent;
                $active_object              = $menu_item->object;

                // If the menu item corresponds to the currently queried post type archive.
            } elseif (
                'post_type_archive' === $menu_item->type
                && is_post_type_archive( array( $menu_item->object ) )
            ) {
                $classes[]                   = 'current-menu-item';
                $menu_items[ $key ]->current = true;
                $_anc_id                     = (int) $menu_item->db_id;

                while (
                    ( $_anc_id = (int) get_post_meta( $_anc_id, '_menu_item_menu_item_parent', true ) )
                    && ! in_array( $_anc_id, $active_ancestor_item_ids, true )
                ) {
                    $active_ancestor_item_ids[] = $_anc_id;
                }

                $active_parent_item_ids[] = (int) $menu_item->menu_item_parent;

                // If the menu item corresponds to the currently requested URL.
            } elseif ( 'custom' === $menu_item->object && isset( $_SERVER['HTTP_HOST'] ) ) {
                $_root_relative_current = untrailingslashit( $_SERVER['REQUEST_URI'] );

                // If it's the customize page then it will strip the query var off the URL before entering the comparison block.
                if ( is_customize_preview() ) {
                    $_root_relative_current = strtok( untrailingslashit( $_SERVER['REQUEST_URI'] ), '?' );
                }

                $current_url        = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_root_relative_current );
                $raw_item_url       = strpos( $menu_item->url, '#' ) ? substr( $menu_item->url, 0, strpos( $menu_item->url, '#' ) ) : $menu_item->url;
                $item_url           = set_url_scheme( untrailingslashit( $raw_item_url ) );
                $_indexless_current = untrailingslashit( preg_replace( '/' . preg_quote( $wp_rewrite->index, '/' ) . '$/', '', $current_url ) );

                $matches = array(
                    $current_url,
                    urldecode( $current_url ),
                    $_indexless_current,
                    urldecode( $_indexless_current ),
                    $_root_relative_current,
                    urldecode( $_root_relative_current ),
                );

                if ( $raw_item_url && in_array( $item_url, $matches, true ) ) {
                    $classes[]                   = 'current-menu-item';
                    $menu_items[ $key ]->current = true;
                    $_anc_id                     = (int) $menu_item->db_id;

                    while (
                        ( $_anc_id = (int) get_post_meta( $_anc_id, '_menu_item_menu_item_parent', true ) )
                        && ! in_array( $_anc_id, $active_ancestor_item_ids, true )
                    ) {
                        $active_ancestor_item_ids[] = $_anc_id;
                    }

                    if ( in_array( home_url(), array( untrailingslashit( $current_url ), untrailingslashit( $_indexless_current ) ), true ) ) {
                        // Back compat for home link to match wp_page_menu().
                        $classes[] = 'current_page_item';
                    }
                    $active_parent_item_ids[]   = (int) $menu_item->menu_item_parent;
                    $active_parent_object_ids[] = (int) $menu_item->post_parent;
                    $active_object              = $menu_item->object;

                    // Give front page item the 'current-menu-item' class when extra query arguments are involved.
                } elseif ( $item_url == $front_page_url && is_front_page() ) {
                    $classes[] = 'current-menu-item';
                }

                if ( untrailingslashit( $item_url ) == home_url() ) {
                    $classes[] = 'menu-item-home';
                }
            }

            // Back-compat with wp_page_menu(): add "current_page_parent" to static home page link for any non-page query.
            if ( ! empty( $home_page_id ) && 'post_type' === $menu_item->type
                && empty( $wp_query->is_page ) && $home_page_id == $menu_item->object_id
            ) {
                $classes[] = 'current_page_parent';
            }

            $menu_items[ $key ]->classes = array_unique( $classes );
        }
        $active_ancestor_item_ids = array_filter( array_unique( $active_ancestor_item_ids ) );
        $active_parent_item_ids   = array_filter( array_unique( $active_parent_item_ids ) );
        $active_parent_object_ids = array_filter( array_unique( $active_parent_object_ids ) );

        // Set parent's class.
        foreach ( (array) $menu_items as $key => $parent_item ) {
            $classes                                   = (array) $parent_item->classes;
            $menu_items[ $key ]->current_item_ancestor = false;
            $menu_items[ $key ]->current_item_parent   = false;

            if (
                isset( $parent_item->type )
                && (
                    // Ancestral post object.
                    (
                        'post_type' === $parent_item->type
                        && ! empty( $queried_object->post_type )
                        && is_post_type_hierarchical( $queried_object->post_type )
                        && in_array( (int) $parent_item->object_id, $queried_object->ancestors, true )
                        && $parent_item->object != $queried_object->ID
                    ) ||

                    // Ancestral term.
                    (
                        'taxonomy' === $parent_item->type
                        && isset( $possible_taxonomy_ancestors[ $parent_item->object ] )
                        && in_array( (int) $parent_item->object_id, $possible_taxonomy_ancestors[ $parent_item->object ], true )
                        && (
                            ! isset( $queried_object->term_id ) ||
                            $parent_item->object_id != $queried_object->term_id
                        )
                    )
                )
            ) {
                if ( ! empty( $queried_object->taxonomy ) ) {
                    $classes[] = 'current-' . $queried_object->taxonomy . '-ancestor';
                } else {
                    $classes[] = 'current-' . $queried_object->post_type . '-ancestor';
                }
            }

            if ( in_array( (int) $parent_item->db_id, $active_ancestor_item_ids, true ) ) {
                $classes[] = 'current-menu-ancestor';

                $menu_items[ $key ]->current_item_ancestor = true;
            }
            if ( in_array( (int) $parent_item->db_id, $active_parent_item_ids, true ) ) {
                $classes[] = 'current-menu-parent';

                $menu_items[ $key ]->current_item_parent = true;
            }
            if ( in_array( (int) $parent_item->object_id, $active_parent_object_ids, true ) ) {
                $classes[] = 'current-' . $active_object . '-parent';
            }

            if ( 'post_type' === $parent_item->type && 'page' === $parent_item->object ) {
                // Back compat classes for pages to match wp_page_menu().
                if ( in_array( 'current-menu-parent', $classes, true ) ) {
                    $classes[] = 'current_page_parent';
                }
                if ( in_array( 'current-menu-ancestor', $classes, true ) ) {
                    $classes[] = 'current_page_ancestor';
                }
            }

            $menu_items[ $key ]->classes = array_unique( $classes );
        }

        return $menu_items;
    }
    
}
