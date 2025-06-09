<?php if(!empty($data['intro_title'])): ?>
<section class="isa-intro">
    <div class="container">
        <?php if(!empty($data['intro_heading'])): ?>
        <h1 class="d-none"><?= $data['intro_heading']; ?></h1>
        <?php endif; ?>
        <div class="isa-intro__header">
            <div class="isa-intro__subtitle"><?= $data['intro_subtitle']; ?></div>
            <div class="isa-intro__title">
                <span><?= $data['intro_title']; ?></span>
                <?php if(!empty($data['intro_image_right']['url'])): ?>
                <img class="img2" src="<?= $data['intro_image_right']['url']; ?>" alt="<?= sanitize_title($data['intro_image_right']['title']); ?>">
                <?php endif; ?>
            </div>
            <?php if(!empty($data['intro_image_left']['url'])): ?>
            <img class="img1" src="<?= $data['intro_image_left']['url']; ?>" alt="<?= sanitize_title($data['intro_image_left']['title']); ?>">
            <?php endif; ?>
        </div>
        <div class="isa-intro__body">
            <?php if(!empty($data['intro_desc'])): ?>  
            <div class="isa-intro__body--desc"><?= $data['intro_desc']; ?></div>
            <?php endif; ?>
            <?php if(!empty($data['intro_cta']['url'])): ?>  
            <div class="isa-intro__body--cta">
                <a class="rt-btn rt-btn-primary" href="<?= $data['intro_cta']['url']; ?>">
                    <?= $data['intro_cta']['title']; ?>
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="48" height="48" rx="24" fill="white"/>
                        <path d="M32.6919 24.2871C32.6539 24.3791 32.599 24.462 32.53 24.531L28.53 28.531C28.384 28.677 28.192 28.751 28 28.751C27.808 28.751 27.616 28.678 27.47 28.531C27.177 28.238 27.177 27.763 27.47 27.47L30.1899 24.75H16C15.586 24.75 15.25 24.414 15.25 24C15.25 23.586 15.586 23.25 16 23.25H30.189L27.469 20.5301C27.176 20.2371 27.176 19.762 27.469 19.469C27.762 19.176 28.237 19.176 28.53 19.469L32.53 23.469C32.599 23.538 32.6539 23.6209 32.6919 23.7129C32.7679 23.8969 32.7679 24.1031 32.6919 24.2871Z" fill="#C33130"/>
                    </svg>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>