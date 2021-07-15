<?php


namespace App\Core;


class Logger
{
    public static function log($something): void
    {
        $debugFileSplittedBySlash = explode("/", debug_backtrace(2, 3)[0]['file']);
        $debugLineSplittedBySlash = explode("/", debug_backtrace(2, 3)[0]['line']);
        $fromFile = end($debugFileSplittedBySlash);
        $fromLine = end($debugLineSplittedBySlash);
        $str = "-- From File : $fromFile / Line : $fromLine --\n";
        if (is_array($something)) {
            $str .= recArray($something);
        } else {
            $str .= (gettype($something) === "boolean" ? ($something ? 'true' : 'false') : $something);
        }
        error_log($str . PHP_EOL, 3, __DIR__ . "/../error.log");
    }

    public static function dd($content) {
        echo '<pre>';
        die(var_dump($content));
        echo '</pre>';
    }

}

function recArray($array, $deep = 0): string
{
    $whitespace = "";
    $str = "";
    for ($i = 0; $i < $deep; $i++) {
        $whitespace .= "    ";
    }
    if (!empty($array)) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $deep++;
                $str .= $whitespace . "[$key] => [\n" . recArray($value, $deep) . $whitespace . "]\n";
            } else {
                if (canConvertedToString($value)) {
                    $str .= $whitespace . "[$key] => " . (gettype($value) === "boolean" ? ($value ? 'true' : 'false') : $value) . "\n";
                } else {
                    $str .= $whitespace . "[$key] => " . gettype($value) . "\n";
                }

            }
        }
    } else {
        $str .= $whitespace."[empty]\n";
    }

    return $str;
}

function canConvertedToString($something): bool
{
    return (!is_array($something)) &&
        ((!is_object($something) && settype($something, 'string') !== false) ||
            (is_object($something) && method_exists($something, '__toString')));
}