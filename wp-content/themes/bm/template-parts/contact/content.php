<?php $lang = pll_current_language(); ?>
<section class="rt-contact">
    <div class="container"> 
        <div class="row"> 

            <?php if( !empty($data['contact_form_title']) ): ?>
            <div class="col-lg-6 col-xl-5">
                <div class="rt-contact__form">
                    <div class="rt-contact__form--head">
                        <div class="rt-block__heading">
                            <div class="rt-title"><?= $data['contact_form_title']; ?></div>

                            <?php if( !empty($data['contact_form_description']) ): ?>
                            <div class="rt-title__desc"><?= $data['contact_form_description']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if( !empty($data['contact_form_id']) ): ?>
                    <div class="rt-contact__form--body"><?= do_shortcode('[wpforms id="'. $data['contact_form_id'] .'" title="false"]') ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="col-lg-6 col-xl-5 offset-xl-2">
                <div class="rt-contact__info">
                    <div class="rt-block__heading">
                        <div class="rt-title__desc"><?php the_title(); ?></div>
                        <h1 class="rt-title"><?php _e("Thông tin liên hệ", "rt"); ?></h1>
                    </div>
                    <ul class="rt-contact__info--desc">
                        <?php if( !empty($data["general_info_address_" . $lang]) ): ?>
                        <li class="is-address">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.0833 7.91667C17.0833 12 10.4167 18.75 10.4167 18.75C10.4167 18.75 3.75 12 3.75 7.91667C3.75 3.66667 7.16667 1.25 10.4167 1.25C13.6667 1.25 17.0833 3.66667 17.0833 7.91667Z" stroke="currentColor" stroke-opacity="0.8" stroke-miterlimit="10" stroke-linecap="square"/>
                                <path d="M10.4167 10.4166C11.7974 10.4166 12.9167 9.29734 12.9167 7.91663C12.9167 6.53591 11.7974 5.41663 10.4167 5.41663C9.03597 5.41663 7.91669 6.53591 7.91669 7.91663C7.91669 9.29734 9.03597 10.4166 10.4167 10.4166Z" stroke="currentColor" stroke-opacity="0.8" stroke-miterlimit="10" stroke-linecap="square"/>
                            </svg><?= $data["general_info_address_" . $lang]; ?>
                        </li>
                        <?php endif; ?>

                        <?php if( !empty($data["general_contact_phone"])): ?>
                        <li class="is-phone">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.1733 12.24L11.3892 14C10.4587 13.439 9.59442 12.7751 8.81249 12.0209C8.05936 11.2376 7.39557 10.3732 6.83332 9.44335L8.59166 7.65919C8.69815 7.55104 8.77007 7.41367 8.79827 7.26453C8.82646 7.1154 8.80966 6.96124 8.74999 6.82169L6.91666 2.54835C6.84423 2.37985 6.71368 2.24298 6.54879 2.16268C6.38389 2.08237 6.19564 2.06398 6.01832 2.11085L2.65666 3.00002C2.48878 3.04354 2.34065 3.14275 2.2365 3.28142C2.13234 3.42009 2.07834 3.59 2.08332 3.76335C2.29722 7.67316 3.92287 11.3725 6.65832 14.1742C9.46055 16.9105 13.1609 18.5365 17.0717 18.75C17.2452 18.7559 17.4155 18.7023 17.5544 18.5982C17.6934 18.4941 17.7927 18.3457 17.8358 18.1775L18.7242 14.8142C18.7713 14.637 18.7531 14.4487 18.6729 14.2838C18.5927 14.1189 18.4559 13.9883 18.2875 13.9159L14.0133 12.0834C13.8736 12.0228 13.719 12.0054 13.5694 12.0333C13.4197 12.0612 13.2818 12.1332 13.1733 12.24V12.24Z" stroke="currentColor" stroke-opacity="0.8" stroke-miterlimit="10" stroke-linecap="square"/>
                            </svg><a href="tel:<?= $data["general_contact_phone"]; ?>"><?= $data["general_contact_phone"]; ?></a>
                        </li>
                        <?php endif; ?>

                        <?php if( !empty($data["general_contact_email"])): ?>
                        <li class="is-email">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_16_159)">
                                <path d="M1.76166 3.38159L10.4167 11.2499L19.0708 3.38243" stroke="currentColor" stroke-opacity="0.8" stroke-miterlimit="10"/>
                                <path d="M17.9167 2.91663H2.91667C1.99619 2.91663 1.25 3.66282 1.25 4.58329V16.25C1.25 17.1704 1.99619 17.9166 2.91667 17.9166H17.9167C18.8371 17.9166 19.5833 17.1704 19.5833 16.25V4.58329C19.5833 3.66282 18.8371 2.91663 17.9167 2.91663Z" stroke="currentColor" stroke-opacity="0.8" stroke-miterlimit="10" stroke-linecap="square"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_16_159">
                                <rect width="20" height="20" fill="currentColor"/>
                                </clipPath>
                                </defs>
                            </svg><a href="mailto:<?= $data["general_contact_email"]; ?>"><?= $data["general_contact_email"]; ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>

                    <ul class="rt-contact__info--social"> 
                        <?php if( !empty($options["general_social_instagram"])): ?>
                        <li>
                            <a href="<?= $options["general_social_instagram"]; ?>" target="_blank">
                                <svg role="img">
                                    <use xlink:href="#icon-instagram"></use>
                                </svg>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if( !empty($options["general_social_facebook"])): ?>
                        <li>
                            <a href="<?= $options["general_social_facebook"]; ?>" target="_blank">
                                <svg role="img">
                                    <use xlink:href="#icon-facebook"></use>
                                </svg>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if( !empty($options["general_social_youtube"])): ?>
                        <li>
                            <a href="<?= $options["general_social_youtube"]; ?>" target="_blank">
                                <svg role="img">
                                    <use xlink:href="#icon-youtube"></use>
                                </svg>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if( !empty($options["general_social_linkedin"])): ?>
                        <li>
                            <a href="<?= $options["general_social_linkedin"]; ?>" target="_blank">
                                <svg role="img">
                                    <use xlink:href="#icon-linkedin"></use>
                                </svg>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>


                    <hr>
                    <div class="rt-contact__links">
                        <?php if( !empty($data['contact_our_services_title']) ): ?>
                        <h3 class="rt-title"><?= $data['contact_our_services_title']; ?></h3>
                        <?php endif; ?>

                        <?php if(isset($data['contact_our_services']) && is_array($data['contact_our_services']) && count($data['contact_our_services']) ): ?>
                        <ul class="rt-contact__links--items">
                            <?php foreach($data['contact_our_services'] as $service): ?>
                            <li> <a href="<?= $service['cta']['url']; ?>" target="<?= $service['cta']['target']; ?>"><?= $service['cta']['title']; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>