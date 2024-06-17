<?php

if (!function_exists('format')) {
    /**
     * Format a string with a custom pattern.
     *
     * @param string $string
     * @param string $pattern
     * @return string
     */
    function format($string, $pattern)
    {
        $formattedString = '';
        $stringLength    = strlen($string);
        $patternLength   = strlen($pattern);
        $j               = 0;

        for ($i = 0; $i < $patternLength; $i++) {
            if ($j < $stringLength && $pattern[$i] === '#') {
                $formattedString .= $string[$j];
                $j++;
            } else {
                $formattedString .= $pattern[$i];
            }
        }

        return $formattedString;
    }
}
