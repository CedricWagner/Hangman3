<?php

namespace Tests\AppBundle\Game;

use AppBundle\Game\Game as SUT;


class GameTest extends \PHPUnit_Framework_TestCase
{
		
	public function testConstructWithDefaultValues()
	{
		$sut = new SUT('test');

		// $this->assertSame('test',$sut->getWord());
		// $this->assertSame(0,$sut->getAttempts());
		// $this->assertSame([],$sut->getTriedLetters());
		// $this->assertSame([],$sut->getFoundLetters());
	}

	public function testTryLetterWithInvalidLetter()
	{
		$sut = new SUT('test');

		// $this->setExpectedException(\InvalidArgumentException::class,sprintf('%s is not a letter, duh !','3'));
		
		// $sut->tryLetter(3);
	}

	public function provideTryLetterWithInvalidLetter(){
		return [
			[3],
			['ab'],
			['é'],
		];
	}
}