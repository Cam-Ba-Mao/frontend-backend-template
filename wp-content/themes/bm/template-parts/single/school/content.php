<?php if(! empty(get_the_content())) : ?>
<section class="rt-school__content rt-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="rt-blog__sidebar d-none d-lg-block">
                    <?php get_template_part('template-parts/common/toc'); ?>
                    <?php get_template_part('template-parts/common/sidebar-form'); ?>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="rt-details__content">
                    <div class="d-block d-lg-none">
                        <?php get_template_part('template-parts/common/toc'); ?>
                    </div>
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>
                </div>
                <div class="col-12 d-block d-lg-none">
                    <?php get_template_part('template-parts/common/sidebar-form'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>