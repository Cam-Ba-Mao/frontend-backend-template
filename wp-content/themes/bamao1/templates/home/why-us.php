<?php if( isset($data['why_us_title']) && !empty($data['why_us_title']) ): ?>
<section class="pennacademy-why-us"> 
    <div class="container">
        <div class="pennacademy-why-us__header text-center">
            <h2 class="iedg-title"><?= $data['why_us_title']; ?></h2>
        </div>
        <?php if( isset($data['why_us_list']) && is_array($data['why_us_list']) && count($data['why_us_list']) ): ?>
        <div class="row pennacademy-why-us__list"> 
        <?php foreach( $data['why_us_list'] as $item ): ?>
            <div class="col-md-4 pennacademy-why-us__item"> 
                <div class="pennacademy-why-us__item--wrap">
                    <div class="pennacademy-why-us__image">
                        <img class="lazy" data-src="<?= $item['why_us_image']['url']; ?>" alt="<?= $item['why_us_image']['alt']; ?>">
                    </div>
                    <div class="pennacademy-why-us__desc"><?= $item['why_us_title']; ?></div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>