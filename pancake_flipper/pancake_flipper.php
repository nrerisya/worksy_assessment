<?php

function flipPancakes($s, $K) {
    $s = str_split($s); 
    $flips = 0; 
    $sLength = count($s); 

    // If (n = 10) pancakes and the flipper size (K = 3):
    // The loop allows flips to start only at indices 0 to (n - K = 7).
    // Beyond index 7, flipping is not possible because there are not enough pancakes left to flip K at once.

    for ($i = 0; $i <= $sLength - $K; $i++) {
        if ($s[$i] === '-') {
            for ($j = 0; $j < $K; $j++) {
                //ternary operator
                $s[$i + $j] = ($s[$i + $j] === '+') ? '-' : '+';
            }
            $flips++;
        }
    }

    //To check if there are still '-'
    foreach ($s as $s) {
        if ($s === '-') {
            return "IMPOSSIBLE";
        }
    }

    return $flips;
}

function processTestFile($filename) {
    $input = file_get_contents($filename); 
    $row = explode("\n", trim($input)); 
    $T = (int) array_shift($row); //count row/test cases
    $output = [];

    for ($z = 1; $z <= $T; $z++) {
        list($S, $K) = explode(" ", $row[$z - 1]); 
        $K = (int) $K;
        $result = flipPancakes($S, $K);
        $output[] = "Case #$z: $result"; 
    }

    //joining string
    return implode(PHP_EOL, $output); 
}

function main() {
    
    $files = ['ts1_input.txt', 'ts2_input.txt']; 

    foreach ($files as $file) {
        //echo "Processing file: $file\n";
        $result = processTestFile($file); 
        echo $result . PHP_EOL; 
    }
}

main();

?>
