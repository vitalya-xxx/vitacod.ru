<?php
class Item {
    /** @var mixed */
    public $value;

    /**
     * Содержит пары "название" => подэлемент.
     * @var Item[]
     */
    public $subItems = array();

    public function __construct($value, array $subItems = array()) {
        $this->value = $value;
        $this->subItems = $subItems;
    }
}

$root = new Item(10, array(
    'sub1' => new Item(11),
    'sub2' => new Item(12, array(
        'sub3' => new Item(11),
        'sub4' => new Item(15)
    )),
    'sub3' => new Item(18),
));

    function printTree ($root, $lavel = 0){
        $result = '';
        $lavel++;

        foreach ($root as $one) {
            $result .= '(уровень вложенности '.$lavel.'): ('.$one->value.') < br >';
            if ($one->subItems) {
                foreach ($one->subItems as $item) {
                    $result .= printTree ($item, $lavel);
                }
            }
        }
        return $result;
    }

     function search($root, $value){
         $result = '';
         $elem = false;

         foreach ($root as $one) {
             $result .= '/'.$one->value;
             if ($value == $one->value) {
                 $elem = true;
                 break;
             }
             else if ($one->subItems) {
                 foreach ($one->subItems as $item) {
                     search($root, $value);
                 }
             }
         }

         if ($elem) {
             return $result;
         }
         else {
             return false;
         }
     }