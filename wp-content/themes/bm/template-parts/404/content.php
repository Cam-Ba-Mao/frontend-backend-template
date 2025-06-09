<section class="isa-thank-you">
    <div class="container"> 
        <div class="isa-thank-you__inner">
            <?php if( isset($data['thank_you_image']['url']) ): ?>
            <div class="isa-thank-you__image">
                <img class="lazy" data-src="<?= $data['thank_you_image']['url']; ?>" alt="<?= $data['thank_you_image']['title']; ?>">
            </div>
            <?php endif; ?>

            <h1 class="siss-title siss-title__small"><?= isset($data['thank_you_title']) && !empty($data['thank_you_title']) ? $data['thank_you_title'] : get_the_title(); ?></h1>

            <?php if( isset($data['thank_you_desc']) && !empty($data['thank_you_desc']) ): ?>
            <div class="isa-thank-you__desc"><?= $data['thank_you_desc']; ?></div>
            <?php endif; ?>

            <?php if( isset($data['thank_you_cta']['url']) ): ?>
            <div class="isa-thank-you__cta">
                <a class="rt-btn rt-btn-primary" target="<?= $data['thank_you_cta']['target']; ?>" href="<?= $data['thank_you_cta']['url']; ?>"><?= $data['thank_you_cta']['title']; ?></a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>