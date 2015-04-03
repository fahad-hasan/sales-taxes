<?php

trait roundNumber
{
    /*
    Rounds a number to its nearest 0.05
    */
    public function roundNumber($number) 
    {
        return ceil($number / 0.05) * 0.05;
    }
}

trait sanitizeNumber
{
    /*
    Sanitizes a decimal with trailing 0's when needed
    */
    public function sanitizeNumber($number) 
    {
        return number_format($number, 2, '.', '');
    }
}

trait cleanString
{
    public function cleanString($text) 
    {
        $text = htmlspecialchars(strip_tags($text));
        $text = str_replace('"', "", $text);
        $text = str_replace("'", "", $text);
        return $text;
    }
}

?>