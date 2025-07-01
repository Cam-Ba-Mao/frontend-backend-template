<section class="rt-error">
    <div class="container">
        <div class="rt-error__wrap">
            <?php if(!empty($data['404_image']['url'])): ?>
            <div class="rt-error__image">
                <img src="<?= $data['404_image']['url']; ?>" alt="<?= $data['404_image']['title']; ?>">
            </div>
            <?php endif; ?>
            <?php if(!empty($data['404_title'])): ?>
            <div class="rt-error__title gobs-title"><?= $data['404_title']; ?></div>
            <?php endif; ?>
            <?php if(!empty($data['404_desc'])): ?>
            <div class="rt-error__desc"><?= $data['404_desc']; ?></div>
            <?php endif; ?>
            <?php if(!empty($data['404_cta']['url'])): ?>
            <div class="rt-error__cta">
                <a class="rt-btn btn-primary" href="<?= $data['404_cta']['url']; ?>"><?= $data['404_cta']['title']; ?></a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>