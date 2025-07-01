<?php namespace BM\Core\Course;

class CourseHook
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
        add_action('init', [$this, 'registerCourse']);
        add_action('init', [$this, 'registerTaxonomyCourse']);
        add_action('cat_course_edit_form_fields', [$this, 'addCustomTaxonomyDescriptionEditor']);
        add_action('admin_head', [$this, 'adminHead']);
    }

    public static function adminHead()
    {
        $screen = get_current_screen();
        if (strpos($screen->id, 'edit-cat_course') !== false || strpos($screen->id, 'cat_course') !== false) {
            echo '<style>.form-field.term-description-wrap { display: none !important; }</style>';
        }
    }

    public static function addCustomTaxonomyDescriptionEditor($term)
    {
        $description = htmlspecialchars_decode($term->description);
        ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="description"><?php _e('Description'); ?></label></th>
            <td>
                <?php
                wp_editor(
                    $description,
                    'custom_taxonomy_description',
                    [
                        'textarea_name' => 'description',
                        'media_buttons' => false,
                        'textarea_rows' => 10,
                        'quicktags' => true
                    ]
                );
                ?>
                <p class="description"><?php _e('The description is not prominent by default; however, some themes may show it.'); ?></p>
            </td>
        </tr>
        <?php
    }

    public static function registerCourse() {
        $args = [
            'supports' => [
                'title',
                'editor',
                'excerpt',
                'thumbnail',
                'slug',
                'revisions'
            ],
            'labels' => [
                'name' => 'Courses',
                'singular_name' => 'Courses',
                'menu_name' => 'Courses',
                'name_admin_bar' => 'Courses',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Course',
                'new_item' => 'New Course',
                'edit_item' => 'Edit Course',
                'view_item' => 'View Course',
                'all_items' => 'All Courses',
                'search_items' => 'Search Courses',
                'not_found' => 'No Course Found.',
            ],
            'show_in_rest' => false,
            'public' => true,
            'publicly_queryable' => true,
            'query_var' => true,
            'has_archive' => false,
            'hierarchical' => true,
            'rewrite' => ['slug' => 'course', 'with_front' => true],
            'menu_icon' => 'dashicons-editor-help'
        ];

        register_post_type('course', $args);
    }

    public static function registerTaxonomyCourse() {
        $labels = array(
            'name' => 'Course Category',
            'singular_name' => 'Course Category',
            'search_items' => 'Search Course Category',
            'all_items' => 'All Course Category',
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => 'Edit Course Category',
            'update_item' => 'Update Course Category',
            'add_new_item' => 'Add New Course Category',
            'new_item_name' => 'Name Course Category',
            'menu_name' => 'Course Category',
        );

        register_taxonomy('cat_course', 'course', array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'publicly_queryable' => true,
            'rewrite' => array('slug' => 'course-category'),
        ));
    }
}
