<?php

namespace InWeb\Payment\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Payer
{
    public function getKey();

    /**
     * @return MorphMany
     */
    public function payments();
}