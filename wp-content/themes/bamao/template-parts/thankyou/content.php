<section class="rt-error">
    <div class="container">
        <div class="rt-error__wrap">
            <?php if(!empty($data['thank_you_image']['url'])): ?>
            <div class="rt-error__image">
                <img src="<?= $data['thank_you_image']['url']; ?>" alt="<?= $data['thank_you_image']['title']; ?>">
            </div>
            <?php endif; ?>
            <?php if(!empty($data['thank_you_title'])): ?>
            <div class="rt-error__title gobs-title"><?= $data['thank_you_title']; ?></div>
            <?php endif; ?>
            <?php if(!empty($data['thank_you_desc'])): ?>
            <div class="rt-error__desc"><?= $data['thank_you_desc']; ?></div>
            <?php endif; ?>
            <?php if(!empty($data['thank_you_cta']['url'])): ?>
            <div class="rt-error__cta">
                <a class="rt-btn btn-primary" href="<?= $data['thank_you_cta']['url']; ?>"><?= $data['thank_you_cta']['title']; ?></a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>