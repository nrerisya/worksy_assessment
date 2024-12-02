<?php

//to check if it is tidy num
function isTidy($number) {
    $digits = str_split($number);
    for ($i = 1; $i < count($digits); $i++) {
        if ($digits[$i] < $digits[$i - 1]) {
            return false;
        }
    }
    return true;
}


function findTidyNumber($number) {
    $digits = str_split($number);
    $length = count($digits);
    $setToNine = $length;

    for ($i = $length - 1; $i > 0; $i--) {
        if ($digits[$i] < $digits[$i - 1]) {
            $digits[$i - 1]--;
            $setToNine = $i; 
        }
    }

    for ($i = $setToNine; $i < $length; $i++) {
        $digits[$i] = '9';
    }

    return ltrim(implode('', $digits), '0');
}

function processTestFile($file) {
    $input = file($file); 
    $T = (int) array_shift($input);
    $output = [];
    
    for ($z = 1; $z <= $T; $z++) {
        $N = trim($input[$z - 1]);
        $output[] = "Case #$z: " . findTidyNumber($N);
    }
    
    //joining string
    return implode(PHP_EOL, $output);
}

function main() {
    $files = ['ts1_input.txt', 'ts2_input.txt'];

    foreach ($files as $file) {
        $result = processTestFile($file); 
        echo $result . PHP_EOL; 
    }
}

main();
