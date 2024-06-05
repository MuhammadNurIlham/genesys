<?php

$x = 5;

for ($i = 1; $i <= $x; $i++) {
    for ($j = $i; $j < $x; $j++) {
        echo " ";
    }
    for ($k = 1; $k <= (2 * $i - 1); $k++) {
        echo "*";
    }
    echo "\n";
}
