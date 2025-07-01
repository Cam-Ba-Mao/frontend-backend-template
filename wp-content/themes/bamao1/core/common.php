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

/**
 * Write to log file.
 */
if (!function_exists('ll')) {
    function ll($a)
    {
        $file = fopen('iedg_log.txt', "a");
        $txt = "---------" . date('Y-m-d H:i:s') . "---------\n";
        if (is_array($a) || is_object($a)) {
            $txt .= print_r($a, true);
        } else {
            $txt .= print_r($a, true);
        }
        fwrite($file, $txt);
        fclose($file);
    }
}


/**
 * Get nav menu items by location
 *
 * @param $location
 * @param array $args
 * @return array|false|void
 */
function getMenuItemsByLocation($location, $args = [])
{
    // get all locations
    $locations = get_nav_menu_locations();
    if (!isset($locations[$location])) {
        return;
    }

    $object = wp_get_nav_menu_object($locations[$location]);
    $menu_items = wp_get_nav_menu_items($object->name, $args);

    return $menu_items;
}


/**
 * Recursive Menu
 *
 * @param $menus
 * @param int $parent_id
 * @param string $char
 * @return array
 */
function recursiveMenu($menus, $parent_id = 0, $char = '')
{
    $new = array();

    foreach ($menus as $key => $menu) {
        if ($menu->menu_item_parent == $parent_id) {
            $menu->children = recursiveMenu($menus, $menu->ID);
            unset($menus[$key]);
            $new[] = $menu;
        }
    }

    return $new;
}

/**
 * Get Page Id By Page Template
 */
if (!function_exists('get_page_id_by_template')) {
    function get_page_id_by_template($template, $single = true)
    {
        $args = [
            'numberposts' => 1,
            'post_type' => 'page',
            'fields' => 'ids',
            'nopaging' => true,
            'meta_key' => '_wp_page_template',
            'meta_value' => $template
        ];
        $pages = get_posts($args);
        if ($single && isset($pages[0])) {
            return $pages[0];
        }
        return false;
    }
}

if (!function_exists('pagination')) :
    function iedg_pagination($query, $type = 'list', $preText = 'Prev', $nextText = 'Next')
    {
        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        $total = $query->max_num_pages;
        $big = 999999999;
        return paginate_links([
            'base' => str_replace($big, '%#%', get_pagenum_link($big)),
            'format' => '?paged=%#%',
            'current' => max(1, $paged),
            'total' => $total,
            'mid_size' => 1,
            'prev_text' => $preText,
            'next_text' => $nextText,
            'type' => $type
        ]);
    }
endif;

/**
 * Update image to URL
 */
if (!function_exists('uploadFromURL')) {
    function uploadFromURL($url)
    {
        $ext = substr($url, -3);
        if (strtolower($ext) === 'jpg') {
            $ext = 'jpg';
        } else if (strtolower($ext) === 'png') {
            $ext = 'png';
        } else {
            $ext = 'jpg';
        }
        $uploadDir = wp_upload_dir();
        $name = time() . '.' . $ext;
        $filePath = $uploadDir['path'] . '/' . $name;

        $contents = @file_get_contents($url);

        if (!$contents) {
            return null;
        }
        $saveFile = fopen($filePath, 'w');
        fwrite($saveFile, $contents);
        fclose($saveFile);
        $fileType = wp_check_filetype(basename($name), null);

        $attachment = array(
            'post_mime_type' => $fileType['type'],
            'post_title' => $name,
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $attachId = wp_insert_attachment($attachment, $filePath);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attachData = wp_generate_attachment_metadata($attachId, $filePath);
        wp_update_attachment_metadata($attachId, $attachData);

        return $attachId;
    }
}