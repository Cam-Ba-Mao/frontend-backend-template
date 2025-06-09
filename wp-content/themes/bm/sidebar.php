<?php
$sidebarMenu = iedg_get_menu_data('sidebar-menu');

if (is_array($sidebarMenu) && count($sidebarMenu) > 0) {
    // $sidebarMenu = recursiveMenu($sidebarMenu);
    // $sidebarMenu = _iedg_menu_item_classes_by_context($sidebarMenu);
    _wp_menu_item_classes_by_context($sidebarMenu);
    $sidebarMenu = recursiveMenu($sidebarMenu);
}

// dd($sidebarMenu);
?>

<?php if (is_array($sidebarMenu) && count($sidebarMenu) > 0) : ?>
<div class="rt-archive-sidebar">
    <ul class="tree">
        <?php foreach($sidebarMenu as $key => $menu): ?>
        <?php
            $menu_fields = get_fields($menu);
        ?>
        <li class="caret <?= is_array($menu->classes) && count($menu->classes) > 0 ? implode(' ', $menu->classes) : ''; ?> <?= !empty($menu->children) ? 'is-arrow' : '' ?>">
            <a class="link-parent" href="<?= !empty($menu->url) ? $menu->url : 'javascript:void(0)'; ?>">
                <?php if( isset($menu_fields['menu_icon']['url']) ): ?>
                <img class="lazy" data-src="<?= $menu_fields['menu_icon']['url']; ?>" alt="<?= $menu_fields['menu_icon']['alt']; ?>">
                <?php endif; ?>
                <span><?= $menu->title; ?></span>
            </a>
            <?php if (isset($menu->children) && is_array($menu->children) && count($menu->children) > 0) : ?>
            <ul class="nested">
                <?php foreach ($menu->children as $menu_child) : ?>
                <li class="<?= is_array($menu_child->classes) && count($menu_child->classes) > 0 ? implode(' ', $menu_child->classes) : ''; ?>">
                    <a href="<?= $menu_child->url; ?>" target="<?= $menu_child->target; ?>"><?= $menu_child->title; ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>