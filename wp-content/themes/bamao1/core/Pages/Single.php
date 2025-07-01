<?php
   
    add_action('iedg_content_single_car','contentPost');        
    

    /**
     * Content Post Single
     * @param $id
     */
    function contentPost($id)
    {
        echo "abc";
        $terms = $listTerms = get_the_terms( $id, 'car_cat' );
        // dd($terms);

        $term = '';
        if ( is_array($listTerms) && count( $listTerms ) > 0 ) {
            $term = array_shift( $terms )->term_id;
            $termName = array_shift( $listTerms )->name;
        } 

        $options = get_fields('option');
        if (empty($options)) {
            $options = [];
        }

        $data = get_fields($id);

        if( $data ) {
            $data = array_merge($options, $data);
        }        

        // $data['more_articles'] = \Iedg\Core\Blog\BlogFunctions::getRelatedBlogs($id, $term, ['posts_per_page' => 5]);
        $data['tags'] = get_the_tags();
        $data['categories'] = getCategories();
        $data['terms'] = $terms;

        set_query_var('data', $data);
        
        get_template_part('templates/single-car');
        
        
    }