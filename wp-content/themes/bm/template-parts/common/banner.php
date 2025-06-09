<section class="rt-banner">
    <div class="container">
        <div class="rt-banner__inner">
            <div class="rt-banner__inner--content">
                <h1 class="rt-title"><?= !empty($data['banner_title']) ? $data['banner_title'] : get_the_title(); ?></h1>

                <?php if( !empty($data['banner_description']) ): ?>
                <div class="subtitle"><?= $data['banner_description']; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>