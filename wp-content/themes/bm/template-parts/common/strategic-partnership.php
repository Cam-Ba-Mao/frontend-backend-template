<?php
    $partnership_data = RT\Core\Common\Options::getOption();
    $lang = pll_current_language();
    $data_tab = '';
?>
<?php if( !empty($partnership_data["general_strategic_partnership_title_" . $lang]) ): ?>
<section class="isa-strategic-partnership">
    <div class="container">
        <div class="isa-strategic-partnership__header">
            <h2 class="isa-title"><?= $partnership_data['general_strategic_partnership_title_'. $lang]; ?></h2>
        </div>
        <?php  ?>
        <?php if( isset($partnership_data['general_strategic_partnership_category_'. $lang]) && is_array($partnership_data['general_strategic_partnership_category_'. $lang]) && count($partnership_data['general_strategic_partnership_category_'. $lang]) ): ?>
        <div class="isa-strategic-partnership__mobile">
            <div class="isa-strategic-partnership__nav">
                <ul class="nav nav-tabs" id="StrategicTab" role="tablist">
                    <?php foreach( $partnership_data['general_strategic_partnership_category_'. $lang] as $key => $category ): ?>
                        <?php
                            $post_id = $category->term_id;
                            $post_fields = get_fields($post_id);
                            $title = $category->name;
                         
                            $postOfCategory = \RT\Core\Partner\PartnerFunctions::getPartners($post_id, 1, 10, []);  
                            $icon = get_field("category_partner_flag", $category);
                        ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $key == 0 ? 'active' : ''; ?>"  id="strategic-partnership-tab-<?= $key + 1 ?>" data-bs-toggle="tab" data-bs-target="#strategic-partnership-tab-<?= $key + 1 ?>-content" type="button" role="tab" aria-controls="strategic-partnership-tab-<?= $key + 1 ?>-content" aria-selected="<?= $key == 0 ? 'true' : 'false'; ?>"> 
                            <img src="<?= $icon; ?>" alt="">
                            <span><?= $title; ?></span>
                        </button>
                        
                    </li>
                    <?php ob_start(); ?>
                    <div class="tab-pane fade <?= $key == 0 ? 'show active' : ''; ?>" id="strategic-partnership-tab-<?= $key + 1 ?>-content" role="tabpanel" aria-labelledby="strategic-partnership-tab-<?= $key + 1 ?>">
                        <?php if($postOfCategory->have_posts()): ?>
                        <div class="isa-strategic-partnership__list swiper swiper-container">
                            <div class="swiper-wrapper">
                                <?php while ($postOfCategory->have_posts()): $postOfCategory->the_post();?>
                                <?php
                                    $id = get_the_ID();
                                    $link = get_permalink();
                                    $title = get_the_title();
                                    $fieldACF = get_fields($id);

                                    if ( !empty($fieldACF['doi_tac_background']['url']) ) {
                                        $thumbnail = $fieldACF['doi_tac_background']['url'];
                                    } else {
                                        $thumbnail = get_template_directory_uri(). '/html/dist/images/no-image-avaliable.jpg';
                                    }

                                    // dd($fieldACF['doi_tac_background']['url']);
                                   
                                ?>
                                <div class="swiper-slide isa-strategic-partnership__item">
                                    <a class="isa-strategic-partnership__item--wrap" href="<?= !empty($fieldACF['doi_tac_website']) ? $fieldACF['doi_tac_website']: '#'; ?>" target="_blank">
                                        <div class="isa-strategic-partnership__item--inner">
                                            <div class="isa-strategic-partnership__item--image rt-img-drop">
                                                <img class="lazy" data-src="<?= $thumbnail; ?>" alt="<?= sanitize_title($title); ?>">
                                            </div>
                                            <div class="isa-strategic-partnership__item--body">
                                                <div class="isa-strategic-partnership__item--logo">
                                                    <img src="<?= $fieldACF['doi_tac_logo']['url']; ?>" alt="<?= sanitize_title($title); ?>">
                                                </div>
                                                <div class="isa-strategic-partnership__item--title"><?= $title; ?></div>
                                                <div class="isa-strategic-partnership__item--cta"><?php _e('XEM THÊM', 'rt'); ?></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                        <div class="isa-strategic-partnership__arrow">
                            <div class="isa-swiper-prev">
                                <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.65835 0.807167L6.26761 4.30669C5.29715 5.25835 4.53565 5.69723 3.56169 5.94113C3.03781 6.0723 2.61911 6.54363 2.61961 7.13802C2.62015 7.81873 3.11677 8.40948 3.81596 8.41007C4.51515 8.41066 19.9737 8.42341 19.9737 8.42341C19.9877 8.42345 19.9991 8.43496 19.9991 8.44912L20 9.57001C20 9.58422 19.9887 9.59568 19.9746 9.59568L3.81688 9.5823C2.39477 9.58113 2.22865 11.7201 3.573 12.0494C4.57931 12.296 5.37373 12.7457 6.40619 13.7911L9.6735 17.1931C9.68308 17.203 9.68308 17.2189 9.67354 17.2288L8.94042 17.9923C8.93042 18.0027 8.91388 18.0026 8.90392 17.9921L0.00707436 9.02786C-0.00234795 9.01788 -0.00234795 9.00215 0.00707436 8.99225L8.88865 0.00783285C8.89858 -0.00259648 8.91511 -0.00261358 8.92511 0.00779744L9.65838 0.771316C9.668 0.781317 9.66796 0.797228 9.65835 0.807167Z" fill="#040F49"/>
                                </svg>
                            </div>
                            <div class="isa-swiper-next">
                                <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.3417 0.807167L13.7324 4.3067C14.7028 5.25835 15.4643 5.69724 16.4383 5.94114C16.9622 6.0723 17.3809 6.54363 17.3804 7.13802C17.3798 7.81873 16.8832 8.40948 16.184 8.41007C15.4848 8.41066 0.0263 8.42341 0.0263 8.42341C0.012286 8.42345 0.000916262 8.43496 0.000905142 8.44912L8.95927e-09 9.57001C-1.16406e-05 9.58422 0.0113389 9.59568 0.0253524 9.59568L16.1831 9.5823C17.6052 9.58113 17.7713 11.7201 16.427 12.0494C15.4207 12.296 14.6263 12.7457 13.5938 13.7911L10.3265 17.1931C10.3169 17.203 10.3169 17.2189 10.3265 17.2288L11.0596 17.9923C11.0696 18.0027 11.0861 18.0026 11.0961 17.9921L19.9929 9.02786C20.0023 9.01788 20.0023 9.00215 19.9929 8.99225L11.1113 0.00783286C11.1014 -0.00259648 11.0849 -0.00261359 11.0749 0.00779744L10.3416 0.771316C10.332 0.781317 10.332 0.797228 10.3417 0.807167Z" fill="#040F49"/>
                                </svg>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php $data_tab .= ob_get_clean(); ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="tab-content" id="StrategicTabContent">
            <?php if( !empty($data_tab) ): ?>
                <?= $data_tab; ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>