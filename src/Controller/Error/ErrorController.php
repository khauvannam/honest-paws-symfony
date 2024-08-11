<?php

// src/Controller/ErrorController.php
namespace App\Controller\Error;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ErrorController extends AbstractController
{
    #[Route('/error/{statusCode}', name: 'error_page')]
    public function show(int $statusCode): Response
    {
        // Tạo nội dung tùy chỉnh cho các mã trạng thái khác nhau
        switch ($statusCode) {
            case 404:
                $message = 'Page not found';
                break;
            case 500:
                $message = 'Internal server error';
                break;
            default:
                $message = 'Something went wrong';
                break;
        }

        return $this->render('error/error.html.twig', [
            'statusCode' => $statusCode,
            'message' => $message,
        ]);
    }
}
