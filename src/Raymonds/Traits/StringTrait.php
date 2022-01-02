<?php

declare(strict_types=1);

namespace Raymonds\Traits;

trait StringTrait
{
    public function longest_common_substring($first, $second)
    {
        $longestCommonSubstringIndexInFirst = 0;
        $table = array();
        $largestFound = 0;

        $firstLength = strlen($first);
        $secondLength = strlen($second);
        for ($i = 0; $i < $firstLength; $i++) {
            for ($j = 0; $j < $secondLength; $j++) {
                if ($first[$i] === $second[$j]) {
                    if (!isset($table[$i])) {
                        $table[$i] = array();
                    }

                    if ($i > 0 && $j > 0 && isset($table[$i - 1][$j - 1])) {
                        $table[$i][$j] = $table[$i - 1][$j - 1] + 1;
                    } else {
                        $table[$i][$j] = 1;
                    }

                    if ($table[$i][$j] > $largestFound) {
                        $largestFound = $table[$i][$j];
                        $longestCommonSubstringIndexInFirst = $i - $largestFound + 1;
                    }
                }
            }
        }
        if ($largestFound === 0) {
            return "";
        } else {
            return substr($first, $longestCommonSubstringIndexInFirst, $largestFound);
        }
    }
}
