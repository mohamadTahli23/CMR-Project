<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];

    // Store the selected language in the session
    $_SESSION['lang'] = $lang;
} else {
    // If the language parameter is not set, check if the language is already stored in the session
    if (isset($_SESSION['lang'])) {
        $lang = $_SESSION['lang'];
    } else {
        // Default language
        $lang = 'en';
    }
}

// Include the language file based on the selected language
if ($lang === 'en') {
    include('language/en.php');
} elseif ($lang === 'ar') {
    include('language/ar.php');
}

// Function to retrieve the translated text
function __($str)
{
    global $lang;
    global $languages;

    // Check if the translation exists for the selected language
    if (isset($languages[$lang][$str])) {
        return $languages[$lang][$str];
    } else {
        // If translation doesn't exist, return the original text
        return $str;
    }
}
?>
