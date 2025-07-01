<section class="pennacademy-news-details">
    <div class="container">
        <div class="row"> 
            <div class="col-lg-8">
                <?php
                    if (get_the_post_thumbnail_url()) {
                        $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    } else {
                        $thumbnail = get_template_directory_uri(). '/html/dist/images/no-thumbnail.png';
                    }    
                ?>
                <div class="pennacademy-news-details__banner">
                    <img class="lazy" data-src="<?= $thumbnail; ?>" alt="<?= sanitize_title(get_the_title()); ?>">
                </div>

                <h1 class="pennacademy-title"><?php the_title(); ?></h1>
                
                <div class="pennacademy-news-info">
                    <ul class="pennacademy-news-detail-link">
                        <?php if( isset($data['terms'][0]) ): ?>
                        <li>
                            <div class="pennacademy-news-details__cta">
                                <a href="<?= get_term_link($data['terms'][0]); ?>"><?= $data['terms'][0]->name; ?></a>
                            </div>
                        </li>
                        <?php endif; ?>

                        <li>
                            <div class="pennacademy-news-details__avatar">
                                <img class="lazy" data-src="<?= get_avatar_url($post->post_author); ?>" alt="<?= sanitize_title(get_the_author_meta('display_name', $post->post_author)); ?>">
                                <span><?= get_the_author_meta('display_name', $post->post_author); ?></span>
                            </div>
                        </li>

                        <li>
                            <div class="pennacademy-news-details__date"><?= get_the_date('d/m/Y', get_the_ID()); ?></div>
                        </li>

                        <?php if(comments_open()): ?>
                        <li>
                            <div class="pennacademy-news-details__comment">
                                <a class="js-anchor-scroll" href="#pennacademy-post-comment"><?php echo sprintf( __( '%s Bình luận', 'pennacademy' ), get_comments_number() ); ?></a>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="pennacademy-news-details__content">
                    <?php the_content(); ?>
                </div>

                <?php get_template_part('template-parts/single/news/comment'); ?>
            </div>

            
            <div class="col-lg-4">
                <?php if( isset($data['categories']) && is_array($data['categories']) && count($data['categories']) > 0 ): ?>
                <div class="pennacademy-news-details__categories">
                    <div class="pennacademy-news-details__inner">
                        <h3 class="pennacademy-categories-title"><?php _e('Danh mục', 'pennacademy'); ?></h3>
                        <ul>
                            <?php foreach( $data['categories'] as $cat ): ?>
                            <li>
                                <a href="<?= get_term_link($cat); ?>"><?= $cat->name; ?> (<?= $cat->count; ?>)</a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                <?php if( isset($data['more_articles']) && $data['more_articles']->have_posts() ): ?>
                <div class="pennacademy-news-details__post">
                    <div class="pennacademy-news-details__inner">
                        <h3 class="pennacademy-post-title"><?php _e('Bài viết gần nhất', 'pennacademy'); ?></h3>
                        <ul>
                            <?php while( $data['more_articles']->have_posts() ): $data['more_articles']->the_post(); ?>
                            <li><a href="<?= get_the_permalink(); ?>"><?= get_the_title(); ?></a></li>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                <?php if( isset($data['tags']) && is_array($data['tags']) && count($data['tags']) > 0 ): ?>
                <div class="pennacademy-news-details__tag">
                    <h3 class="pennacademy-tag-title"><?php _e('Tags', 'pennacademy'); ?></h3>
                    <div class="pennacademy-tag-link">
                        <ul>
                        <?php foreach( $data['tags'] as $tag):?>
                            <li>
                                <a href="<?= esc_attr( get_term_link($tag) ); ?>"><?=$tag->name; ?></a>
                            </li>
                        <?php endforeach; ?>     
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>