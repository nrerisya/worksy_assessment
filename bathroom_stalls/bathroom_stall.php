<?php

function simulateBathroomStalls($N, $K) {
    
    $stalls = array_fill(0, $N + 2, 0); 
    $stalls[0] = $stalls[$N + 1] = 1; 

    
    for ($currentPerson = 1; $currentPerson <= $K; $currentPerson++) {
        $bestStall = null; // Track the best stall index
        $maxOfMinDistances = null; 
        $maxOfMaxDistances = null; 

        // Evaluate each stall
        for ($i = 1; $i <= $N; $i++) {
            if ($stalls[$i] == 0) { // Check if the stall is empty
                // Calculate the nearest occupied stall distances
                $leftDistance = 0;
                for ($j = $i - 1; $j >= 0; $j--) {
                    if ($stalls[$j] == 1) break;
                    $leftDistance++;
                }

                $rightDistance = 0;
                for ($j = $i + 1; $j <= $N + 1; $j++) {
                    if ($stalls[$j] == 1) break;
                    $rightDistance++;
                }

                
                $minDistance = min($leftDistance, $rightDistance);
                $maxDistance = max($leftDistance, $rightDistance);

                
                if ($maxOfMinDistances === null || $minDistance > $maxOfMinDistances) {
                    $bestStall = $i;
                    $maxOfMinDistances = $minDistance;
                    $maxOfMaxDistances = $maxDistance;
                } elseif ($minDistance == $maxOfMinDistances) {
                    if ($maxDistance > $maxOfMaxDistances) {
                        $bestStall = $i;
                        $maxOfMaxDistances = $maxDistance;
                    } elseif ($maxDistance == $maxOfMaxDistances && $i < $bestStall) {
                        $bestStall = $i; 
                    }
                }
            }
        }

        
        $stalls[$bestStall] = 1;

        // To check the last person
        if ($currentPerson == $K) {
            return [$maxOfMaxDistances, $maxOfMinDistances];
        }
    }
}


//Output

function processTestFile($filename) {
    $input = file_get_contents($filename); 
    $rows = explode("\n", trim($input)); 
    $T = (int) array_shift($rows); 
    $output = [];

    $index = 0;
    for ($t = 1; $t <= $T; $t++) {

        list($N, $K) = explode(" ", $rows[$index]);
        $N = (int) $N;
        $K = (int) $K;
        $index++;

        list($y, $z) = simulateBathroomStalls($N, $K);

        $output[] = "Case #$t: $y $z";
    }

    return implode(PHP_EOL, $output); 
}


function main() {
    $files = ['ts1_input.txt'];

    foreach ($files as $file) {
        echo "Processing file: $file\n";
        $result = processTestFile($file); 
        echo $result . PHP_EOL; 
    }
}

main();
