<?php
/*

(C) CB - 20220505 - v0.1.0
License: MIT

Implements the Fermat method to factorize a number, e.g. n=p*q used in RSA Algorithm

Details see
https://de.m.wikipedia.org/wiki/Faktorisierungsmethode_von_Fermat

Requires PHP extension "BCMath Arbitrary Precision Mathematics"
see https://www.php.net/manual/en/book.bc.php

*/

if (!function_exists('bcadd')) die('bc_math is not installed, exiting ...');

define('MAX_ITERATIONS', 100);

// examples to try
//$n = '1729'; // = 19 * 91
//$n = '290377'; // = 551 * 527

$n = '630548215070129547156718332495889632234434145411971275888376987603260225252787926135276738944105689100036295535868141424386536403649578707699128189491432138631900590774729214990015369102760964884776344849717811484309528915040117952098061886881';
/*
leads to
p: 25110719126901354976190933395867124680240805711276844886250959824156205188949406184735295788387561135167529430243075948799
q: 25110719126901354976190933395867124680240805711276844886250959824156205188949406184735295788387561135167529435118429780319
*/

/*
Calc and display the square root. Fermat algorithm works best, if the 2 primes are of similar size, i.e. sqrt looks like xxx.99999...
*/
$x = bcsqrt($n, 100); 
echo("-- (mostly) exact sqrt:\r\n$x\r\n");

$x = bcsqrt($n); // only the integer part of the sqrt, will be rounded up
echo("-- integer part of sqrt:\r\n$x\r\n");

$i = 0; // iteration counter

do {
    $i += 1;
    $x = bcadd($x, 1);
    $r = bcsub(bcpow($x, 2), $n);
    echo("--- iteration: $i\r\n");
    echo("x: $x - r: $r" . PHP_EOL);
    if ($i > MAX_ITERATIONS) {
        echo("sorry, n could not be factorized in " . MAX_ITERATIONS . ' iterations, exiting ...');
        exit;
    } 
} while (!is_square($r));

$y = bcsqrt($r);
$p = bcsub($x, $y);
$q = bcadd($x, $y);

echo("----- solution found\r\n");
echo("p: $p\r\nq: $q\r\n");


/*
* determines if number $num is square
*/
function is_square($num) {
    $x = bcsqrt($num);
    $y = bcpow($x, 2);
    return (bccomp($y, $num) == 0);
}

?>