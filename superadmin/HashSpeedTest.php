<?php
/**
 * This code will benchmark your server to determine how high of a cost you can
 * afford. You want to set the highest cost that you can without slowing down
 * you server too much. 10 is a good baseline, and more is good if your servers
 * are fast enough. The code below aims for ≤ 350 milliseconds stretching time,
 * which is an appropriate delay for systems handling interactive logins.
 */
$timeTarget = 0.35; // 350 milliseconds

$cost = 10;
do {
    $cost++;
    $start = microtime(true);
    password_hash("test", PASSWORD_ARGON2ID, ['memory_cost' => 65536, // 64 MB
                                              'time_cost'   => $cost,     // 4 iterations
                                              'threads'     => 4,     // 3 threads
                                            ]);
    $end = microtime(true);
} while (($end - $start) < $timeTarget);

echo "Appropriate Cost Found: " . $cost;
?>
