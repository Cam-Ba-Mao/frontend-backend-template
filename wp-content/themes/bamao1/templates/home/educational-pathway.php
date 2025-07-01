<section class="pennacademy-educational-pathway" id="danh-rieng-hoc-vien">
    <div class="container">
        <div class="pennacademy-educational-pathway__title">
            <?php if( isset($data['home_educational_pathway_subtitle']) && !empty($data['home_educational_pathway_subtitle']) ): ?>
            <span class="iedg-title__medium"><?= $data['home_educational_pathway_subtitle']; ?></span>
            <?php endif; ?>
            <h2 class="iedg-title"><?= $data['home_educational_pathway_title']; ?></h2>
        </div>
        <div class="pennacademy-educational-pathway__tab">
            <?php foreach($data['home_educational_pathway_courses'] as $key => $course): ?>
            <div class="pennacademy-educational-pathway__tab-item <?= $key == 0 ? 'active' : ''; ?>">
                <div class="pennacademy-educational-pathway__tab-item--wrap">
                    <div class="pennacademy-educational-pathway__tab-item--image"><img class="lazy" data-src="<?= $course['icon']['url']; ?>"></div>
                    <div class="pennacademy-educational-pathway__tab-item--title"><?= $course['sort_title']; ?></div>
                </div>
            </div>
            <?php ob_start(); ?>
            <div class="pennacademy-educational-pathway__item">
                <div class="row pennacademy-educational-pathway__row">
                    <div class="col-lg-6">
                        <div class="pennacademy-educational-pathway__item--image">
                            <img data-lazy="<?= $course['image']['url'] ?>">
                        </div>
                    </div>
                    <div class="col-lg-6"> 
                        <div class="pennacademy-educational-pathway__wrap">
                            <div class="pennacademy-educational-pathway__item--title"><?= $course['title']; ?></div>
                            <?php if( isset($course['description']) && !empty($course['description']) ): ?>
                            <div class="pennacademy-educational-pathway__item--desc"><?= $course['description']; ?></div>
                            <?php endif; ?>
                            <?php if( isset($course['cta']['url']) ): ?>
                            <div class="pennacademy-educational-pathway__register">
                                <a class="iedg-btn iedg-btn-outline-primary" href="<?= $course['cta']['url']; ?>" target=""><?= $course['cta']['title']; ?></a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php $course_html .= ob_get_clean(); ?>
            <?php endforeach; ?>
        </div>
        <div class="pennacademy-educational-pathway__list"> 
            <?= $course_html; ?>
        </div>
    </div>
</section>