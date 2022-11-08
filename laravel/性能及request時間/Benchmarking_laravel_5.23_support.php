<?php

declare(strict_types=1);

use Illuminate\Support\Benchmark;
 

// 使用 hash 的範例
Benchmark::measure([
    'key_1' => fn() => Post::find(1),
    'key_2' => fn() => Post::find(5),
]);
// output example
$output = [
    'key_1' => 0.02,
    'key_2' => 0.03
];


// 測試多次
Benchmark::measure([], 3);


// dd
Benchmark::dd([]);


