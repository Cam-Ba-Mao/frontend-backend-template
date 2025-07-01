<?php if( isset($data['home_testimonial_title']) && !empty($data['home_testimonial_title']) ): ?>
<section class="pennacademy-testimonial" id="cau-chuyen-hoc-vien">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="pennacademy-testimonial__wrap">
                    <div class="pennacademy-testimonial__wrap--img">
                        <img class="lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/home/parentheses.svg" alt="parentheses.svg">
                    </div>
                    <div class="pennacademy-testimonial__wrap--title">
                        <h2><?= $data['home_testimonial_title']; ?></h2>
                    </div>
                    <?php if( isset($data['home_testimonial_desc']) && !empty($data['home_testimonial_desc']) ): ?>
                    <div class="pennacademy-testimonial__wrap--desc">
                        <p><?= $data['home_testimonial_desc']; ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if( isset($data['home_testimonial_cta']['title']) && !empty($data['home_testimonial_cta']['title']) ): ?>
                    <div class="pennacademy-testimonial__wrap--cta">
                        <a class="iedg-btn iedg-btn-primary" href="<?= $data['home_testimonial_cta']['url']; ?>" target="<?= $data['home_testimonial_cta']['target']; ?>"><?= $data['home_testimonial_cta']['title']; ?>
                            <svg role="img">
                                <use xlink:href="#icon-arrow-e"></use>
                            </svg></a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if( isset($data['home_testimonial_list']) && is_array($data['home_testimonial_list']) && count($data['home_testimonial_list']) > 0): ?>
            <div class="col-lg-7">
                <div class="row rowtestimonial">
                    <?php foreach($data['home_testimonial_list'] as $key => $testimonial): ?>
                        <?php if( ($key + 1) % ( ceil(count($data['home_testimonial_list']) / 2) ) == 1 ): ?>
                            <div class="col-lg-6 pennacademy-col-testimonial">
                                <div class="pennacademy-col-testimonial-inner">
                        <?php endif; ?>

                                <div class="pennacademy-testimonial__item">
                                    <div class="pennacademy-testimonial__body">
                                        <div class="pennacademy-testimonial__body--img">
                                            <img class="lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/home/star.svg" alt="">
                                        </div>
                                        <div class="pennacademy-testimonial__body--content">
                                            <p><?= $testimonial['description']; ?></p>
                                        </div>
                                    </div>
                                    <div class="pennacademy-testimonial__footer">
                                        <div class="pennacademy-testimonial__img iedg-img-drop">
                                            <img class="lazy" data-src="<?= $testimonial['thumbnail']['url']; ?>" alt="<?= $testimonial['thumbnail']['alt']; ?>">
                                        </div>
                                        <div class="pennacademy-testimonial__info">
                                            <div class="pennacademy-testimonial__info--name"><?= $testimonial['name']; ?></div>
                                            <div class="pennacademy-testimonial__info--class"><?= $testimonial['class']; ?></div>
                                        </div>
                                    </div>
                                </div>

                        <?php if( ($key + 1) % ( ceil(count($data['home_testimonial_list']) / 2) ) == 0 || ($key+1) == count($data['home_testimonial_list']) ): ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>