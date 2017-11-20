<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Party;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PartyControllerTest extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    protected $client = null;
    
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;
    
    public function setUp()
    {
        $this->client    = static::createClient();
        $this->container = $this->client->getContainer();
    }
    
    public function testIndex()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testSearch()
    {
        $client = static::createClient();
        
        $url = $this->generateUrl('party_search', [
            'latitude'  => 51.90,
            'longitude' => 19.37,
        ]);
        
        $crawler = $client->request('GET', $url);
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testShow()
    {
        $client  = static::createClient();
        $parties = $this->container->get('doctrine')->getRepository(Party::class)->findAll();
        
        /** @var Party $party */
        foreach ($parties as $party) {
            $url = $this->generateUrl('party_show', [
                'id' => $party->getId(),
            ]);
            
            $crawler = $client->request('GET', $url);
            
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }
    }
    
    /**
     * Returns an URL generated for route
     *
     * @param string     $routeName
     * @param array      $params
     * @param bool|false $absolute
     *
     * @return string
     */
    protected function generateUrl($routeName, array $params = [], $absolute = false)
    {
        return $this->container->get('router')->generate($routeName, $params, $absolute);
    }
}
