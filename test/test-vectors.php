#!/usr/bin/php
<?php
require_once '../anubis.class.php';

$cypher = new Anubis();

$test_vectors = explode("\n\n", file_get_contents('test-vectors.txt'));

$success = true;
$k = 1;
foreach ($test_vectors as $test) {
    list($key, $plain, $cipher, $decrypted, $iterated_100, $iterated_1000) = explode("\n", trim($test));

    $key           = hex2bin($key);
    $plain         = hex2bin($plain);
    $cipher        = hex2bin($cipher);
    $decrypted     = hex2bin($decrypted);
    $iterated_100  = hex2bin($iterated_100);
    $iterated_1000 = hex2bin($iterated_1000);

    $cypher->setKey($key, true);

    $iter_100 = $plain;
    for ($i = 0; $i < 100; $i++) {
        $iter_100 = $cypher->encrypt($iter_100);
    }

    $iter_1000 = $plain;
    for ($i = 0; $i < 1000; $i++) {
        $iter_1000 = $cypher->encrypt($iter_1000);
    }

    $my_cipher    = $cypher->encrypt($plain);
    $my_decrypted = $cypher->decrypt($my_cipher);

    $success = $success &&
            ($my_cipher    === $cipher       ) &&
            ($my_decrypted === $decrypted    ) &&
            ($iter_100     === $iterated_100 ) &&
            ($iter_1000    === $iterated_1000);

    echo $k++, "/", sizeof($test_vectors), ": ";
    if ($success) echo "OK\n"; else echo "Error\n";
    echo    '                key = ', bin2hex($key)         , "\n",
            '              plain = ', bin2hex($plain)       , "\n",
            '             cipher = ', bin2hex($my_cipher)   , "\n",
            '          decrypted = ', bin2hex($my_decrypted), "\n",
            ' Iterated 100 times = ', bin2hex($iter_100)    , "\n",
            'Iterated 1000 times = ', bin2hex($iter_1000)   , "\n\n";
}

if ($success) echo "OK\n"; else echo "Error\n";
