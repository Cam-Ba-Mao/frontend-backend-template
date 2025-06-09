<?php 
    $data_tab = '';
?>
<?php if(!empty($data['prestigious_university_title'])): ?>
<section class="isa-prestigious-university">
    <div class="container">
        <div class="isa-prestigious-university__header">
            <?php if(!empty($data['prestigious_university_subtitle'])): ?>
            <div class="isa-prestigious-university__header--sub-title"><?= $data['prestigious_university_subtitle']; ?></div>
            <?php endif; ?>
            <h2 class="isa-title"><?= $data['prestigious_university_title']; ?></h2>
        </div>
        <?php if( isset($data['prestigious_university_tab']) && is_array($data['prestigious_university_tab']) && count($data['prestigious_university_tab']) ): ?>
        <div class="isa-prestigious-university__mobile">
            <div class="isa-prestigious-university__nav">
                <ul class="nav nav-tabs" id="UniversityTab" role="tablist">
                    <?php foreach($data['prestigious_university_tab'] as $key => $tab): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $key == 0 ? 'active' : ''; ?>" id="prestigious-university-tab-<?= $key + 1 ?>" data-bs-toggle="tab" data-bs-target="#prestigious-university-tab-<?= $key + 1 ?>-content" type="button" role="tab" aria-controls="prestigious-university-tab-<?= $key + 1 ?>-content" aria-selected="<?= $key == 0 ? 'true' : 'false'; ?>">
                            <img src="<?= $tab['tab_icon']['url']; ?>" alt="<?= sanitize_title($tab['tab_icon']['title']); ?>">
                            <span><?= $tab['tab_name']; ?></span>
                        </button>
                    </li>
                    <?php ob_start(); ?>
                    <div class="tab-pane fade <?= $key == 0 ? 'show active' : ''; ?>" id="prestigious-university-tab-<?= $key + 1 ?>-content" role="tabpanel" aria-labelledby="prestigious-university-tab-<?= $key + 1 ?>">
                        <div class="isa-prestigious-university__list swiper swiper-container">
                            <?php if( isset($tab['slider']) && is_array($tab['slider']) && count($tab['slider']) ): ?>
                            <div class="swiper-wrapper">
                                <?php foreach($tab['slider'] as $slider): ?>
                                <?php 
                                    $state = '';
                                    $country = '';
                                    $post_id = $slider -> ID;
                                    $post_title = $slider -> post_title;
                                    $post_link = get_the_permalink($post_id);
                                    $country_state_detail = get_the_terms($post_id,'school_country_state');
                                    $school_type_detail = get_the_terms($post_id,'school_type');
                                    $post_fields = get_fields($post_id);

                                    if(is_array($country_state_detail) && count($country_state_detail) > 0) {
                                        foreach($country_state_detail as $country_state) {
                                            if($country_state->parent == 0) {
                                                $country = $country_state->name;
                                            } else {
                                                $state = $country_state->name;
                                            }
                                        }
                                    }

                                    if (get_the_post_thumbnail_url($post_id)) {
                                        $thumbnail = get_the_post_thumbnail_url($post_id, 'rt_blog_large');
                                    } else {
                                        $thumbnail = get_template_directory_uri(). '/html/dist/images/no-image-avaliable.jpg';
                                    }

                                    // $terms = get_the_terms( $post->ID, 'product_svl' );
                                    // if ( $category_detail && ! is_wp_error( $category_detail ) ) {
                                    //     $draught_links = array();
                                    //     foreach ( $category_detail as $term ) {
                                    //         $draught_links[] = $term->name;
                                    //     }
                                    //     $on_draught = join( ", ", $draught_links );
                                    // }
                                                                        
                                ?>
                                <div class="swiper-slide">
                                    <div class="isa-prestigious-university__scale" style="background-image: url('<?= $thumbnail; ?>'); ">
                                        <div class="isa-prestigious-university__wrap">
                                            <div class="content-top">
                                                <!-- <div class="content-top__subtitle"></div> -->
                                                <div class="content-top__title"><?= $post_title; ?></div>
                                                <div class="content-top__cta">
                                                    <a class="rt-btn rt-btn-primary" href="<?= $post_link; ?>">
                                                        <?php _e('Xem chi tiết', 'rt'); ?>
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M20.5 4V9C20.5 9.276 20.276 9.5 20 9.5C19.724 9.5 19.5 9.276 19.5 9V5.20703L11.354 13.353C11.256 13.451 11.128 13.499 11 13.499C10.872 13.499 10.744 13.45 10.646 13.353C10.451 13.158 10.451 12.841 10.646 12.646L18.792 4.5H15C14.724 4.5 14.5 4.276 14.5 4C14.5 3.724 14.724 3.5 15 3.5H20C20.065 3.5 20.1299 3.51306 20.1909 3.53906C20.3139 3.59006 20.4109 3.68706 20.4619 3.81006C20.4869 3.87006 20.5 3.935 20.5 4ZM20 12.5C19.724 12.5 19.5 12.724 19.5 13V17C19.5 18.729 18.729 19.5 17 19.5H7C5.271 19.5 4.5 18.729 4.5 17V7C4.5 5.271 5.271 4.5 7 4.5H11C11.276 4.5 11.5 4.276 11.5 4C11.5 3.724 11.276 3.5 11 3.5H7C4.71 3.5 3.5 4.71 3.5 7V17C3.5 19.29 4.71 20.5 7 20.5H17C19.29 20.5 20.5 19.29 20.5 17V13C20.5 12.724 20.276 12.5 20 12.5Z" fill="white"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="content-bottom">
                                                <div class="content-bottom__list">
                                                    <?php if(!empty($country)): ?>  
                                                    <div class="content-bottom__item">
                                                        <img class="content-bottom__item--img" src="<?= get_template_directory_uri(); ?>/html/dist/images/home/icon-globe-earth.svg" alt="">
                                                        <div class="content-bottom__item--title"><?php _e('Quốc gia', 'rt'); ?></div>
                                                        <div class="content-bottom__item--desc"><?= $country; ?></div>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if(!empty($state)): ?>                                                    
                                                    <div class="content-bottom__item">
                                                        <img class="content-bottom__item--img" src="<?= get_template_directory_uri(); ?>/html/dist/images/home/icon-building-tree.svg" alt="">
                                                        <div class="content-bottom__item--title"><?php _e('Tỉnh bang/Thành phố', 'rt'); ?></div>
                                                        <div class="content-bottom__item--desc"><?= $state; ?></div>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if($schoolTypes = \RT\Core\School\SchoolFunctions::getSchoolTypeByPostId($post_id, 'name')) : ?>
                                                    <div class="content-bottom__item">
                                                        <img class="content-bottom__item--img" src="<?= get_template_directory_uri(); ?>/html/dist/images/home/icon-graduation-cap.svg" alt="">
                                                        <div class="content-bottom__item--title"><?php _e('Bậc học', 'rt'); ?></div>
                                                        <div class="content-bottom__item--desc"><?= $schoolTypes; ?></div>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if($schoolFee = \RT\Core\School\SchoolFunctions::getSchoolFeeByPostId($post_id)) : ?>
                                                    <div class="content-bottom__item">
                                                        <img class="content-bottom__item--img" src="<?= get_template_directory_uri(); ?>/html/dist/images/home/icon-invoice.svg" alt="">
                                                        <div class="content-bottom__item--title"><?php _e('Học phí tham khảo', 'rt'); ?></div>
                                                        <div class="content-bottom__item--desc"><?= $schoolFee; ?></div>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="container isa-slider-prestigious-university-container">
                                <div class="isa-prestigious-university__pagination">
                                    <div class="isa-prestigious-university__pagination--nav"><span></span></div>
                                    <div class="isa-prestigious-university__pagination--count"><span class="current">1</span><span class="fraction-divider">&nbsp;-&nbsp;</span><span class="total">5</span></div>
                                </div>
                            </div>
                            <div class="isa-swiper-prev">
                                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="32" cy="32" r="32" fill="#FAF7F0"/>
                                    <path d="M41.5 31.5L21.5 31.5" stroke="#212121" stroke-miterlimit="10"/>
                                    <path d="M28.5 38.5L21.5 31.5L28.5 24.5" stroke="#212121" stroke-miterlimit="10" stroke-linecap="square"/>
                                </svg>
                            </div>
                            <div class="isa-swiper-next">
                                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="32" cy="32" r="32" fill="#FAF7F0"/>
                                    <path d="M22.5 32.5H42.5" stroke="#212121" stroke-miterlimit="10"/>
                                    <path d="M35.5 25.5L42.5 32.5L35.5 39.5" stroke="#212121" stroke-miterlimit="10" stroke-linecap="square"/>
                                </svg>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php $data_tab .= ob_get_clean(); ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="container-fluid px-0">
        <div class="tab-content" id="UniversityTabContent">
            <?php if( !empty($data_tab) ): ?>
                <?= $data_tab; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>