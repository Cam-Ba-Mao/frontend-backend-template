<?php if (!empty($data['intro_title'])): ?>
    <section class="rt-intro">
        <div class="container">
            <div class="rt-intro__inner">
                <h2 class="rt-title"><?= $data['intro_title']; ?></h2>
                <?php if (!empty($data['intro_title'])): ?>
                    <div class="rt-entry">
                        <p><?= $data['intro_desc']; ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>