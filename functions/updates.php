<?php
/**
 * Theme updates checker
 *
 * @link       https://github.com/MakiOmar
 * @since      1.0.0
 *
 * @package    SmartPage
 */


require ANONY_THEME_DIR . '/plugin-update-checker/plugin-update-checker.php';

$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/MakiOmar/smartpage/blob/8d04c1006f386b056103e28ad29a573677c9d972/plugin-update-checker/examples/theme.json',
    __FILE__, //Full path to the main plugin file or functions.php.
    'anony-smartpage'
);