<?php

namespace InWeb\Payment\Contracts\Driver;

interface DayShouldBeClosed {
    public function closeDay(): void;
}
