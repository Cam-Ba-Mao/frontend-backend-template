<?php if (!empty($data['program_title'])): ?>
    <section class="rt-program">
        <div class="container">
            <h2 class="rt-title"><?= $data['program_title']; ?></h2>
            <?php if (!empty($data['program_items'])): ?>
                <div class="rt-program__items">
                    <?php foreach ($data['program_items'] as $item): ?>
                        <div class="rt-program__item">
                            <?php if (!empty($item['icon']) && !empty($item['icon']['url'])): ?>
                                <div class="rt-program__item--icon">
                                    <img src="<?= $item['icon']['url']; ?>">
                                </div>
                            <?php endif; ?>

                            <div class="rt-program__item--desc">
                                <?php if (!empty($item['title']) && !empty($item['cta'])): ?>
                                    <h3 class="rt-program__item--title">
                                        <a href="<?= $item['cta']; ?>"><?= $item['title']; ?></a>
                                    </h3>
                                <?php endif; ?>
                                <?php if (!empty($item['entry'])): ?>
                                    <div class="rt-entry"><?= $item['entry']; ?></div>
                                <?php endif; ?>

                                <?php if (!empty($item['entry']) && !empty($item['cta'])): ?>
                                    <div class="rt-program__item--more">
                                        <a href="<?= $item['cta']; ?>">
                                            <?= __('View more', 'rt'); ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M4.1665 10H15.8332" stroke="#193162" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M10 4.16663L15.8333 9.99996L10 15.8333" stroke="#193162" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>