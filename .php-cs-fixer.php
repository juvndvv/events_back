<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__ . '/app')
    ->name('*.php')
    ->exclude('vendor');

$config = new Config();
return $config
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'single_quote' => true,
        'space_after_semicolon' => true,
        'no_unused_imports' => true,
        'ternary_operator_spaces' => true,
        'no_whitespace_in_blank_line' => true,
    ])
    ->setFinder($finder);
