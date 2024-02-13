<?php
namespace App\Http\Reports;

class Report
{
    public function isEmpty($value)
    {
        return $value == "" || $value == null;
    }
}