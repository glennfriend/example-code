<?php

$row = [
  'iphone'  => 'iPhone',
  'ipad'    => 'iPad',
  'imac'    => 'iMac',
  'airpods' => 'AirPods',
];

// array to beautiful json
json_encode($row, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);

// json to array
json_decode($jsonText, true);

// json to beautiful json
json_encode(json_decode($jsonText, true), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);

