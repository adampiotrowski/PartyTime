<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Party;
use AppBundle\Form\CommentType;
use AppBundle\Form\PartyType;
use AppBundle\Form\SearchPartyType;
use AppBundle\Model\SearchParty;
use AppBundle\Service\Geocoder\GeocoderHelperInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PartyController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PartyController extends Controller
{
    public function indexAction(Request $request): Response
    {
        $searchParty = new SearchParty();
        $em          = $this->getDoctrine()->getManager();
        $parties     = $em->getRepository(Party::class)->findAll();
        $form        = $this->createForm(SearchPartyType::class, $searchParty);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $geocodeResult = $this->getGeoCoderHelper()->geocodeAddress($searchParty);
            
            return $this->redirectToRoute('party_search', [
                'latitude'  => $geocodeResult->getLatitude(),
                'longitude' => $geocodeResult->getLongitude(),
            ]);
        }
        
        return $this->render('party/index.html.twig', [
            'parties'    => $parties,
            'searchForm' => $form->createView(),
        ]);
    }
    
    public function searchAction(float $latitude = null, float $longitude = null): Response
    {
        $em      = $this->getDoctrine()->getManager();
        $parties = $em->getRepository(Party::class)->findAll();
        
        return $this->render('party/search.html.twig', [
            'parties' => $parties,
        ]);
    }
    
    public function newAction(Request $request): Response
    {
        $party = new Party();
        $form  = $this->createForm(PartyType::class, $party);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($party);
            $em->flush();
            
            $this->sendConfirmationEmail($party);
            
            return $this->redirectToRoute('party_show', ['id' => $party->getId()]);
        }
        
        return $this->render('party/new.html.twig', [
            'party' => $party,
            'form'  => $form->createView(),
        ]);
    }
    
    public function showAction(Request $request, Party $party): Response
    {
        $comment = new Comment($party);
        $form    = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            
            return $this->redirectToRoute('party_show', ['id' => $party->getId()]);
        }
        
        return $this->render('party/show.html.twig', [
            'party'        => $party,
            'comment_form' => $form->createView(),
        ]);
    }
    
    public function deleteCommentAction(Comment $comment): Response
    {
        $party = $comment->getParty();
        $em    = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();
        
        return $this->redirectToRoute('party_show', ['id' => $party->getId()]);
    }
    
    private function sendConfirmationEmail(Party $party)
    {
        $recipient = $this->getParameter('email_recipient');
        $body      = $this->renderView('Email/party_confirmation.html.twig', [
            'party' => $party,
        ]);
        
        $message = (new \Swift_Message('Party confirmation'))
            ->setFrom($recipient)
            ->setTo($recipient)
            ->setBody($body, 'text/html');
        
        try {
            $this->getMailer()->send($message);
        } catch (\Exception $e) {
            $this->getLogger()->error('Party confirmation e-mail was not sent.', [
                'recipient' => $recipient,
                'party'     => $party->getId(),
                'message'   => $e->getMessage(),
            ]);
        }
    }
    
    private function getGeoCoderHelper(): GeocoderHelperInterface
    {
        return $this->getGeoCoderHelper();
    }
    
    private function getMailer(): \Swift_Mailer
    {
        return $this->get('swiftmailer.mailer');
    }
    
    private function getLogger(): LoggerInterface
    {
        return $this->get('logger');
    }
}
