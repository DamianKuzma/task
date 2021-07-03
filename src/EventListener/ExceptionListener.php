<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\AccessDeniedException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionListener implements EventSubscriberInterface
{
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 226],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse();

        if ($this->getInstance($exception)) {
            $response->setStatusCode(400);
        }

        $event->setResponse($response->setContent($exception->getMessage()));
        $this->logger->warning('Need authentication for create new city!');
    }

    private function getInstance($exception): bool
    {
        return ($exception instanceof AccessDeniedException);
    }
}