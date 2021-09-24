<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@PSR12' => true,
    '@PSR12:risky' => true,
    'array_syntax' => ['syntax' => 'short'],
    'concat_space' => false,
    'declare_strict_types' => true,
])
    ->setFinder($finder)
;
