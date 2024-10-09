<?php

namespace App\Interfaces;

interface ClientIdFromTurnstileInterface
{
    public function getId(array $mac);
}
