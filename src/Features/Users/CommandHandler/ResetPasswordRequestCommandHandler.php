<?php

namespace App\Features\Users\CommandHandler;

use App\Features\Users\Command\ResetPasswordRequestCommand;
use App\Services\TokenService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ResetPasswordRequestCommandHandler
{

    public function __construct(private TokenService $service)
    {
    }

    public function __invoke(ResetPasswordRequestCommand $command): void
    {
        $this->service->createToken($command);
    }
}