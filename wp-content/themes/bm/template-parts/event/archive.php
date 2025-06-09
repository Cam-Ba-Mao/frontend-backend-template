<section class="rt-event-archive">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-xl-3">
                <?= get_sidebar(); ?>
            </div>
            <div class="col-lg-8 col-xl-9">
                <div class="rt-event-archive__inner">
                    <h2 class="rt-title"><?= get_the_title(); ?></h2>
                    <form action="<?php the_permalink(); ?>" method="post" class="rt-event-archive__form">
                        <div class="isa-archive-filter">
                            <span><?php _e('Bộ lọc:', 'rt'); ?></span>
                            <div class="custom-select" id="select-position">
                                <select id="select-1" name="filter">
                                    <option value=""><?php _e('Mới nhất', 'rt'); ?></option>
                                    <option value="coming"><?php _e('Sự kiện sắp diễn ra', 'rt'); ?></option>
                                </select>
                                <input type="hidden" name="action" value="rt_event_loaddata">
                                <div class="select-style"><?php _e('Mới nhất', 'isa'); ?></div>
                                <ul class="options"></ul>
                            </div>
                        </div>
                    </form>
                </div>
                <?php if (!empty($data['events'])) : ?>
                    <?php if (isset($data['events']) && is_array($data['events']) && count($data['events']) > 0) : ?>
                        <div class="rt-event-archive__list" id="ajaxdata">
                            <?php
                            $event_data = [];
                            ?>
                            <?php foreach ($data['events'] as $event) : ?>
                                <?php get_template_part('template-parts/event/loop', null, $event); ?>
                            <?php endforeach; ?>
                        </div>
                        <?php get_template_part('template-parts/event/loadmore'); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>