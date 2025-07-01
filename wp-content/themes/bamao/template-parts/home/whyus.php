<?php if (!empty($data['why_us_title'])): ?>
    <section class="rt-whyus">
        <div class="container">
            <div class="rt-whyus__inner" style="<?= !empty($data['why_us_bg']) && !empty($data['why_us_bg']['url']) ? '--bg: url(' . $data['why_us_bg']['url'] . ')' : ''; ?>">
                <div class="rt-whyus__left d-none d-lg-block">
                    <?php if (!empty($data['why_us_fg']) && !empty($data['why_us_fg']['url'])): ?>
                        <div class="rt-image">
                            <img src="<?= $data['why_us_fg']['url']; ?>">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="rt-whyus__right">
                    <h2 class="rt-title"><?= $data['why_us_title']; ?></h2>
                    <?php if (!empty($data['why_us_items'])): ?>
                        <div class="rt-whyus__items">
                            <?php foreach ($data['why_us_items'] as $item): ?>
                                <div class="rt-whyus__item">
                                    <?php if (!empty($item['icon']) && !empty($item['icon']['url'])): ?>
                                        <div class="rt-whyus__item--icon"><img src="<?= $item['icon']['url']; ?>"></div>
                                    <?php endif; ?>

                                    <?php if (!empty($item['title']) || !empty($item['entry'])): ?>
                                        <div class="rt-whyus__item--desc">
                                            <?php if (!empty($item['title'])): ?>
                                                <h3 class="rt-whyus__item--title"><?= $item['title']; ?></h3>
                                            <?php endif; ?>
                                            <?php if (!empty($item['entry'])): ?>
                                                <div class="rt-entry"><?= $item['entry']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>