<?php

function solveFashionShow($N, $M, $models) {
    // Create an empty N x N grid
    $grid = array_fill(0, $N, array_fill(0, $N, '.'));

    // Place pre-placed models
    foreach ($models as $model) {
        $grid[$model['row'] - 1][$model['col'] - 1] = $model['type'];
    }

    // Step 1: Place rooks (x)
    $rooks = [];
    for ($i = 0; $i < $N; $i++) {
        for ($j = 0; $j < $N; $j++) {
            if ($grid[$i][$j] == '.' && !in_array($i, $rooks)) {
                $grid[$i][$j] = 'x';  // Place rook
                $rooks[] = $i;  // Block row
                break;
            }
        }
    }

    // Step 2: Place bishops (+)
    $bishops = [];
    for ($i = 0; $i < $N; $i++) {
        for ($j = 0; $j < $N; $j++) {
            if ($grid[$i][$j] == '.') {
                $grid[$i][$j] = '+';  // Place bishop
                break;
            }
        }
    }

    // Count points and generate the result
    $points = 0;
    $changes = [];
    for ($i = 0; $i < $N; $i++) {
        for ($j = 0; $j < $N; $j++) {
            if ($grid[$i][$j] == 'x') {
                $points++;
                $changes[] = ['type' => 'x', 'row' => $i + 1, 'col' => $j + 1];
            } elseif ($grid[$i][$j] == '+') {
                $points++;
                $changes[] = ['type' => '+', 'row' => $i + 1, 'col' => $j + 1];
            }
        }
    }

    return ['points' => $points, 'changes' => $changes];
}

function processTestFile($filename) {
    $input = file_get_contents($filename); 
    $rows = explode("\n", trim($input)); 
    $T = (int) array_shift($rows); // Number of test cases
    $output = [];

    $index = 0;
    for ($z = 1; $z <= $T; $z++) {
        // Read the first line for N and M
        list($N, $M) = explode(" ", $rows[$index]);
        $N = (int) $N;
        $M = (int) $M;
        $index++;

        // Read the next M lines for pre-placed models
        $models = [];
        for ($m = 0; $m < $M; $m++) {
            list($type, $row, $col) = explode(" ", $rows[$index]);
            $models[] = ['type' => $type, 'row' => (int) $row, 'col' => (int) $col];
            $index++;
        }

        // Solve the fashion show problem for this test case
        $result = solveFashionShow($N, $M, $models);

        // Format the output
        $output[] = "Case #$z: " . $result['points'];
        foreach ($result['changes'] as $change) {
            $output[] = $change['type'] . " " . $change['row'] . " " . $change['col'];
        }
    }

    // Join the result into a single string
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
