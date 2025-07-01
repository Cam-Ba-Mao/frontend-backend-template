<?php
    $count = 0;
    $keyword = "";

    if (isset($data['key']) && !empty($data['key'])) {
        $keyword = $data['key'];
    }
    if (isset($data['pagination']) && !empty($data['pagination'])) {
        $pagination = $data['pagination'];
    }
    if (isset($data['result']) && !empty($data['result']) && isset($data['result']->posts) && !empty($data['result']->posts)) {
        $result = $data['result']->posts;
    }
    if (isset($data['count']) && !empty($data['count'])) {
        $count = $data['count'];
    }
    if (isset($data['limit']) && !empty($data['limit'])) {
        $limit = $data['limit'];
    }
    if (isset($data['key']) && !empty($data['key'])) {
        $keyword = $data['key'];
    }
    if ($limit > $count) {
        $limit = $count;
    }
?>

<section class="rt-search-results">
    <div class="container">
        <div class="rt-search-results__inner">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                <?php if ($count > 0): ?>
                    <?php foreach($result as $item): ?>
                    <a href="<?= get_the_permalink($item->ID); ?>" class="rt-search-results__item" title="<?= get_the_title($item->ID); ?>">
                        <div class="rt-search-results__item--title"><?= get_the_title($item->ID); ?></div>
                        <div class="rt-search-results__item--description"><?= apply_filters('the_excerpt', get_the_excerpt($item->ID)); ?></div>
                    </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php _e('No posts found.', 'rt'); ?>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (! empty($pagination)): ?>
        <div class="rt-pagination"><?= $pagination; ?></div>
        <?php endif; ?>
    </div>
</section>