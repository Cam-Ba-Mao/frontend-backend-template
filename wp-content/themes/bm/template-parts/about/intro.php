<?php if (!empty($data['intro_title']) && !empty($data['intro_subtitle'])) : ?>
    <section class="rt-intro">
        <div class="container">
            <?php if(!empty($data['intro_heading'])): ?>
            <h1 class="d-none"><?= $data['intro_heading']; ?></h1>
            <?php endif; ?>
            <div class="rt-intro__inner">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-4">
                        <div class="text-wrapper">
                            <div class="rt-subtitle"><?= $data['intro_subtitle']; ?></div>
                            <div class="rt-title"><?= $data['intro_title']; ?></div>
                        </div>
                    </div>
                    <div class="col-lg-auto">&nbsp;</div>
                    <?php if (!empty($data['intro_desc'])) : ?>
                        <div class="col-lg-7">
                            <div class="desc"><?= $data['intro_desc']; ?></div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <?php if (
                            !empty($data['intro_youtube']) &&
                            !empty($data['intro_video']) &&
                            !empty($data['intro_video']['url']) &&
                            !empty($data['intro_video']['title'])
                        ) : ?>
                        <?php endif; ?>
                        <div class="video-wrapper ratio ratio-16x9">
                            <video width="320" height="240" muted loop autoplay>
                                <source src="<?= $data['intro_video']['url']; ?>" type="video/mp4">
                            </video>
                            <div class="mask rt-light-gallery" data-sources="[{ &quot;src&quot;:&quot;<?= $data['intro_youtube']; ?>&quot;, &quot;thumb&quot;:&quot;&quot;}]">
                                <label class="icon"><span><?= $data['intro_video']['title']; ?></span></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>