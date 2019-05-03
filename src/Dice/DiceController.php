<?php

namespace Faxity\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

/**
 * Route controller for the dice game 100 in Anax
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * Route for GET /dice
     * @return object.
     */
    public function indexActionGet() : object
    {
        $app = $this->app;
        $app->page->add("dice/start");

        return $app->page->render([
            "title" => "Tärningsspelet 100",
        ]);
    }

    /**
     * Route for GET /dice/turn
     * @return object.
     */
    public function turnActionGet() : object
    {
        $app = $this->app;
        $game = $app->session->get("dice");

        // No game was started, redirect to start menu
        if (!isset($game)) {
            $url = $app->request->getBaseUrl();
            return $app->response->redirect("{$url}/dice");
        }

        // Add view and required data
        $app->page->add("dice/game", [
            "game" => $game,
            "player" => $game->player(),
            "cpu" => $game->cpu(),
        ]);
    
        return $app->page->render([
            "title" => "Tärningsspelet 100",
        ]);
    }

    /**
     * Route for GET /dice/end
     * @return object.
     */
    public function endActionGet() : object
    {
        $app = $this->app;
        $game = $app->session->get("dice");

        // No game was started, redirect to start menu
        if (!isset($game)) {
            $url = $app->request->getBaseUrl();
            return $app->response->redirect("{$url}/dice");
        }

        // Add view and required data
        $app->page->add("dice/end", [
            "game" => $game,
            "player" => $game->player(),
            "cpu" => $game->cpu(),
        ]);

        return $app->page->render([
            "title" => "Tärningsspelet 100",
        ]);
    }

    /**
     * Route for POST /dice
     * @return object.
     */
    public function indexActionPost() : object
    {
        $app = $this->app;
        $game = new \Faxity\Dice\Game();
        $app->session->set("dice", $game);

        $url = $app->request->getCurrentUrl();
        return $app->response->redirect("{$url}/turn");
    }

    /**
     * Route for POST /dice/turn
     * @return object.
     */
    public function turnActionPost() : object
    {
        $app = $this->app;
        $game = $app->session->get("dice");
        $action = $app->request->getPost("action");

        if ($action == "toss") {
            $game->toss();
        } else if ($action == "end_turn") {
            $game->endTurn();
        }

        // Update session
        $app->session->set("dice", $game);

        // Check for any winners
        if ($game->gameOver()) {
            $url = $app->request->getBaseUrl();
            return $app->response->redirect("$url/d100/end");
        }

        $url = $app->request->getCurrentUrl();
        return $app->response->redirect($url);
    }

    /**
     * Route for POST /dice/end
     * @return object.
     */
    public function endActionPost() : object
    {
        $app = $this->app;
        $baseUrl = $app->request->getBaseUrl();

        $app->session->delete("dice");

        return $app->response->redirect("{$baseUrl}/d100");
    }
}
