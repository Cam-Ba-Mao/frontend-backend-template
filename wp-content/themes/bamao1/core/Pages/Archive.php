<?php

    // add_action('iedg_content_post_archive', [$this, 'contentPost']);
    // add_action('iedg_content_tourist_destinations_page', [$this, 'contentTouristDestinations']);
    // add_action('iedg_content_school_system_page', [$this, 'contentSchoolSystem']);
    add_action('iedg_content_car_cat_page',  'contentCat');        

    /**
     * Content Car Cat
     * @param $id
     */
    function contentCat($id)
    {
        $options = get_fields('option');
        if (empty($options)) {
            $options = [];
        }

        $data = get_fields($id);
        if (empty($data)) {
            $data = [];
        }
        $data = array_merge($options, $data);
        $categoryCurrent = get_queried_object();

        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $limit = 6;

        // $pageExperience = get_page_id_by_template('page-templates/study-abroad-experience.php');
        // $data['pageExperience'] = $pageExperience;

        if( isset($categoryCurrent->taxonomy) && $categoryCurrent->taxonomy == 'car_cat' ) {
            $data['link'] = get_term_link($categoryCurrent->term_id);
            $data['categoryCurrent'] =  $categoryCurrent;
            $data['categories'] = getCategories('term_order', 'ASC', 'false');
            $data['car'] = getCar($categoryCurrent->term_id, $paged, $limit);
           
            set_query_var('data', $data);
            get_template_part('templates/car/category/car-category');
            echo "đang vô car category";
        }
        // } else {
        //     // $data['link'] = $pageExperience ? get_permalink($pageExperience) : get_the_permalink();
        //     $data['categories'] = getCategories('term_order', 'ASC', 'false');
        //     $data['car'] = getCar(null, $paged, $limit);
            
        //     set_query_var('data', $data);
        //     get_template_part('templates/car-post');
        // }
    }
    