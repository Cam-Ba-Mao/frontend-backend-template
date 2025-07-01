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

<section class="rt-search-results-header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="rt-search-results-header__form">
                    <form action="<?= home_url(); ?>" method="get">
                        <div class="rt-search-results-header__form--field">
                            <input class="form-control" type="search" name="s" value="<?= get_query_var('s'); ?>" id="search" placeholder="<?php _e('Search here...', 'rt'); ?>" />
                            <button type="reset">
                                <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.0003 4.56836L3.66699 14.2189" stroke="#193162" stroke-miterlimit="10" stroke-linecap="square"></path>
                                    <path d="M13.0003 14.2189L3.66699 4.56836" stroke="#193162" stroke-miterlimit="10" stroke-linecap="square"></path>
                                </svg>
                            </button>
                            <button type="submit">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5 13.5C10.8137 13.5 13.5 10.8137 13.5 7.5C13.5 4.18629 10.8137 1.5 7.5 1.5C4.18629 1.5 1.5 4.18629 1.5 7.5C1.5 10.8137 4.18629 13.5 7.5 13.5Z"
                                        stroke="#212121"
                                        stroke-miterlimit="10"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    ></path>
                                    <path d="M15.5002 15.5002L11.7422 11.7422" stroke="#193162" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
                <?php if (! empty($count) && ! empty($keyword)): ?>
                <div class="rt-search-results-header__text">
                    <?php printf(__('Showing %d of %d Results for <strong>"%s"</strong>', 'rt'), $limit, $count, $keyword); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>