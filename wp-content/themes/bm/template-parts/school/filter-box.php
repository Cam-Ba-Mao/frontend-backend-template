<div id="rt-school__filter--<?= $args->name; ?>" class="rt-school__banner--form__field dropdown" data-name="<?= $args->name; ?>" data-filter="<?= $args->terms ? 1 : 0; ?>">
    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" data-label="<?= ! empty($args->button) ? $args->button : $args->label; ?>"><?= $args->label; ?></button>
    <?php if($terms = $args->terms) : ?>
    <div class="dropdown-menu">
        <?php if(count($terms) > 10) : ?>
        <div class="rt-school__banner--form__field--search">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <g opacity="0.5">
                    <path
                        d="M21.354 20.646L17.345 16.637C18.681 15.135 19.501 13.164 19.501 11C19.501 6.313 15.688 2.5 11.001 2.5C6.31398 2.5 2.50098 6.313 2.50098 11C2.50098 15.687 6.31398 19.5 11.001 19.5C13.165 19.5 15.136 18.68 16.638 17.344L20.647 21.353C20.745 21.451 20.873 21.499 21.001 21.499C21.129 21.499 21.257 21.45 21.355 21.353C21.549 21.158 21.549 20.842 21.354 20.646ZM3.5 11C3.5 6.865 6.864 3.5 11 3.5C15.136 3.5 18.5 6.865 18.5 11C18.5 15.135 15.136 18.5 11 18.5C6.864 18.5 3.5 15.135 3.5 11Z"
                        fill="white"
                    >
                </g>
            </svg>
            <input class="tax-search" type="text" placeholder="<?= __('Tìm kiếm...', 'rt'); ?>">
        </div>
        <?php endif; ?>
        <ul class="items">
            <?php foreach($terms as $term) : ?>
            <?php $checked = ($term->slug === $args->value) ? 'checked' : ''; ?>
            <li data-slug="<?= $term->slug; ?>" data-value="<?= $args->value; ?>">
                <label>
                    <input type="radio" name="<?= $args->name; ?>" value="<?= $term->slug; ?>" <?= $checked; ?>>
                    <span><?= $term->name; ?></span>
                </label>
            </li>
            <?php endforeach; ?>
        </ul>
        <button class="btn btn-<?= empty($args->value) ? 'reset d-none' : 'reset'; ?>" type="button"><?= __('Bỏ chọn', 'rt'); ?></button>
    </div>
    <?php endif; ?>
</div>