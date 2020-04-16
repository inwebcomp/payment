<?php

namespace InWeb\Payment\Drivers\Paynet;

/**************************************
 * Version: 1.0
 * User: v.bragari
 * Email: v.bragari@paynet.md
 * Date: 2018-07-07
 */
class PaynetResult
{
    public $Code;
    public $Message;
    public $Data;

    public function IsOk()
    {
        return $this->Code === PaynetCode::SUCCESS;
    }
}