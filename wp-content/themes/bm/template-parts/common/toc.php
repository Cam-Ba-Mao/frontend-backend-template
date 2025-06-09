<?php
    $table_of_content = get_toc(auto_id_headings(get_the_content()));
?>

<?php if (!empty($table_of_content)) : ?>
<?php
    $tocHTML = "";
    ob_start();
    ?>
    <div class="rt-details__toc">
        <div class="heading">
            <div class="toc-title"><?= __('Nội dung bài viết', 'rt'); ?></div>
        </div>
        <?= $table_of_content; ?>
    </div>
    <?php
    $tocHTML = ob_get_clean();
    echo $tocHTML;
?>
<?php endif; ?>