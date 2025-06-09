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
                        
                        <div class="rt-blog__inner--featured">
                            <?= !empty($data['featured']) ? $data['featured'] : ''; ?>
                            
                            <?php if(!empty($data['newest'])): ?>
                            <div class="rt-blog__inner--featured__item">
                                <h2 class="rt-title"><img class="lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/blog/flame.svg" width="16" alt=""><?php _e('Bài viết mới nhất', 'rt'); ?></h2>
                                <div class="blog-wrapper"><?= $data['newest']; ?></div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php if( isset($data['categories']) && is_array($data['categories']) && count($data['categories']) > 0): ?>   
                            <?php foreach($data['categories'] as $category): ?>    
                                <?php
                                    $postOfCategory = \RT\Core\Experience\ExperienceFunctions::getExperiences($category->term_id, 1, 2, $data['except']);  
                                    $icon = get_field("category_experience_icon", $category)
                                ?> 

                                <?php if($postOfCategory->have_posts()): ?>
                                <div class="rt-blog__inner--posts">
                                    <a class="title-wrapper" href="<?= get_term_link($category); ?>" title="<?= $category->name; ?>">
                                        <h2 class="rt-title">
                                            <?php if( isset($icon['url']) ): ?>
                                            <img class="lazy" data-src="<?= $icon['url']; ?>" width="16" alt="<?= $category->name; ?>">
                                            <?php endif; ?>
                                            
                                            <?= $category->name; ?>
                                        </h2>
                                        <span><?php _e("Xem thêm", "rt"); ?></span>
                                    </a>

                                    <div class="posts-wrapper">
                                        <?php while ($postOfCategory->have_posts()): $postOfCategory->the_post();?>
                                            <?php get_template_part('template-parts/common/post/post-item'); ?>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>