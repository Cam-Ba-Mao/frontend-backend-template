<?php
	/* 
	 Template Name: Car Post
	 */
    $data['categories'] = getCategories('term_order', 'ASC', 'false');
    $data['car'] = getCar(null, $paged, $limit);
?>

<?php get_header(); ?>
    <section class="pennacademy-news-event">
        <div class="container">
            <h2 class="pennacademy-title pennacademy-title__medium text-center"><?php _e('Tin tức & Ưu đãi', 'pennacademy'); ?></h2>
            <?php if( isset($data['categories']) && is_array($data['categories']) && count($data['categories']) > 0 ): ?>
            <div class="pennacademy-tab-link"> 
                <ul> 
                    <li>
                        <a href="#" class="active"><?= _e('Tất cả', 'pennacademy'); ?></a>
                    </li>
                    <?php foreach($data['categories'] as $cat ): ?>
                    <li>
                        <a <?= isset($data['categoryCurrent']->term_id) && $data['categoryCurrent']->term_id == $cat->term_id ? 'class="active"' : ''; ?> href="<?= get_term_link($cat); ?>"><?= $cat->name; ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <div class="pennacademy-news__list">      
                <div class="row">
                <?php if(isset($data['categories']) && !empty($data['categories']) ): ?>
                
                    <?php
                        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                        $data['paged'] = $paged;
                        $news = getCar(null, $paged, 12, []);    
                    ?>
                    <?php if( $news->have_posts() ): ?>
                        <?php while( $news->have_posts() ): $news->the_post(); ?> 
                            <?php
                                if (get_the_post_thumbnail_url()) {
                                    $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
                                } else {
                                    $thumbnail = get_template_directory_uri(). '/html/dist/images/no-thumbnail.png';
                                }
                                
                                $title = get_the_title();
                                $link = get_the_permalink();
                                $description = get_the_excerpt();
                                
                            ?>
                            <div class="col-md-6 col-lg-4 col-xl-3 pennacademy-news__wrap"><a class="pennacademy-news-event__item" href="<?= $link; ?>"> 
                                    <div class="pennacademy-news__image iedg-img-drop"> <img class="lazy" data-src="<?= $thumbnail; ?>" alt=""></div>
                                    <div class="pennacademy-news__body">
                                        <div class="pennacademy-news__title"><?= $title; ?></div>
                                        <div class="pennacademy-news__desc"><?= $description; ?></div>
                                    </div>
                                    <div class="pennacademy-news__footer">
                                        <div class="pennacademy-news__cta text-right"> <span class="iedg-btn iedg-btn-outline-primary">Đọc tiếp</span></div>
                                    </div></a></div>
                        <?php endwhile; wp_reset_postdata();?>
                    <?php endif; ?>
                <?php endif; ?>  
            
                </div>
            </div>
            <div class="iedg-pagination">
                <?= iedg_pagination($news, 'list', '<svg role="img"><use xlink:href="#icon-arrow-prev"></use></svg>', '<svg role="img"><use xlink:href="#icon-arrow-next"></use></svg>'); ?>
            </div>
        </div>
    </section>
<?php get_footer(); ?>

