<?php
class TransactionDTO
{
    public $value;
    public $category;
    public $date;
    public $description;
    public $type;

    function __construct(array $array)
    {
        $this->value = $array['value'];
        $this->category = $array['category'];
        $this->date = new DateTime($array['date']);
        $this->description = $array['description'];
        $this->type = $array['type'];
    }
}
