<?php

/*
|--------------------------------------------------------------------------
| Language Settings
|--------------------------------------------------------------------------
*/
$lang = Request::getPreferredLanguage(LaravelLocalization::getSupportedLanguagesKeys());

if ($app->environment() == 'testing') {
    $lang = 'fr';
}

$app->setLocale($lang);
