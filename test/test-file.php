#!/usr/bin/php
<?php
require_once '../anubis.class.php';

$src  = 'test-file.txt';
$encrypted = 'encrypted.file';
$decrypted = 'test-file-decrypted.txt';

$time = microtime(true);

$cypher = new Anubis();

//never do it if file supposed to be greater than several KB
//$cypher->file_blocksize = filesize($src);

$cypher->setKey("\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0", true);

$cypher->encryptFile($src, $encrypted);
$cypher->decryptFile($encrypted, $decrypted);

$time = microtime(true) - $time;

$src_hash       = md5_file($src);
$decrypted_hash = md5_file($decrypted);

echo "Src:  $src_hash\n";
echo "Dest: $decrypted_hash\n";
echo "Time: $time s\n";
