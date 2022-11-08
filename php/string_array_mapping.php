<?php

// 1

$replace_mapping = [
  'iphone'  => 'iPhone',
  'ipad'    => 'iPad',
  'imac'    => 'iMac',
  'airpods' => 'AirPods',
];

// 2 (未測試)

$replace_mapping = [
    'iphone'  => 'iPhone',
    'ipad'    => 'iPad',
    'imac'    => 'iMac',
    'airpods' => 'AirPods',
];
echo str_ireplace(array_keys($replace_mapping), $replace_mapping, 'anbc iphone samsung ipad asamsungaaa IPHONE aa');
// output: anbc iPhone samsung iPad asamsungaaa iPhone aa
