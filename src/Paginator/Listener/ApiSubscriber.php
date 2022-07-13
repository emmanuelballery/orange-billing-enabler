<?php declare(strict_types=1);

namespace App\Paginator\Listener;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use function iterator_count;

/**
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
class ApiSubscriber implements EventSubscriberInterface
{
    private ?Paginator $paginator = null;

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['onPreSerialize', EventPriorities::PRE_SERIALIZE],
            KernelEvents::RESPONSE => ['onResponse', EventPriorities::PRE_RESPOND],
        ];
    }

    public function onPreSerialize(ViewEvent $event): void
    {
        $paginator = $event->getControllerResult();
        if ($paginator instanceof Paginator) {
            $this->paginator = $paginator;
        }
    }

    public function onResponse(ResponseEvent $event): void
    {
        if (
            null !== $this->paginator &&
            $event->getRequest()->isMethod('GET') &&
            Response::HTTP_OK === $event->getResponse()->getStatusCode() &&
            'json' === $event->getRequest()->getRequestFormat()
        ) {
            $count = iterator_count($this->paginator->getIterator());

            $headers = $event->getResponse()->headers;
            $headers->set('X-Paginator-Page', (string)$this->paginator->getCurrentPage());
            $headers->set('X-Paginator-Limit', (string)$this->paginator->getItemsPerPage());
            $headers->set('X-Paginator-Count', (string)$this->paginator->getTotalItems());
            $headers->set('X-Result-Count', (string)$count);
            $headers->set('X-Total-Count', (string)$this->paginator->getTotalItems());
            $this->paginator = null;
        }
    }
}
