<?php if( isset($data['training_title']) && !empty($data['training_title']) ): ?>
<section class="pennacademy-training" id="phuong-phap-dao-tao">
    <div class="container">
        <div class="pennacademy-training__title"><?= $data['training_sub_title']; ?></div>
        <div class="iedg-title"><?= $data['training_title']; ?></div>
        <?php if( isset($data['training_list']) && is_array($data['training_list']) && count($data['training_list']) ): ?>
        <div class="pennacademy-training__pagination">
            <?php foreach( $data['training_list'] as $key => $item): ?>
            <div class="pennacademy-training-bullet <?= $key == 0 ? 'pennacademy-training__active' : ''; ?>">
                <div class="pennacademy-training__title"><?= $item['training_title']; ?></div>
                <div class="pennacademy-training__item">
                    <span class="line"></span>
                    <span class="bullet"></span>
                </div>
                <div class="pennacademy-training__desc"><?= $item['training_description']; ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif;?>