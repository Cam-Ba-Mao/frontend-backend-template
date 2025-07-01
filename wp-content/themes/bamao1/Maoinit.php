<?php
require __DIR__ . '/vendor/autoload.php';

// \Mao\Product\ProductFunctions::init();
\Mao\Product\ProductHook::init();
\Mao\Pages\Archive::init();
\Mao\Pages\Single::init();
// (new \Mao\Product\ProductHook)->init();