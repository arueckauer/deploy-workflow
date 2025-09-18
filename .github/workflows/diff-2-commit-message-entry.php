<?php

declare(strict_types=1);

$diff = file_get_contents($argv[1]);

$removed = [];
$added   = [];

preg_match_all('/^- +"([^\/]+\/[^"]+)": +"([^"]+)",?$/m', $diff, $rm, PREG_SET_ORDER);
preg_match_all('/^\+ +"([^\/]+\/[^"]+)": +"([^"]+)",?$/m', $diff, $am, PREG_SET_ORDER);

$removed = array_column($rm, 2, 1);
$added   = array_column($am, 2, 1);

$changed = array_intersect_key($removed, $added);

array_map(function ($pkg) use ($removed, $added) {
    if ($removed[$pkg] !== $added[$pkg]) {
        echo "- {$pkg}: {$removed[$pkg]} -> {$added[$pkg]}\n";
    }
}, array_keys($changed));
