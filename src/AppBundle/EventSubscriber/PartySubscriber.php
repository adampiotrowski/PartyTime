<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace AppBundle\EventSubscriber;

use AppBundle\Entity\Party;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class PartySubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class PartySubscriber implements EventSubscriberInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;
    
    public static function getSubscribedEvents()
    {
        return [
            'party.post_create' => ['onPartyPostCreate'],
        ];
    }
    
    public function onPartyPostCreate(GenericEvent $event)
    {
        $party = $event->getSubject();
        if ($party instanceof Party) {
            $this->sendConfirmationEmail($party);
        }
    }
    
    private function sendConfirmationEmail(Party $party)
    {
        echo get_class($this->container);
        die();
        
        $recipient = $this->container->getParameter('email_recipient');
        $body      = $this->renderMessageBody($party);
        $message   = (new \Swift_Message('Party confirmation'))
            ->setFrom($recipient)
            ->setTo($recipient)
            ->setBody($body, 'text/html');
        
        $result = $this->getMailer()->send($message);
        
        if (0 === $result) {
            $this->getLogger()->error('Party confirmation e-mail was not sent.', [
                'recipient' => $recipient,
                'party'     => $party->getId(),
            ]);
        }
    }
    
    private function renderMessageBody(Party $party): string
    {
        return $this->getTemplating()->render('Email/party_confirmation.html.twig', [
            'party' => $party,
        ]);
    }
    
    private function getMailer(): \Swift_Mailer
    {
        return $this->container->get('swiftmailer.mailer');
    }
    
    private function getLogger(): LoggerInterface
    {
        return $this->container->get('logger');
    }
    
    private function getTemplating(): EngineInterface
    {
        return $this->container->get('templating');
    }
}
