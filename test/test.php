#!/usr/bin/php
<?php
require_once '../anubis.class.php';

$cypher = new Anubis();

$plain = [
    hex2bin('ff0000000000000000000000000000'),
    hex2bin('00ff00000000000000000000000000'),
    hex2bin('0000ff000000000000000000000000'),
    hex2bin('000000ff0000000000000000000000'),
    hex2bin('00000000ff00000000000000000000'),
    hex2bin('0000000000ff000000000000000000'),
    hex2bin('000000000000ff0000000000000000'),
    hex2bin('00000000000000ff00000000000000'),
    hex2bin('0000000000000000ff000000000000'),
    hex2bin('000000000000000000ff0000000000'),
    hex2bin('00000000000000000000ff00000000'),
    hex2bin('0000000000000000000000ff000000'),
    hex2bin('000000000000000000000000ff0000'),
    hex2bin('00000000000000000000000000ff00'),
    hex2bin('0000000000000000000000000000ff'),
];

$cypher->key = 'Secret password';

foreach ($plain as $src) {
    $enc = $cypher->encrypt($src);
    $dec = $cypher->decrypt($enc);

    echo "Src: ", bin2hex($src), "\n";
    echo "Enc: ", bin2hex($enc), "\n";

    if ($src === $dec) {
        echo "Result: OK\n";
    } else {
        echo "Result: WRONG\n";
    }
}

