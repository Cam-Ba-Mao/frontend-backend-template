<section class="pennacademy-news-event">
    <div class="container">
        <h2 class="pennacademy-title pennacademy-title__medium text-center">Tin tức & Ưu đãi</h2>
        <?php if( isset($data['categories']) && is_array($data['categories']) && count($data['categories']) > 0 ): ?>
        <div class="pennacademy-tab-link"> 
            <ul>
                
                <?php if( isset($data['categoryCurrent']->taxonomy) && $data['categoryCurrent']->taxonomy == 'car_cat' ): $title_active = ''; ?>
                    <?php
                        $news_id = get_page_id_by_template('templates/car-post.php');
                        // dd($news_id,false,false);
                    ?>
                    <?php if($news_id): ?>
                    <li class="item">
                    <a href="<?= get_the_permalink($news_id); ?>" ><?= _e('Tất cả', 'pennacademy'); ?></a>
                    </li>
                    <?php endif; ?>
                <?php else: ?>
                    <?php
                        $news_id = get_page_id_by_template('templates/car-post.php');
                    ?>
                    <?php if($news_id): ?>
                    <li class="item">
                    <a href="<?= get_the_permalink($news_id); ?>" class="active"><?= _e('Tất cả', 'pennacademy'); ?></a>
                    </li>
                    
                    <?php endif; ?>
                <?php endif; ?>

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
            <?$data['car']?>
            <?php if( $data['car']->have_posts() ): ?>
                    <?php while( $data['car']->have_posts() ): $data['car']->the_post(); ?> 
                        <?php
                            $news_ID = get_the_ID();

                            if (get_the_post_thumbnail_url()) {
                                $thumbnail = get_the_post_thumbnail_url($news_ID, 'iedg_blog_thumbnail');
                            } else {
                                $thumbnail = get_template_directory_uri(). '/html/dist/images/no-thumbnail.png';
                            }
                            
                            $title = get_the_title();
                            $link = get_the_permalink();
                            $description = get_the_excerpt();
                            $date = get_the_date('d/m/Y', $news_ID);
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
            </div>
        </div>
        <div class="iedg-pagination">
            <?= iedg_pagination($data['news'], 'list', '<svg role="img"><use xlink:href="#icon-arrow-prev"></use></svg>', '<svg role="img"><use xlink:href="#icon-arrow-next"></use></svg>'); ?>
        </div>
    </div>
</section>