<?php
class TransactionPresenter
{
    public $value;
    public $category;
    public $date;
    public $description;
    public $type;

    function __construct(string $value, string $category, string $date, string $description, string $type)
    {
        $this->value = $this->format_value($value);
        $this->category = $category;
        $this->date = $this->format_date($date);
        $this->description = $description;
        $this->type = $this->format_type($type, $date);
    }

    public function format_value(string $value): string
    {
        $value = (float) $value;
        return number_format($value, 2, ',', '.');
    }

    public function format_type(string $type, string $date): string
    {
        if ($type == "despesa") {
            $transaction_date = new DateTime($date);
            $current_date = new DateTime(date('Y-m-d', time()));

            return ($transaction_date > $current_date) ? "despesa-futura" : "despesa";
        }
        return "receita";
    }

    public function format_date($date): string
    {
        $date = (new DateTime($date))->format('d/m/Y');

        $months = [
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        ];

        $dateParts = explode('/', $date);
        $formattedDate = "{$dateParts[0]} de {$months[$dateParts[1]]} de {$dateParts[2]}";

        return $formattedDate;
    }
}
