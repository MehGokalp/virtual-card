<?php

namespace VirtualCard\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonRequestBodyEventSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onRequestEvent',
        ];
    }

    public function onRequestEvent(RequestEvent $event): void
    {
        if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
            return;
        }

        $request = $event->getRequest();

        if ($request->getMethod() === Request::METHOD_GET) {
            return;
        }

        $contentTypeHeader = $request->headers->get('Content-Type');

        if (strpos($contentTypeHeader, 'application/json') === false) {
            throw new BadRequestHttpException(sprintf('Unsupported accept type: %s', $contentTypeHeader));
        }

        $requestBody = $request->getContent();

        $data = json_decode($requestBody, true);

        if (json_last_error() !== 0) {
            throw new BadRequestHttpException(sprintf('Malformed json body: %s', json_last_error_msg()));
        }

        if (is_array($data) === false) {
            throw new BadRequestHttpException('Malformed json body');
        }

        $request->request->replace($data);
    }
}
