<?php

namespace BM\Core\Pages;

class Archive
{
    public static function init()
    {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->setupAction();
        }

        return $init;
    }

    private function setupAction()
    {
        add_action('rt_content_post_archive', [$this, 'contentPost']);
        add_action('rt_content_experiences_archive', [$this, 'contentExperiences']);
        add_action('rt_content_scholarship_archive', [$this, 'contentScholarship']);
        add_action('rt_content_school_country_state_archive', [$this, 'contentSchoolCountryState']);
    }

    /**
     * Post Archive
     * @param $id
     */
    public static function contentPost($id)
    {
        $options = get_fields('option');
        if (empty($options)) {
            $options = [];
        }

        $data = get_fields($id);
        if (empty($data)) {
            $data = [];
        }     

        $data['title'] = get_the_title();
        $data['link'] = get_the_permalink();

        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $limit = 8;
        $data['paged'] = $paged;
        $categoryCurrent = get_queried_object();
        if( isset($categoryCurrent->taxonomy) && $categoryCurrent->taxonomy == 'category' ) {
            $templateID = get_page_id_by_template('page-templates/news.php');
            if ($templateID) {
                $dataExtra = get_fields($templateID);
                if (is_array($dataExtra)) {
                    $data = array_merge($data, $dataExtra);
                }
            }

            $data['link'] = get_term_link($categoryCurrent);
            $data['categoryCurrent'] = $categoryCurrent;
            $data['posts'] = \BM\Core\Blog\BlogFunctions::getBlogs($categoryCurrent->term_id, $paged, $limit);
        } else {
            $data['posts'] = \BM\Core\Blog\BlogFunctions::getBlogs(null, $paged, $limit);
        }        

        set_query_var('data', $data);

        get_template_part('template-parts/common/banner');
        get_template_part('template-parts/common/post/list');
        get_template_part('template-parts/common/gift');
    }  
    
     /**
     * Experiences Archive
     * @param $id
     */
    public static function contentExperiences($id)
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

        if( isset($categoryCurrent->taxonomy) && $categoryCurrent->taxonomy == 'cat_experience' ) {
            
            $templateID = get_page_id_by_template('page-templates/experience.php');
            if ($templateID) {
                $dataExtra = get_fields($templateID);
                if (is_array($dataExtra)) {
                    $data = array_merge($data, $dataExtra);
                }                
            }

            $data['title'] = $categoryCurrent->name;

            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $limit = 8;
            $data['paged'] = $paged;
            
            $data['categoryCurrent'] = $categoryCurrent;
            $data['posts'] = \BM\Core\Experience\ExperienceFunctions::getExperiences($categoryCurrent->term_id, $paged, $limit);
            $data['link'] = get_term_link($categoryCurrent);

            set_query_var('data', $data);            

            get_template_part('template-parts/common/banner');
            get_template_part('template-parts/common/post/list');
            get_template_part('template-parts/common/gift');
        } else {
            $data['title'] = get_the_title();
            $data['categories'] =  \BM\Core\Experience\ExperienceFunctions::getCategories();
            $newestHtml = '';

            $newest = \BM\Core\Experience\ExperienceFunctions::getExperiences(0, 0, 4);
            $featured = \BM\Core\Experience\ExperienceFunctions::getExperiencesFeatured();
            $isFeatured = false;
            $except = [];

            if($featured->have_posts()) {
                $isFeatured = true;
                while ($featured->have_posts()) {
                    $featured->the_post();
                    array_push($except, get_the_ID());
                    
                    ob_start();
                    get_template_part('template-parts/common/post/featured');
                    $data['featured'] = ob_get_clean();
                }
            }
            
            if($newest->have_posts()) {
                while ($newest->have_posts()) {
                    $newest->the_post();
                    array_push($except, get_the_ID());

                    if( !$isFeatured ) {
                        $isFeatured = true;
                        ob_start();
                        get_template_part('template-parts/common/post/featured');
                        $data['featured'] = ob_get_clean();
                    } else {
                        ob_start();
                        get_template_part('template-parts/common/post/post-small');
                        $newestHtml .= ob_get_clean();
                    }                
                }
            }

            $data['newest'] = $newestHtml;
            $data['except'] = $except;

            set_query_var('data', $data);

            get_template_part('template-parts/common/banner');
            get_template_part('template-parts/common/post/archive');
            get_template_part('template-parts/common/gift');
        }
    }

    /**
     * Scholarship Archive
     * @param $id
     */
    public static function contentScholarship($id)
    {
        $options = get_fields('option');
        if (empty($options)) {
            $options = [];
        }

        $data = get_fields($id);
        if (empty($data)) {
            $data = [];
        }     

        $data['title'] = get_the_title();
        $data['link'] = get_the_permalink();

        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $limit = 8;
        $data['paged'] = $paged;
        $data['posts'] = \BM\Core\Scholarship\ScholarshipFunctions::getScholarship($paged, $limit);    

        set_query_var('data', $data);

       get_template_part('template-parts/common/banner');
        get_template_part('template-parts/common/post/list');
        get_template_part('template-parts/common/gift');
    }

    public static function contentSchoolCountryState($id)
    {
        $id = \BM\Core\School\SchoolFunctions::getSetting('ID');
        
        $options = get_fields('option');
        if (empty($options)) {
            $options = [];
        }

        $data = get_fields($id);
        if (empty($data)) {
            $data = [];
        }
        $data = array_merge($options, $data);

        set_query_var('data', $data);

        get_template_part('template-parts/school/banner'); 
        get_template_part('template-parts/school/archive'); 
        get_template_part('template-parts/school/faqs'); 
        get_template_part('template-parts/common/gifts'); 
    }
}