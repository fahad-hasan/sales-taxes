<?php

class CartItemFactory 
{
    const SALES_TAX_PERCENT = 0.1;
    const IMPORT_DUTY_PERCENT = 0.05;

    private function isImported($name) 
    {
        return strpos(strtolower($name), "imported") !== false ? true : false;
    }

    private function isTaxExempted($name) 
    {
        $keywords = array("food", "chocolate", "chocolates", "pills", "pill", "book", "books");
        $name_array = explode(" ", strtolower($name));
        if (!empty(array_intersect($name_array, $keywords))) {
            return true;
        } else {
            return false;
        }
    }

    private function getSalesTax($name, $price)
    {    
        if (self::isTaxExempted($name)) {
            return 0;
        } else {
            return $price * CartItemFactory::SALES_TAX_PERCENT;
        }
    }

    private function getImportDuty($name, $price) 
    {
        if (self::isImported($name)) {
            return $price * CartItemFactory::IMPORT_DUTY_PERCENT;
        } else {
            return 0;
        }
    }

    private static function cleanString($text) 
    {
        $text = htmlspecialchars(strip_tags($text));
        $text = str_replace('"', "", $text);
        $text = str_replace("'", "", $text);
        return $text;
    }

    public static function create($quantity, $name, $price) 
    {
        $item = array();
        $name = self::cleanString($name);
        $item['quantity'] = $quantity >= 1 ? $quantity : 1;
        $item['name'] = $name;
        $item['price'] = $price;
        $item['sales_tax'] = self::getSalesTax($name, $price);
        $item['import_duty'] = self::getImportDuty($name, $price);

        return new CartItem($item);
    }
}

?>