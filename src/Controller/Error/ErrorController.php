<?php

// src/Controller/ErrorController.php
namespace App\Controller\Error;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/error/{statusCode}', name: 'error_page')]
    public function show(int $statusCode): Response
    {
        // Tạo nội dung tùy chỉnh cho các mã trạng thái khác nhau
        $message = match ($statusCode) {
            404 => 'Page not found',
            500 => 'Internal server error',
            default => 'Something went wrong',
        };

        return $this->render('error/error.html.twig', [
            'statusCode' => $statusCode,
            'message' => $message,
        ]);
    }
}
