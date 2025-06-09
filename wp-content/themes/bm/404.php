<?php
/**
 * The template for displaying 404 pages (not found)
 * @package Iedg
 */ 
get_header(); 
?>
<section class="rt-404">
    <div class="container"> 
        <div class="row"> 
            <div class="col-md-6">
                <div class="rt-404__inner"> 
                    <div class="rt-404__subtitle"><?php _e('404', 'rt'); ?></div>
                    <h1 class="rt-404__title"><?php _e('Trang không tồn tại', 'rt'); ?></h1>
                    <div class="rt-404__desc"><?php _e('Chúng tôi xin lỗi, không thể tìm thấy trang bạn yêu cầu.', 'rt'); ?></div>
                    <div class="rt-404__cta">
                        <a class="rt-btn rt-btn-primary" href="#"><?php _e('Trang chủ', 'rt'); ?></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="rt-404__image"> <img class="lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/404/404.svg" alt="404"></div>
            </div>
        </div>
    </div>
</section>  
<?php get_template_part('template-parts/common/gift'); ?>  
<?php
get_footer();