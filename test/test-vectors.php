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
    $decrypted     = hex2bin($decrypted);

    $cypher->setKey($key, true);

    $my_cipher    = $cypher->encrypt($plain);
    $my_decrypted = $cypher->decrypt($my_cipher);

    $success = $success && ($my_decrypted === $decrypted);

    echo $k++, "/", sizeof($test_vectors), ":\n";
    echo    '      key = ', bin2hex($key)         , "\n",
            '    plain = ', bin2hex($plain)       , "\n",
            '   cipher = ', bin2hex($my_cipher)   , "\n",
            'decrypted = ', bin2hex($my_decrypted), "\n";
    echo "Result: ", $success? "OK" : "WRONG", "\n\n";
}

echo "Common result: ", $success? "OK" : "WRONG", "\n";
