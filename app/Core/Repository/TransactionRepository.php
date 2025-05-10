<?php
interface TransactionRepositoryInterface
{
    public function read();
    public function add(TransactionDTO $transaction);
    public function remove();
}
