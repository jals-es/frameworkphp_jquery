<?php 
$key = "mysecret";

//Encryption
$result = mcrypt_ecb (MCRYPT_3DES, 'test', $string, MCRYPT_ENCRYPT);
//Decryption
$decrypt_result = mcrypt_ecb (MCRYPT_3DES, 'test', $result, MCRYPT_DECRYPT);

?>