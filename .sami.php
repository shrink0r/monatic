<?php

use Sami\Sami;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

switch (getenv('DOC_TYPE') ?: 'markdown') {
    case 'markdown':
        $config = [
            'theme' => 'github',
            'title' => 'Monatic API',
            'build_dir' => __DIR__ . '/docs/md/',
            'cache_dir' => __DIR__ . '/build/cache/md/',
            'template_dirs' => [ __DIR__ . '/vendor/phine/sami-github' ],
            'default_opened_level' => 2,
        ];
    break;

    case 'html':
        $config = [
            'title' => 'Monatic API',
            'build_dir' => __DIR__ . '/docs/html/',
            'cache_dir' => __DIR__ . '/build/cache/html/',
            'default_opened_level' => 2,
        ];
    break;

    default:
        throw new RuntimeException("Unsupported doc-type given. Please choose either 'markdown' or 'html'.");
}

$iterator = Finder::create()->files()->name('*.php')->in(__DIR__ . DIRECTORY_SEPARATOR . 'src');

return new Sami($iterator, $config);
