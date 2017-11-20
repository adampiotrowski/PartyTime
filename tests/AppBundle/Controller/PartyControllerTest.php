<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PartyControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testSearch()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/search/51.80,19.37');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
