<?php if (!empty($data['school_items']) && is_array($data['school_items']) || !empty($data['school_items_2']) && is_array($data['school_items_2'])): ?>
    <section class="gobs-school">
        <div class="gobs-school__body">
            <div class="gobs-school-marquee" data-duration="8" data-reverse="true">
                <?php $marquee = $data['school_items']; ?>
                <div class="gobs-school-marquee__group">
                    <?php foreach ($marquee as $item): ?>
                        <?php if (!empty($item['logo']) && !empty($item['logo']['url']) && !empty($item['cta']) && !empty($item['cta']['url'])): ?>
                            <a class="gobs-school-marquee__item" href="<?= $item['cta']['url']; ?>" target="_blank">
                                <img src="<?= $item['logo']['url']; ?>" alt="<?= $item['logo']['title']; ?>">
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="gobs-school-marquee" data-duration="8" data-reverse="false">
                <?php $marquee = $data['school_items_2']; ?>
                <div class="gobs-school-marquee__group">
                    <?php foreach ($marquee as $item): ?>
                        <?php if (!empty($item['logo']) && !empty($item['logo']['url']) && !empty($item['cta']) && !empty($item['cta']['url'])): ?>
                            <a class="gobs-school-marquee__item" href="<?= $item['cta']['url']; ?>" target="_blank">
                                <img src="<?= $item['logo']['url']; ?>" alt="<?= $item['logo']['title']; ?>">
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>