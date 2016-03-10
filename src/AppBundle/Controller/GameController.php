<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/** @Route("/game") */
class GameController extends Controller
{
    /**
     * This action enables the user to play the game.
     *
     * @Route("/")
     * @Route("/play", name="game_play")
     * @Method("GET")
     */
    public function playAction()
    {
        $game = $this->get('game_handler')->loadGame();

        return $this->render('game/play.html.twig', [ 'game' => $game ]);
    }

    /**
     * This action enables the user to play a single letter at a time.
     *
     * @Route("/letter/{letter}", name="game_play_letter", requirements={
     *   "letter"="[a-z]"
     * })
     * @Method("GET")
     */
    public function playLetterAction($letter)
    {
        $game = $this->get('game_handler')->playLetter($letter);

        if (!$game->isOver()) {
            return $this->redirectToRoute('game_play');
        }

        return $this->redirectToRoute($game->isWon() ? 'game_win' : 'game_fail');
    }

    /**
     * This action enables the user to play a word.
     *
     * @Route(
     *   path="/word",
     *   name="game_play_word",
     *   condition="request.request.get('word') matches '/^[a-z]+$/i'"
     * )
     * @Method("POST")
     */
    public function playWordAction(Request $request)
    {
        $game = $this->get('game_handler')->playWord($request->request->get('word'));

        return $this->redirectToRoute($game->isWon() ? 'game_win' : 'game_fail');
    }

    /**
     * This action resets the current game and starts a new one.
     *
     * @Route("/reset", name="game_reset")
     * @Method("GET")
     */
    public function resetAction()
    {
        $this->get('game_handler')->resetGame();

        return $this->redirectToRoute('game_play');
    }

    /**
     * This action displays the congratulations page if the user won the game.
     *
     * @Route("/win", name="game_win")
     * @Method("GET")
     */
    public function winAction()
    {
        $game = $this->get('game_handler')->resetGameOnSuccess();

        return $this->render('game/win.html.twig', [ 'game' => $game ]);
    }

    /**
     * This action displays the loosing page if the user failed the game.
     *
     * @Route("/fail", name="game_fail")
     * @Method("GET")
     */
    public function failAction()
    {
        $game = $this->get('game_handler')->resetGameOnFailure();

        return $this->render('game/fail.html.twig', [ 'game' => $game ]);
    }

}
