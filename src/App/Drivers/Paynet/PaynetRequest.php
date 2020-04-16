<?php

namespace InWeb\Payment\Drivers\Paynet;

/**************************************
 * Version: 1.0
 * User: v.bragari
 * Email: v.bragari@paynet.md
 * Date: 2018-07-07
 */
class PaynetRequest
{
    public $ExternalDate;
    public $ExternalID;
    public $Currency = 498;
    public $Merchant;
    public $LinkSuccess;
    public $LinkCancel;
    public $ExpiryDate;
    //---------  ru, ro, en
    public $Lang;
    public $Services = [];
    public $Products = [];
    public $Customer = [];
    public $Amount;
}