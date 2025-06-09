<?php
require __DIR__ . '/vendor/autoload.php';
\BM\Core\BMInit::init();

\BM\Core\Common\ThemeCustomizer::init();
\BM\Core\Common\Wpform::init();
\BM\Core\Auth\AuthHook::init();

// \BM\Core\Event\EventHook::init();
// \BM\Core\Scholarship\ScholarshipHook::init();
// \BM\Core\Experience\ExperienceHook::init();
// \BM\Core\School\SchoolHook::init();
// \BM\Core\Partner\PartnerHook::init();

# PLEASE DO ONLY INIT HOOK (ACTION - FILTER)
/**
 * Pages
 */
\BM\Core\Pages\Home::init();
\BM\Core\Pages\ThankYou::init();

// \BM\Core\Pages\Event::init();
// \BM\Core\Pages\School::init();
// \BM\Core\Pages\Single::init();
// \BM\Core\Pages\Archive::init();
// \BM\Core\Pages\Single::init();
// \BM\Core\Pages\General::init();
// \BM\Core\Pages\Contact::init();
// \BM\Core\Pages\ThankYou::init();
// \BM\Core\Pages\AboutUs::init();

/*
\BM\Core\Pages\BusinessField::init();
\BM\Core\Pages\ContactUs::init();

\BM\Core\Staff\StaffHook::init();
\BM\Core\Career\CareerHook::init();

\BM\Core\Pages\Archive::init();
\BM\Core\Pages\Single::init();
\BM\Core\Pages\General::init();
\BM\Core\Pages\Career::init();
 */