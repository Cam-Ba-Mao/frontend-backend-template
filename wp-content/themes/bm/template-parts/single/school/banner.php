<?php $ID = get_the_ID(); ?>
<section class="rt-school__banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php if(get_field('video_link')) : ?>
                <a class="rt-school__feature rt-light-gallery" href="#" data-sources='[{ "src": "<?= get_field('video_link'); ?>",  "thumb" : "<?= get_the_post_thumbnail_url($ID, 'rt_blog_large'); ?>", "subHtml" : "" }]'>
                    <div class="post-images">
                        <img class="school-img lazy" data-src="<?= get_the_post_thumbnail_url($ID, 'rt_blog_large'); ?>" alt="<?php the_title(); ?>">
                        <?php if(! empty($data['school_logo']['url']) and isset($data['school_logo']['alt'])) : ?>
                        <img class="school-logo lazy" data-src="<?= $data['school_logo']['url']; ?>" alt="<?= $data['school_logo']['alt']; ?>">
                        <?php endif; ?>
                    </div>
                    <button class="post-video btn-play" type="button"></button>
                </a>
                <?php else: ?>
                <div class="rt-school__feature">
                    <div class="post-images">
                        <img class="school-img lazy" data-src="<?= get_the_post_thumbnail_url($ID, 'rt_blog_large'); ?>" alt="<?php the_title(); ?>">
                        <?php if(! empty($data['school_logo']['url']) and isset($data['school_logo']['alt'])) : ?>
                        <img class="school-logo lazy" data-src="<?= $data['school_logo']['url']; ?>" alt="<?= $data['school_logo']['alt']; ?>">
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                <ul class="rt-school__metadata">
                    <?php if($schoolCountry = \RT\Core\School\SchoolFunctions::getSchoolCountryByPostId($ID, 'name')) : ?>
                    <li>
                        <img class="rt-school__metadata--image lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/schools/globe-earth.svg" alt="globe-earth"><strong class="rt-school__metadata--label"><?= __('Quốc gia', 'rt'); ?></strong>
                        <span class="rt-school__metadata--value"><?= $schoolCountry; ?></span>
                    </li>
                    <?php if($schoolState = \RT\Core\School\SchoolFunctions::getSchoolStateByPostId($ID, 'name')) : ?>
                    <li>
                        <img class="rt-school__metadata--image lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/schools/building-tree.svg" alt="building-tree"><strong class="rt-school__metadata--label"><?= __('Tỉnh bang/Thành phố', 'rt'); ?></strong>
                        <span class="rt-school__metadata--value"><?= $schoolState; ?></span>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if($schoolTypes = \RT\Core\School\SchoolFunctions::getSchoolTypeByPostId($ID, 'name')) : ?>
                    <li>
                        <img class="rt-school__metadata--image lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/schools/graduation-cap.svg" alt="graduation-cap"><strong class="rt-school__metadata--label"><?= __('Bậc học', 'rt'); ?></strong>
                        <span class="rt-school__metadata--value"><?= $schoolTypes; ?></span>
                    </li>
                    <?php endif; ?>

                    <?php if($schoolFee = \RT\Core\School\SchoolFunctions::getSchoolFeeByPostId($ID)) : ?>
                    <li>
                        <img class="rt-school__metadata--image lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/schools/invoice.svg" alt="invoice">
                        <strong class="rt-school__metadata--label"><?= __('Học phí tham khảo', 'rt'); ?></strong>
                        <span class="rt-school__metadata--value"><?= $schoolFee; ?></span>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-lg-4">
                <div class="rt-school__detail">
                    <h1 class="rt-title"><?php the_title(); ?></h1>
                    <?php if(! empty($data['school_address']) or ! empty($data['school_website'])) : ?>
                    <ul class="post-info">
                        <?php if(! empty($data['school_address'])) : ?>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M20.5 9.5C20.5 14.4 12.5 22.5 12.5 22.5C12.5 22.5 4.5 14.4 4.5 9.5C4.5 4.4 8.6 1.5 12.5 1.5C16.4 1.5 20.5 4.4 20.5 9.5Z" stroke="white" stroke-miterlimit="10" stroke-linecap="square"></path>
                                <path d="M12.5 12.5C14.1569 12.5 15.5 11.1569 15.5 9.5C15.5 7.84315 14.1569 6.5 12.5 6.5C10.8431 6.5 9.5 7.84315 9.5 9.5C9.5 11.1569 10.8431 12.5 12.5 12.5Z" stroke="white" stroke-miterlimit="10" stroke-linecap="square"></path>
                            </svg>
                            <span><?= get_field('school_address'); ?></span>
                        </li>
                        <?php endif; ?>

                        <?php if(! empty($data['school_website'])) : ?>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M12 1.49622C6.21 1.49622 1.5 6.19439 1.5 11.9699C1.5 17.7453 6.21 22.4435 12 22.4435C17.79 22.4435 22.5 17.7453 22.5 11.9699C22.5 6.19439 17.79 1.49622 12 1.49622ZM21.475 11.4711H16.923C16.827 8.51455 15.884 5.48019 14.211 2.76402C18.227 3.72361 21.252 7.22979 21.475 11.4711ZM12.87 2.5376C14.747 5.28269 15.817 8.42278 15.923 11.4711H8.077C8.183 8.42278 9.25301 5.28269 11.13 2.5376C11.417 2.51167 11.706 2.49371 12 2.49371C12.294 2.49371 12.583 2.51167 12.87 2.5376ZM9.789 2.76402C8.117 5.48118 7.174 8.51555 7.077 11.4711H2.52499C2.74799 7.22979 5.773 3.72361 9.789 2.76402ZM2.52499 12.4686H7.077C7.173 15.4252 8.116 18.4595 9.789 21.1757C5.773 20.2161 2.74799 16.7099 2.52499 12.4686ZM11.13 21.4021C9.25301 18.657 8.183 15.5169 8.077 12.4686H15.923C15.817 15.5169 14.747 18.657 12.87 21.4021C12.583 21.428 12.294 21.446 12 21.446C11.706 21.446 11.417 21.428 11.13 21.4021ZM14.211 21.1757C15.883 18.4585 16.826 15.4242 16.923 12.4686H21.475C21.252 16.7099 18.227 20.2161 14.211 21.1757Z"
                                    fill="white"
                               >
                            </svg>
                            <a href="<?= strpos(get_field('school_website'), '://') ? get_field('school_website') : 'https://'.get_field('school_website'); ?>" target="_blank"><?= get_field('school_website'); ?></a>
                        </li>
                        <?php endif; ?>

                    </ul>
                    <?php endif; ?>
                    
                    <!-- Excerpt -->
                    <?php if(!empty($post->post_excerpt)) : ?>
                    <div class="post-excerpt">
                        <span><?= $post->post_excerpt; ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Galleries -->
                    <?php if(! empty($data['school_galleries'])) : ?>
                    <div class="post-galleries rt-light-gallery-list">
                        <?php foreach($data['school_galleries'] as $img) : ?>
                        <div class="post-gallery rt-light-gallery-item">
                            <img class="school-logo lazy" data-src="<?= $img['url']; ?>" alt="<?= $img['alt']; ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- CTA -->
                    <div class="rt-cta__button">
                        <a class="btn btn-primary js-anchor-scroll" href="#rt-details__form">
                            <span><?= __('Đăng ký tư vấn', 'rt'); ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M11.5 19C11.5 19.276 11.276 19.5 11 19.5H5C2.71 19.5 1.5 18.29 1.5 16V7C1.5 4.71 2.71 3.5 5 3.5H17C19.29 3.5 20.5 4.71 20.5 7V10C20.5 10.276 20.276 10.5 20 10.5C19.724 10.5 19.5 10.276 19.5 10V7C19.5 5.271 18.729 4.5 17 4.5H5C3.271 4.5 2.5 5.271 2.5 7V16C2.5 17.729 3.271 18.5 5 18.5H11C11.276 18.5 11.5 18.724 11.5 19ZM16.9041 7.70599C16.7411 7.48199 16.4271 7.43399 16.2061 7.59599L11.2939 11.168C11.1179 11.296 10.8821 11.295 10.7061 11.168L5.79395 7.59599C5.57095 7.43399 5.25895 7.48199 5.09595 7.70599C4.93395 7.92899 4.98305 8.24201 5.20605 8.40401L10.1179 11.976C10.3819 12.168 10.69 12.264 11 12.264C11.309 12.264 11.6181 12.168 11.8821 11.976L16.7939 8.40401C17.0179 8.24201 17.0661 7.92899 16.9041 7.70599ZM22.5 14.881C22.499 15.253 22.3541 15.601 22.0911 15.863L16.575 21.354C16.481 21.447 16.3539 21.5 16.2219 21.5H14C13.724 21.5 13.5 21.276 13.5 21V18.778C13.5 18.646 13.553 18.519 13.646 18.425L19.137 12.909C19.399 12.645 19.7479 12.5 20.1189 12.5C20.1199 12.5 20.1201 12.5 20.1211 12.5C20.4911 12.5 20.8401 12.645 21.1021 12.907L22.092 13.898C22.355 14.16 22.5 14.51 22.5 14.881ZM19.864 16.67L18.3311 15.136L14.5 18.984V20.5H16.0171L19.864 16.67ZM21.5 14.88C21.5 14.776 21.459 14.678 21.386 14.605L20.396 13.614C20.323 13.54 20.2251 13.5 20.1221 13.5H20.1211C20.0171 13.5 19.9199 13.541 19.8469 13.614L19.0381 14.427L20.574 15.964L21.387 15.154C21.459 15.081 21.5 14.984 21.5 14.88Z"
                                    fill="white"
                               >
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
