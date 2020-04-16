<?php

namespace InWeb\Payment\Drivers\Paynet;

/**************************************
 * Version: 1.0
 * User: v.bragari
 * Email: v.bragari@paynet.md
 * Date: 2018-07-07
 */
class PaynetCode
{
    const SUCCESS = 0;
    const TECHNICAL_ERROR = 1;
    const DATABASE_ERROR = 2;
    const USERNAME_OR_PASSWORD_WRONG = 3;
    const CONNECTION_ERROR = 12;
}