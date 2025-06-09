<?php if (isset($data['archive_link']) && !empty($data['archive_link'])) : ?>
    <section class="isa-back">
        <a href="<?= $data['archive_link']; ?>">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.5 8H0.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M5.5 13L0.5 8L5.5 3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span><?php _e('Quay lại', 'rt'); ?></span>
        </a>
    </section>
<?php endif;
