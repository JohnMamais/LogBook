<?php
//password hashing
$algo= PASSWORD_ARGON2ID;
$options = [
  'memory_cost' => 65536, // 64 MB
  'time_cost'   => 11,     // 11 iterations
  'threads'     => 4,     // 2 threads
];

 ?>
