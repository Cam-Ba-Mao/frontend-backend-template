<?php if( !empty($data['thank_you_title']) ): ?>
<section class="rt-thank-you">
    <div class="container"> 
        <div class="rt-thank-you__inner">
            <?php if( !empty($data['thank_you_image']['url']) ): ?>
            <div class="rt-thank-you__image">
                <img class="lazy" data-src="<?= $data['thank_you_image']['url']; ?>" alt="404">
            </div>
            <?php endif; ?>

            <h1 class="rt-thank-you__title"><?= $data['thank_you_title']; ?></h1>

            <?php if( !empty($data['thank_you_description']) ): ?>
            <div class="rt-thank-you__desc"><?= $data['thank_you_description']; ?></div>
            <?php endif; ?>

            <?php if( !empty($data['thank_you_cta']['title']) ): ?>
            <div class="rt-thank-you__cta">
                <a class="rt-btn rt-btn-primary" href="<?= $data['thank_you_cta']['url']; ?>" target="<?= $data['thank_you_cta']['target']; ?>"><?= $data['thank_you_cta']['title']; ?></a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif;
