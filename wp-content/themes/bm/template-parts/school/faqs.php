<?php if(! empty($data['school_faqs_title_v2']) and empty($data['school_faqs_hide_v2'])) : ?>
<section class="rt-school__faqs">
    <div class="container">
        <div class="row">
            <?php if(! empty($data['school_faqs_image_v2']['url'])) : ?>
            <div class="col-lg-6">
                <div class="rt-school__faqs--image">
                    <img class="lazy" data-src="<?= $data['school_faqs_image_v2']['url']; ?>" alt="<?= $data['school_faqs_image_v2']['alt']; ?>">
                </div>
            </div>
            <?php endif; ?>
            <?php if(! empty($data['school_faqs_posts_v2'])) : ?>
            <div class="col-lg-6">
                <div class="rt-school__faqs--list">
                    <div class="rt-block__heading">
                        <h2 class="rt-title"><?= $data['school_faqs_title_v2']; ?></h2>
                    </div>
                    <div class="rt-school__faqs--list__posts">
                        <div class="accordion" id="accordionExample">
                            <?php foreach($data['school_faqs_posts_v2'] as $i => $post) : ?>
                            <?php if(! empty($post['title']) and ! empty($post['content'])) : ?>
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="rt-faq-heading-<?= $i; ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rt-content-<?= $i; ?>" aria-expanded="false" aria-controls="rt-content-<?= $i; ?>">
                                        <div class="rt-school__faqs--list__posts--title"><?= sprintf('%u. %s', ($i+1), $post['title']); ?></div>
                                    </button>
                                </h3>
                                <div class="accordion-collapse collapse" id="rt-content-<?= $i; ?>" aria-labelledby="rt-faq-heading-<?= $i; ?>" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p><?= $post['content']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>