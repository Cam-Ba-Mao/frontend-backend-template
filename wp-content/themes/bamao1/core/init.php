<?php
/**
 * debug function
 */
if (!function_exists('dd')) {
    function dd($a, $b = false, $c = true)
    {
        $display = $b ? 'style="display:none"' : '';
        echo '<div class="dd-debug" ' . $display . '>';
        if (is_array($a) || is_object($a)) {
            echo '<pre>';
            print_r($a);
            echo '</pre>';
        } else {
            var_dump($a);
        }
        echo '</div>';
        if ($c) {
            die();
        }
    }
}

// /**
//  * Recursive Menu
//  *
//  * @param $menus
//  * @param int $parent_id
//  * @param string $char
//  * @return array
//  */
// function recursiveMenu($menus, $parent_id = 0, $char = '')
// {
//     $new = array();

//     foreach ($menus as $key => $menu) {
//         if ($menu->menu_item_parent == $parent_id) {
//             $menu->children = recursiveMenu($menus, $menu->ID);
//             unset($menus[$key]);
//             $new[] = $menu;
//         }
//     }

//     return $new;
// }

// /* Kích hoạt tính năng Customizer */
// function example_customizer_menu() {
//     add_theme_page( 'Customize', 'Customize', 'edit_theme_options', 'customize.php' );
// }
// add_action( 'admin_menu', 'example_customizer_menu' );


 /**
 * Add more upload file type
 * @param $type
 * @return array
 */
function allowUploadFileTypes($type)
{
	$type['svg'] = 'image/svg';
	return $type;
}
add_filter('upload_mimes', 'allowUploadFileTypes');


