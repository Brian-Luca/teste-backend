<?php
function uuid($sha, $string) {

    $n_hex = str_replace(array('-','{','}'), '', $sha);
    $binray_str = '';
    
    for($i = 0; $i < strlen($n_hex); $i+=2) {
      $binray_str .= chr(hexdec($n_hex[$i].$n_hex[$i+1]));
    }
    
    $hashing = sha1($binray_str . $string);

    return sprintf('%08s-%04s-%04x-%04x-%12s',
    
      substr($hashing, 0, 8),
      
      substr($hashing, 8, 4),
      
      (hexdec(substr($hashing, 12, 4)) & 0x0fff) | 0x5000,
      
      (hexdec(substr($hashing, 16, 4)) & 0x3fff) | 0x8000,
      
      substr($hashing, 20, 12)
    );
}