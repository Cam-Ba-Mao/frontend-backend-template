<?php

/**
 * debug function
 */
if (!function_exists('dd')) {
    function dd($a, $b = false, $c = true) {
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
    function ll($a) {
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
function getMenuItemsByLocation($location, $args = []) {
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
function recursiveMenu($menus, $parent_id = 0, $char = '') {
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
    function get_page_id_by_template($template, $single = true) {
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

if (!function_exists('rt_get_breadcrumbs')) {
    function rt_get_breadcrumbs($post_id, $html = '') {
        $data = get_post($post_id);

        if ($data->post_parent != 0) {
            $html .= '<li>
                <a href="' . get_permalink($data->post_parent) . '">' . get_the_title($data->post_parent) . '</a>
            </li>';

            rt_get_breadcrumbs(get_post($data->post_parent));
        }

        return $html;
    }
}

if (!function_exists('pagination')) :
    function iedg_pagination($query, $type = 'list', $preText = 'Prev', $nextText = 'Next') {
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
    function uploadFromURL($url) {
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

if (!function_exists('iedg_comments')) {

    /**
     * Output the Review comments template.
     *
     * @param WP_Comment $comment Comment object.
     * @param array      $args Arguments.
     * @param int        $depth Depth.
     */
    function iedg_comments($comment, $args, $depth) {
        set_query_var('comment', $comment);
        get_template_part('template-parts/common/review');
    }
}

// Table of contents
function get_toc($content) {
    // get headlines
    $headings = get_headings($content, 1, 2);

    if (is_array($headings) && count($headings) < 1) return '';

    // parse toc
    ob_start();
?>
    <?php
    parse_toc($headings, 0, 0);
    return ob_get_clean();
}

function parse_toc($headings, $index, $recursive_counter) {
    // prevent errors

    if ($recursive_counter > 60 || !count($headings)) return;

    // get all needed elements
    $last_element = $index > 0 ? $headings[$index - 1] : NULL;
    $current_element = $headings[$index];
    $next_element = NULL;
    if ($index < count($headings) && isset($headings[$index + 1])) {
        $next_element = $headings[$index + 1];
    }

    // end recursive calls
    if ($current_element == NULL) return;

    // get all needed variables
    $tag = intval($headings[$index]["tag"]);

    $id = $headings[$index]["id"];

    $classes = !empty($headings[$index]["classes"]) ? $headings[$index]["classes"] : array();
    $name = $headings[$index]["name"];

    // element not in toc
    if (!empty($current_element["classes"]) && in_array("nitoc", $current_element["classes"])) {
        parse_toc($headings, $index + 1, $recursive_counter + 1);
        return;
    }

    // parse toc begin or toc subpart begin
    if ($last_element == NULL) echo "<ul class='list'>";

    if ($last_element != NULL && $last_element["tag"] < $tag) {
        for ($i = 0; $i < $tag - $last_element["tag"]; $i++) {
            echo "<ul>";
        }
    }

    // build li class
    $active_class = "toc-active";
    $li_classes = $index  === 0 ? "class='" . $active_class . "'" : "";
    if (!empty($current_element["classes"]) && in_array($active_class, $current_element["classes"]))
        $li_classes = " class='" . $active_class . "'";

    // parse line begin

    echo "<li " . $li_classes . ">";

    // only parse name, when li is not bold
    if (isset($current_element["classes"]) && $current_element["classes"] && in_array($active_class, $current_element["classes"])) {
        echo $name;
    } else {
        echo "<a href='#" . $id . "'>" . $name . "</a>";
    }

    if ($next_element && intval($next_element["tag"]) > $tag) {
        parse_toc($headings, $index + 1, $recursive_counter + 1);
    }

    // parse line end
    echo "</li>";

    // parse next line
    if ($next_element && intval($next_element["tag"]) == $tag) {
        parse_toc($headings, $index + 1, $recursive_counter + 1);
    }

    // parse toc end or toc subpart end
    if ($next_element == NULL || ($next_element && $next_element["tag"] < $tag)) {
        echo "</ul>";
        if ($next_element && $tag - intval($next_element["tag"]) >= 2) {
            echo "</li>";
            for ($i = 1; $i < $tag - intval($next_element["tag"]); $i++) {
                echo "</ul>";
            }
        }
    }

    // parse top subpart
    if ($next_element != NULL && $next_element["tag"] < $tag) {
        parse_toc($headings, $index + 1, $recursive_counter + 1);
    }
}

function get_headings($content, $from_tag = 1, $to_tag = 6) {
    $headings = array();
    $preg = '/<div class="([^"]+?)">(.*?)<\/div>/is';
    $content = preg_replace($preg, '', $content);
    preg_match_all("/<h([" . $from_tag . "-" . $to_tag . "])([^<]*)>(.*)<\/h[" . $from_tag . "-" . $to_tag . "]>/", $content, $matches);

    for ($i = 0; $i < count($matches[1]); $i++) {
        $headings[$i]["tag"] = $matches[1][$i];
        // get id
        $att_string = $matches[2][$i];
        preg_match("/id=\"([^\"]*)\"/", $att_string, $id_matches);

        $headings[$i]["id"] = $id_matches[1];

        // get classes
        $att_string = $matches[2][$i];
        preg_match_all("/class=\"([^\"]*)\"/", $att_string, $class_matches);
        for ($j = 0; $j < count($class_matches[1]); $j++) {
            $headings[$i]["classes"] = explode(" ", $class_matches[1][$j]);
        }
        $headings[$i]["name"] = strip_tags($matches[3][$i]);
    }
    return $headings;
}

/**
 * Automatically add IDs to headings such as <h2></h2>
 */
function auto_id_headings($content) {
    $content = preg_replace_callback('/(\<h[1-6](.*?))\>(.*)(<\/h[1-6]>)/i', function ($matches) {
        if (!stripos($matches[0], 'id=')) {
            $matches[0] = $matches[1] . $matches[2] . ' id="' . sanitize_title(iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $matches[3])) . '">' . $matches[3] . $matches[4];
        }
        $temp = $matches[0];
        return $temp;
    }, $content);

    $content = preg_replace_callback('/(\<table(.*?))\>(.*)(<\/table>)/si', function ($matches) {    
        
        if (stripos($matches[0], 'class="')) {
            $matches[0] = '<div class="rt-rs-table">' . str_replace('class="', 'class="table table-bordered ', $matches[0]) . '</div>';
        } else {
            $matches[0] = '<div class="rt-rs-table">' . $matches[1] . $matches[2] . ' class="table table-bordered">' . $matches[3] . $matches[4] . '</div>';
        }        
        $temp = $matches[0];
        return $temp;
    }, $content);

    return $content;
}
add_filter('the_content', 'auto_id_headings');