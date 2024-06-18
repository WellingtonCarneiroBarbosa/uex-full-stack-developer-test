<?php

if (!function_exists('format')) {
    /**
     * Format a string with a custom pattern.
     *
     * @param string $string
     * @param string $pattern
     * @return string
     */
    function format(?string $string, string $pattern): string
    {
        if (!$string) {
            return '';
        }

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

if (!function_exists('extractDigitsRegex')) {
    /**
     * Removes non numeric characters from a given string
     *
     * @param string $string
     * @return string
     */
    function extractDigitsRegex(?string $string = ''): string
    {
        if (!$string) {
            return '';
        }

        return preg_replace('/[^0-9]/', '', $string);
    }
}
