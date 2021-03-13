<?php
class Libarray
{
    public static function pop(array $array, $element, int $key = 0): array
    {
        return [$key => $element] + $array; // Union de tableaux
    }
}