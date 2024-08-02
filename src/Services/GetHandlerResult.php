<?php

namespace App\Services;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class GetHandlerResult
{
    public static function invoke(Envelope $envelope): mixed
    {
        return $envelope->last(HandledStamp::class)->getResult();
    }
}
