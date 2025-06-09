<section class="isa-contact-us" id="contact-us">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-7">
                <div class="isa-contact-us__content">
                    <?php if (isset($data['contact_form_title']) && !empty($data['contact_form_title'])) : ?>
                        <h2 class="isa-title isa-title__medium"><?= $data['contact_form_title']; ?></h2>
                    <?php endif; ?>
                    <?php if (isset($data['contact_form']) && !empty($data['contact_form'])) : ?>
                        <div class="isa-contact-us__form">
                            <?= do_shortcode('[wpforms id="' . $data["contact_form"] . '"]'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-12 col-lg-5">
                <div class="isa-contact-us__info">
                    <h3 class="isa-title isa-contact-us__info--title"><?php _e('Thông tin liên hệ', 'rt'); ?></h3>
                    <ul>
                        <?php if (isset($data['contact_info_address']) && !empty($data['contact_info_address'])) : ?>
                            <li class="location">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.0833 7.91667C17.0833 12 10.4167 18.75 10.4167 18.75C10.4167 18.75 3.75 12 3.75 7.91667C3.75 3.66667 7.16667 1.25 10.4167 1.25C13.6667 1.25 17.0833 3.66667 17.0833 7.91667Z" stroke="#212121" stroke-miterlimit="10" stroke-linecap="square" />
                                    <path d="M10.417 10.416C11.7977 10.416 12.917 9.29673 12.917 7.91602C12.917 6.5353 11.7977 5.41602 10.417 5.41602C9.03628 5.41602 7.91699 6.5353 7.91699 7.91602C7.91699 9.29673 9.03628 10.416 10.417 10.416Z" stroke="#212121" stroke-miterlimit="10" stroke-linecap="square" />
                                </svg>
                                <span><?= $data['contact_info_address']; ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if (isset($data['contact_info_phone']) && !empty($data['contact_info_phone'])) : ?>
                            <li class="tel">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.1733 12.2405L11.3892 14.0005C10.4587 13.4395 9.59442 12.7756 8.81249 12.0213C8.05936 11.2381 7.39557 10.3736 6.83332 9.44384L8.59166 7.65968C8.69815 7.55153 8.77007 7.41415 8.79827 7.26502C8.82646 7.11588 8.80966 6.96173 8.74999 6.82218L6.91666 2.54884C6.84423 2.38034 6.71368 2.24347 6.54879 2.16317C6.38389 2.08286 6.19564 2.06447 6.01832 2.11134L2.65666 3.00051C2.48878 3.04403 2.34065 3.14324 2.2365 3.28191C2.13234 3.42058 2.07834 3.59049 2.08332 3.76384C2.29722 7.67365 3.92287 11.373 6.65832 14.1747C9.46055 16.911 13.1609 18.537 17.0717 18.7505C17.2452 18.7563 17.4155 18.7028 17.5544 18.5987C17.6934 18.4946 17.7927 18.3462 17.8358 18.178L18.7242 14.8147C18.7713 14.6375 18.7531 14.4492 18.6729 14.2843C18.5927 14.1194 18.4559 13.9888 18.2875 13.9163L14.0133 12.0838C13.8736 12.0233 13.719 12.0059 13.5694 12.0338C13.4197 12.0617 13.2818 12.1337 13.1733 12.2405V12.2405Z" stroke="#212121" stroke-miterlimit="10" stroke-linecap="square" />
                                </svg>
                                <a href="tel:<?= $data['contact_info_phone']; ?>" target="_blank"><?= $data['contact_info_phone']; ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (isset($data['contact_info_email']) && !empty($data['contact_info_email'])) : ?>
                            <li class="email">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_506_7313)">
                                        <path d="M1.76172 3.38086L10.4167 11.2492L19.0709 3.38169" stroke="#212121" stroke-miterlimit="10" />
                                        <path d="M17.9167 2.91602H2.91667C1.99619 2.91602 1.25 3.66221 1.25 4.58268V16.2493C1.25 17.1698 1.99619 17.916 2.91667 17.916H17.9167C18.8371 17.916 19.5833 17.1698 19.5833 16.2493V4.58268C19.5833 3.66221 18.8371 2.91602 17.9167 2.91602Z" stroke="#212121" stroke-miterlimit="10" stroke-linecap="square" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_506_7313">
                                            <rect width="20" height="20" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <a href="mailto:<?= $data['contact_info_email']; ?>" target="_blank"><?= $data['contact_info_email']; ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <?php if (isset($data['contact_related_pages']) && is_array($data['contact_related_pages']) && count($data['contact_related_pages'])) : ?>
                        <div class="isa-contact-us__related">
                            <h3 class="isa-title isa-contact-us__info--title"><?php _e('Bài viết liên quan', 'rt'); ?></h3>
                            <?php foreach ($data['contact_related_pages'] as $item) : ?>
                                <a class="rt-btn rt-btn-outline-primary" href="<?= $item['link']['url']; ?>" target="_blank"><span><?= $item['link']['title']; ?></span></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>