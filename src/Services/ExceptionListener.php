<?php
// src/EventListener/ExceptionListener.php
namespace App\Services;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Routing\RouterInterface;

class ExceptionListener
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        // Kiểm tra xem ngoại lệ có phải là HttpException hay không
        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }

        // Chuyển hướng đến trang lỗi
        $response = new RedirectResponse($this->router->generate('error_page', ['statusCode' => $statusCode]));
        $event->setResponse($response);
    }
}
