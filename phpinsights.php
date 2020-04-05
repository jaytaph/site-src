<?php

declare(strict_types=1);

return [
    'preset' => 'symfony',
    'ide' => null,
    'exclude' => [
        'src/Kernel.php',
    ],
    'add' => [
        //  ExampleMetric::class => [
        //      ExampleInsight::class,
        //  ]
    ],
    'remove' => [
        \SlevomatCodingStandard\Sniffs\Classes\SuperfluousInterfaceNamingSniff::class,
        \PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterNotSniff::class,
    ],
    'config' => [
        \PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff::class => [
            'lineLimit' => 120,
            'absoluteLineLimit' => 160,
        ],
    ],
    'requirements' => [
        'min-quality' => 95,
        // 'min-complexity' => 0,
        'min-architecture' => 90,
        'min-style' => 98,
    ],
];
