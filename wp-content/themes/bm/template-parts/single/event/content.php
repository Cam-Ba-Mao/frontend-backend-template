<section class="rt-event__loop">
    <div class="container">
        <?php if (!empty($data['event_muc_dich'])) : ?>
            <div class="rt-event__loop--item">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="rt-block__image">
                            <img class="lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/event/icon-1.svg" alt="icon">
                        </div>
                        <div class="rt-block__title">
                            <h2 class="rt-title"><?= _e('Mục đích tổ chức', 'rt'); ?></h2>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="rt-block__editor"><?= $data['event_muc_dich']; ?></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($data['event_quy_mo_su_kien'])) : ?>
            <div class="rt-event__loop--item">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="rt-block__image">
                            <img class="lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/event/icon-2.svg" alt="icon">
                        </div>
                        <div class="rt-block__title">
                            <h2 class="rt-title"><?= _e('Quy mô sự kiện', 'rt'); ?></h2>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="rt-block__editor"><?= $data['event_quy_mo_su_kien']; ?></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty(get_the_content())) : ?>
            <div class="rt-event__loop--item">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="rt-block__image">
                            <img class="lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/event/icon-3.svg" alt="icon">
                        </div>
                        <div class="rt-block__title">
                            <h2 class="rt-title"><?= _e('Nội dung sự kiện', 'rt'); ?></h2>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="rt-block__editor"><?= apply_filters('the_content', get_the_content()); ?></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>