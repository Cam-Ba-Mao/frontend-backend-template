<?php if (!empty($data['stories_title'])): ?>
    <section class="gobs-stories">
        <div class="gobs-stories__wrap">
            <div class="container">
                <div class="gobs-stories__head">
                    <div class="gobs-title"><?= $data['stories_title']; ?></div>

                    <?php if (!empty($data['stories_desc'])): ?>
                        <div class="gobs-stories__head--desc rt-entry"></div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($data['stories_slides']) && is_array($data['stories_slides'])): ?>
                    <div class="row">
                        <div class="col-md-5 col-lg-4">
                            <div class="gobs-stories__slider slider-content swiper swiper-container" data-duration="4">
                                <div class="swiper-wrapper">
                                    <?php $image = ""; ?>
                                    <?php foreach ($data['stories_slides'] as $item): ?>
                                        <div class="swiper-slide">
                                            <div class="gobs-stories__content rt-entry">
                                                <?php if (!empty($item['name']) && !empty($item['note']) && !empty($item['content']) && !empty($item['image'])): ?>
                                                    <p>
                                                        <strong><?= $item['name']; ?></strong>
                                                        <span><?= $item['note']; ?></span>
                                                    </p>
                                                    <?= $item['content']; ?>
                                                    <?php
                                                    ob_start();
                                                    ?>
                                                    <?php if (is_array($item['image']) && !empty($item['image']['url'])): ?>
                                                        <div class="swiper-slide">
                                                            <div class="stories-slide">
                                                                <div class="stories-slide__image">
                                                                    <img src="<?= $item['image']['url']; ?>" alt="<?= !empty($item['image']['title']) ? $item['image']['title'] : ""; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php
                                                    $image .= ob_get_clean();
                                                    ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="rt-swiper-arrow">
                                <div class="rt-swiper-arrow__prev">
                                    <div class="rt-swiper-arrow__prev--inner"><svg width="52" height="38" viewBox="0 0 52 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M42 19H8" stroke="#193162" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M18.9092 30.0834L7.87891 19.0001L18.9092 7.91675" stroke="#193162" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="rt-swiper-arrow__next">
                                    <div class="rt-swiper-arrow__next--inner"><svg width="52" height="38" viewBox="0 0 52 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 19H44" stroke="#193162" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M33.0908 30.0834L44.1211 19.0001L33.0908 7.91675" stroke="#193162" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-8">
                            <div class="gobs-stories__top">
                                <div class="gobs-stories__slider slider-image swiper swiper-container" data-duration="4">
                                    <div class="swiper-wrapper"><?= $image; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>