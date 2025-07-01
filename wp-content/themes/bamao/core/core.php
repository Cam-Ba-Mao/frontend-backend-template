<?php
require __DIR__ . '/vendor/autoload.php';
\RT\Core\BMInit::init();

\RT\Core\Common\ThemeCustomizer::init();
\RT\Core\Common\Wpform::init();
\RT\Core\Auth\AuthHook::init();

# PLEASE DO ONLY INIT HOOK (ACTION - FILTER)
/**
 * Pages
 */
\RT\Core\Pages\Home::init();
// \RT\Core\Pages\Degrees::init();
// \RT\Core\Pages\Search::init();
// \RT\Core\Pages\Single::init();
// \RT\Core\Pages\General::init();
// \RT\Core\Pages\Archive::init();

// \RT\Core\Pages\Contact::init();
// \RT\Core\Pages\AboutUs::init();
// \RT\Core\Pages\ThankYou::init();
// \RT\Core\Pages\Error404::init();


/**
 * Hooks
 */
\RT\Core\Faq\FaqHook::init();
\RT\Core\Course\CourseHook::init();
