<?php

namespace AppBundle\Game;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GameHandler
{
    private $context;
    private $wordList;
    private $defaultWordLength;

    public function __construct(
        GameContextInterface $context,
        WordListInterface $wordList,
        $defaultWordLength
    )
    {
        $this->context = $context;
        $this->wordList = $wordList;
        $this->defaultWordLength = (int) $defaultWordLength;
    }

    public function loadGame($length = null)
    {
        if ($game = $this->context->loadGame()) {
            return $game;
        }

        if (null === $length) {
            $length = $this->defaultWordLength;
        }

        $word = $this->wordList->getRandomWord($length);
        $game = $this->context->newGame($word);
        $this->context->save($game);

        return $game;
    }

    public function playLetter($letter)
    {
        if (!$game = $this->context->loadGame()) {
            throw $this->createNotFoundException('No game context loaded before playing a letter.');
        }

        $game->tryLetter($letter);
        $this->context->save($game);

        return $game;
    }

    public function playWord($word)
    {
        if (!$game = $this->context->loadGame()) {
            throw $this->createNotFoundException('No game context loaded before playing a word.');
        }

        $game->tryWord($word);
        $this->context->save($game);

        return $game;
    }

    public function resetGame()
    {
        $this->context->reset();
    }

    public function resetGameOnSuccess()
    {
        if (!$game = $this->context->loadGame()) {
            throw $this->createNotFoundException('No game context loaded before accessing congratulations page.');
        }

        if (!$game->isWon()) {
            throw $this->createNotFoundException('Game is not yet won.');
        }

        $this->resetGame();

        return $game;
    }

    public function resetGameOnFailure()
    {
        if (!$game = $this->context->loadGame()) {
            throw $this->createNotFoundException('No game context loaded before accessing failing page.');
        }

        if (!$game->isHanged()) {
            throw $this->createNotFoundException('Game is not yet failed.');
        }

        $this->resetGame();

        return $game;
    }

    private function createNotFoundException($message)
    {
        return new NotFoundHttpException($message);
    }
}
