<?php if(! empty($data['school_banner_title_v2']) or ! empty($data['school_banner_filter_v2'])) : ?>
<section class="rt-school__banner">
    <?php if(! empty($data['school_banner_title_v2'])) : ?>
    <div class="rt-school__banner--head">
        <div class="container">
            <div class="rt-block__heading">
                <div class="rt-title"><?= $data['school_banner_title_v2']; ?></div>
                <?php if(! empty($data['school_banner_title_note_v2'])) : ?>
                <div class="rt-title__desc"><?= $data['school_banner_title_note_v2']; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if(! empty($data['school_banner_filter_v2'])) : ?>
    <div class="rt-school__banner--body">
        <div class="container">
            <form action="<?php the_permalink(); ?>" method="post" class="rt-school__banner--form">
                <div class="rt-school__banner--form__fields">
                    
                    <?php
                        $object = get_queried_object();
                        
                        echo \RT\Core\School\SchoolFunctions::fillterBox([
                            'name' => 'country',
                            'button' => __('Chọn quốc gia', 'rt'),
                            'value' => !empty($object->slug) ? $object->slug : 0,
                            'label' => !empty($object->name) ? $object->name : __('Chọn quốc gia', 'rt'),
                            'terms' => \RT\Core\School\SchoolFunctions::getSchoolCountries(),
                        ]);

                        echo \RT\Core\School\SchoolFunctions::fillterBox([
                            'name' => 'state',
                            'label' => __('Chọn Tỉnh bang/Thành phố', 'rt'),
                            'terms' => \RT\Core\School\SchoolFunctions::getSchoolStates(),
                        ]);

                        echo \RT\Core\School\SchoolFunctions::fillterBox([
                            'name' => 'type',
                            'label' => __('Chọn bậc học', 'rt'),
                            'terms' => \RT\Core\School\SchoolFunctions::getSchoolTypes(),
                        ]);
                        
                        echo \RT\Core\School\SchoolFunctions::fillterBox([
                            'name' => 'fees',
                            'label' => __('Học phí tham khảo', 'rt'),
                            'terms' => \RT\Core\School\SchoolFunctions::getSchoolFees(),
                        ]);
                    ?>
                </div>

                <div class="rt-school__banner--form__field--submit d-none d-lg-block">
                    <button class="btn btn-primary btn-search">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M21.354 20.646L17.345 16.637C18.681 15.135 19.501 13.164 19.501 11C19.501 6.313 15.688 2.5 11.001 2.5C6.31398 2.5 2.50098 6.313 2.50098 11C2.50098 15.687 6.31398 19.5 11.001 19.5C13.165 19.5 15.136 18.68 16.638 17.344L20.647 21.353C20.745 21.451 20.873 21.499 21.001 21.499C21.129 21.499 21.257 21.45 21.355 21.353C21.549 21.158 21.549 20.842 21.354 20.646ZM3.5 11C3.5 6.865 6.864 3.5 11 3.5C15.136 3.5 18.5 6.865 18.5 11C18.5 15.135 15.136 18.5 11 18.5C6.864 18.5 3.5 15.135 3.5 11Z"
                                fill="white"
                        >
                        </svg>
                        <span><?= __('Tìm trường', 'rt'); ?></span>
                    </button>
                    <input type="hidden" name="action" value="rt_school_loaddata">
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
</section>
<?php endif; ?>