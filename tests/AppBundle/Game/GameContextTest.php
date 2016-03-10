<?php

namespace Tests\AppBundle\Game;

use AppBundle\Game\GameContext as SUT;
use AppBundle\Game\Game;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class GameTestContext extends \PHPUnit_Framework_TestCase
{
		
	public function testReset()
	{
		$session = $this->getMock(SessionInterface::class);

		$sut = new SUT($session);

		$game = new Game('yolo');

		$this->assertEquals($game,$sut->newGame('yolo'));
	}

	public function testLoadGameWithNoData(){
		$session = $this->getMock(SessionInterface::class);

		$session
			->expects($this->once())
			->method('get')
			->with('hangman')
			->willReturn(null)
		;

		$sut = new SUT($session);

		$this->assertFalse($sut->loadGame());
	}
}