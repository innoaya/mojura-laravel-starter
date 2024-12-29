<?php

namespace App\Helpers;

class StringUtility
{
    public static function snakeCaseToTitleCase($string)
    {
        // Replace underscores with spaces
        $stringWithSpaces = str_replace('_', ' ', $string);

        // Capitalize the first letter of each word
        $titleCasedString = ucwords($stringWithSpaces);

        return $titleCasedString;
    }

    public static function camelCaseToTitleCase($string)
    {
        // Insert a space before each uppercase letter, except the first one
        $stringWithSpaces = preg_replace('/(?<!^)[A-Z]/', ' $0', $string);

        // Capitalize the first letter of each word
        $titleCasedString = ucwords($stringWithSpaces);

        return $titleCasedString;
    }

    public static function stringWithSpacesToSnakeCase($string)
    {
        // Convert the string to lowercase
        $lowercasedString = strtolower($string);

        // Replace spaces with underscores
        $snakeCasedString = str_replace(' ', '_', $lowercasedString);

        return $snakeCasedString;
    }
}
