<?php


namespace Adapter;


interface DatabaseInterface
{
    public function prepare($sql): DatabaseStatementInterface;

    public function errorInfo();
}