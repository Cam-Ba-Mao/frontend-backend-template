<?php if (!empty($data['banner_img']) && !empty($data['banner_img']['url'])): ?>
    <section class="rt-banner" style="--bg: url('<?= $data['banner_img']['url']; ?>')">
        <div class="container">
            <div class="rt-banner__inner">
                <div class="rt-banner__left">
                    <?php if (!empty($data['banner_title'])): ?>
                        <div class="rt-title"><?= $data['banner_title']; ?></div>
                    <?php endif; ?>

                    <?php if (!empty($data['banner_desc'])): ?>
                        <div class="rt-banner__desc"><?= $data['banner_desc']; ?></div>
                    <?php endif; ?>

                    <?php if (!empty($data['banner_consult_btn']) || !empty($data['banner_view_btn'])): ?>
                        <div class="buttons">
                            <?php if (!empty($data['banner_consult_btn']) && !empty($data['banner_consult_btn']['url'])): ?>
                                <a class="rt-btn btn-shadow" href="<?= $data['banner_consult_btn']['url']; ?>"><?= $data['banner_consult_btn']['title']; ?></a>
                            <?php endif; ?>

                            <?php if (!empty($data['banner_view_btn']) && !empty($data['banner_view_btn']['url'])): ?>
                                <a class="rt-btn btn-icon" href="<?= $data['banner_view_btn']['url']; ?>">
                                    <?= $data['banner_view_btn']['title']; ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44" fill="none">
                                        <path d="M13.1612 22H30.8388" stroke="#D6EFFF" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M22 13.1612L30.8388 22L22 30.8389" stroke="#D6EFFF" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (!empty($data['banner_follow_us']) && is_array($data['banner_follow_us'])): ?>
            <div class="rt-banner__follow-us">
                <div class="line"></div>
                <div class="text"><?= __('Follow Us:', 'rt'); ?></div>
                <ul>
                    <?php foreach ($data['banner_follow_us'] as $item): ?>
                        <li>
                            <?php if (!empty($item['icon']) && !empty($item['icon']['url']) && !empty($item['link']) && !empty($item['link']['url'])): ?>
                                <a href="<?= $item['link']['url']; ?>" target="_blank">
                                    <img src="<?= $item['icon']['url']; ?>" alt="<?= !empty($item['icon']['title']) ? $item['icon']['title'] : ""; ?>">
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>