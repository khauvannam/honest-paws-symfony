<?php

namespace App\Features\Users\CommandHandler;

use App\Features\Users\Command\ResetPasswordVerifyCommand;
use App\Services\TokenService;
use RuntimeException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ResetPasswordVerifyCommandHandler
{
    public function __construct(private TokenService $service)
    {
    }

    public function __invoke(ResetPasswordVerifyCommand $command): void
    {
        $result = $this->service->checkValidToken($command);
        if (!$result) throw new RuntimeException('Invalid token');

    }

}