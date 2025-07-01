<?php if (!empty($data['join_us_title'])): ?>
    <section class="gobs-join">
        <div class="container">
            <div class="gobs-join__content">
                <h2 class="gobs-join__title"><?= $data['join_us_title']; ?></h2>
                <?php if (!empty($data['join_us_desc'])): ?>
                    <div class="gobs-join__desc"><?= $data['join_us_desc']; ?></div>
                <?php endif; ?>

                <?php if (!empty($data['join_us_cta']) && !empty($data['join_us_cta']['url'])): ?>
                    <a class="gobs-btn" href="<?= $data['join_us_cta']['url']; ?>">
                        <?= $data['join_us_cta']['title']; ?>
                        <svg width="19" height="25" viewBox="0 0 19 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.1531 19.5L9.16877 18.5284L13.2213 14.4759H2.72559V13.0696H13.2213L9.16877 9.02983L10.1531 8.04545L15.8804 13.7727L10.1531 19.5Z" fill="white" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>