<?php if (!empty($data['banner_title']) && !empty($data['banner_subtitle'])) : ?>
    <section class="rt-banner">
        <div class="rt-banner__inner">
            <div class="container">
                <?php if (!empty($data['banner_backlink']) && !empty($data['banner_backlink']['url'])) : ?>
                    <div class="rt-back">
                        <a href="<?= $data['banner_backlink']['url']; ?>" target="_self" title="<?= $data['banner_backlink']['title']; ?>">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.7499 12C20.7499 12.414 20.4139 12.75 19.9999 12.75H5.81091L8.53088 15.47C8.82388 15.763 8.82388 16.238 8.53088 16.531C8.38488 16.677 8.19285 16.751 8.00085 16.751C7.80885 16.751 7.61682 16.678 7.47082 16.531L3.47082 12.531C3.40182 12.462 3.34695 12.3791 3.30895 12.2871C3.23295 12.1041 3.23295 11.8971 3.30895 11.7141C3.34695 11.6221 3.40182 11.539 3.47082 11.47L7.47082 7.46999C7.76382 7.17699 8.23885 7.17699 8.53185 7.46999C8.82485 7.76299 8.82485 8.23803 8.53185 8.53103L5.81188 11.251H19.9999C20.4139 11.25 20.7499 11.586 20.7499 12Z" fill="#212121" />
                            </svg>
                            <span><?php _e('Quay lại', 'rt'); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($data['banner_thumb']) && !empty($data['banner_thumb']['url']) && !empty($data['banner_thumb_2']) && !empty($data['banner_thumb_2']['url'])) : ?>
                <div class="rt-banner__inner--content">
                    <div class="thumb-wrapper">
                        <img class="lazy" data-src="<?= $data['banner_thumb']['url']; ?>" alt="<?= $data['banner_thumb']['alt']; ?>">
                        <img class="position-absolute lazy" data-src="<?= $data['banner_thumb_2']['url']; ?>" alt="<?= $data['banner_thumb_2']['alt']; ?>">
                    </div>
                    <h2 class="text-wrapper">
                        <div class="rt-subtitle"><?= $data['banner_subtitle']; ?></div>
                        <div class="rt-title"><?= $data['banner_title']; ?></div>
                    </h2>
                </div>
            <?php endif; ?>

            <?php if (!empty($data['banner_figure_title']) && !empty($data['banner_figure_icon']) && !empty($data['banner_figures'])) : ?>
                <div class="rt-banner__inner--figures">
                    <?php if (!empty($data['banner_figure_title']) && !empty($data['banner_figure_icon']) && !empty($data['banner_figure_icon']['url'])) : ?>
                        <div class="figure-item">
                            <h2 class="sub-item">
                                <span><?= $data['banner_figure_title']; ?></span>
                                <img class="lazy" data-src="<?= $data['banner_figure_icon']['url']; ?>" width="64" alt="<?= $data['banner_figure_icon']['alt']; ?>">
                            </h2>
                        </div>
                    <?php endif; ?>

                    <?php if (is_array($data['banner_figures']) && count($data['banner_figures']) > 0 && !empty($data['banner_figure_text'])) : ?>
                        <div class="figure-item">
                            <?php foreach ($data['banner_figures'] as $figure) : ?>
                                <div class="sub-item">
                                    <?php if (!empty($figure['number'])) : ?>
                                        <mark><?= $figure['number']; ?></mark>
                                    <?php endif; ?>
                                    <?php if (!empty($figure['title'])) : ?>
                                        <span><?= $figure['title']; ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                            <div class="sub-item">
                                <div class="d-flex">
                                    <?php
                                    $arrows = "";
                                    ob_start();
                                    for ($i = 0; $i < 5; $i++) : ?>
                                        <svg class="<?= ($i <= 2) ? "d-none" : ""; ?> <?= ($i === 0) ? "d-xxl-block" : ($i === 1 ? "d-xl-block" : ($i === 2 ? "d-lg-block" : "")); ?>" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 20" fill="none">
                                            <path d="M15.7073 8.7071C15.5123 8.9021 15.2563 9.00007 15.0003 9.00007C14.7443 9.00007 14.4882 8.9021 14.2933 8.7071L9.00028 3.41413V19.0001C9.00028 19.5521 8.55328 20.0001 8.00028 20.0001C7.44728 20.0001 7.00028 19.5521 7.00028 19.0001V3.41413L1.70731 8.7071C1.31631 9.0981 0.68425 9.0981 0.29325 8.7071C-0.09775 8.3161 -0.09775 7.68403 0.29325 7.29304L7.29227 0.294012C7.38527 0.201012 7.4952 0.127971 7.6182 0.0769707C7.8622 -0.0240293 8.13836 -0.0240293 8.38236 0.0769707C8.50536 0.127971 8.61529 0.201012 8.70829 0.294012L15.7073 7.29304C16.0983 7.68403 16.0983 8.3161 15.7073 8.7071Z" fill="#FFFFFF"></path>
                                        </svg>
                                    <?php endfor;
                                    $arrows = ob_get_clean();
                                    ?>
                                    <div class="arrows arrow-left">
                                        <?= $arrows; ?>
                                    </div>
                                    <p><strong><?= $data['banner_figure_text']; ?></strong></p>
                                    <div class="arrows arrow-right">
                                        <?= $arrows; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>