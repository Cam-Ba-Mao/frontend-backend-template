<?php if(! empty($data['school_list_title_v2'])) : ?>
<section class="rt-school__list" id="ajaxdata">
    <div class="container">
        <div class="rt-block__heading">
            <h1 class="rt-title">
            <?php if(is_tax('school_country_state')) : ?>
            <?php $object = get_queried_object(); ?>
            <?= sprintf(__('Danh sách trường %s', 'rt'), $object->name); ?>
            <?php else : ?>
            <?= $data['school_list_title_v2']; ?>
            <?php endif; ?>
            </h1>
        </div>
        <?php if($posts = \RT\Core\School\SchoolFunctions::getSchools()) : ?>
        <div class="rt-school__list--posts">
            <?php
                foreach($posts as $post) {
                    get_template_part('template-parts/school/loop', null, $post);
                }
            ?>
        </div>
        <?php get_template_part('template-parts/school/loadmore'); ?>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>