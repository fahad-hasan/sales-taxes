<?php

trait roundNumber
{
    public function roundNumber($number) 
    {
        return ceil($number / 0.05) * 0.05;
    }
}

trait sanitizeNumber
{
    public function sanitizeNumber($number) 
    {
        return number_format($number, 2, '.', '');
    }
}

?>