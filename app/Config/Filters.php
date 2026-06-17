<?php
namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;
use CodeIgniter\Filters\Cors;
use App\Filters\AuthFilter;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'auth'          => AuthFilter::class,   // enregistrement
    ];

    public array $required = [
        'before' => ['pagecache'],
        'after'  => ['pagecache', 'performance', 'toolbar'],
    ];

    public array $globals = [
        'before' => [],
        'after'  => [],
    ];

    public array $methods = [];

    // Bug 5 corrigé : filtre appliqué sur les routes protégées
    public array $filters = [
        'auth' => [
            'before' => ['caisse', 'caisse/*', 'achat', 'achat/*']
        ],
    ];
}