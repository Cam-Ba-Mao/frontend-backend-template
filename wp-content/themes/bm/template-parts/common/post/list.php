<section class="rt-blog" id="rt-blog">
    <div class="container"> 
        <div class="rt-blog__inner">
            <div class="row">
                <div class="col-lg-3 col-xl-3">
                    <?php get_sidebar(); ?>
                </div>

                <div class="col-lg-9 col-xl-9">
                    <div class="rt-blog__inner--content">
                        <h2 class="rt-title"><?= !empty($data['title']) ? $data['title'] : get_the_title(); ?></h2>
                        
                        <?php if(!empty($data['posts']) && $data['posts']->have_posts()): ?>
                        <div class="rt-blog__inner--posts">
                            <div class="posts-wrapper">
                                <?php while ($data['posts']->have_posts()): $data['posts']->the_post();?>
                                    <?php get_template_part('template-parts/common/post/post-item'); ?>
                                <?php endwhile; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if( isset($data['posts']->max_num_pages) && $data['posts']->max_num_pages > 1 ): ?>
                    <div class="btn-readmore">
                        <button class="btn rt-btn-outline-primary btn-ajax-read-more" type="button" data-url="<?= $data['link'] ?>" data-total="<?= $data['posts']->max_num_pages; ?>"><?php _e('Xem thêm', 'rt') ?></button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    </section>