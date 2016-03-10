<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request('GET', '/game/play');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertContains(
        	'You still have 11 remaining attempts.',
        	$client->getResponse()->getContent()
        );

        $this->assertCount(3,$crawler->filter('li.letter.hidden'));

        //A
        $crawler = $client->click($crawler->selectLink('A')->link());
        $this->assertContains(
        	'You still have 10 remaining attempts.',
        	$client->getResponse()->getContent()
        );
        
        //P
        $crawler = $client->click($crawler->selectLink('P')->link());
        $this->assertContains(
        	'You still have 10 remaining attempts.',
        	$client->getResponse()->getContent()
        );

        //H
        $crawler = $client->click($crawler->selectLink('H')->link());
		$this->assertContains(
        	'Congratulations!',
        	$client->getResponse()->getContent()
        );

        $this->assertSame('/game/win',$client->getRequest()->getRequestUri());


    }
}