<?php

/**
 * Renders the guess view within Anax, with required data.
 */
$app->router->get("dice100", function () use ($app) {
    $app->page->add("dice100/start");

    return $app->page->render([
        "title" => "Tärningsspelet 100",
    ]);
});

$app->router->get("dice100/round", function () use ($app) {
    $game = $app->session->get("dice100");

    // No game was started, redirect to start menu
    if (!isset($game)) {
        $url = $app->request->getBaseUrl();
        return $app->response->redirect("{$url}/dice100");
    }

    // Add view and required data
    $app->page->add("dice100/game", [
        "game" => $game,
        "player" => $game->player(),
        "cpu" => $game->cpu(),
    ]);

    return $app->page->render([
        "title" => "Tärningsspelet 100",
    ]);
});

$app->router->get("dice100/end", function () use ($app) {
    $game = $app->session->get("dice100");

    // No game was started, redirect to start menu
    if (!isset($game)) {
        $url = $app->request->getBaseUrl();
        return $app->response->redirect("{$url}/dice100");
    }

    // Add view and required data
    $app->page->add("dice100/end", [
        "game" => $game,
        "player" => $game->player(),
        "cpu" => $game->cpu(),
    ]);

    return $app->page->render([
        "title" => "Tärningsspelet 100",
    ]);
});

/**
 * Makes a guess within the current guess session
 * If no guess session is found then nothing happens
 */
$app->router->post("dice100", function () use ($app) {
    $game = new \Faxity\Dice100\Dice100();
    $guess = $app->session->set("dice100", $game);

    $url = $app->request->getCurrentUrl();
    $app->response->redirect("{$url}/round");
});

/**
 * Resets the session variables used in the guess my number game
 * Also recreates the guess variable in the session
 */
$app->router->post("dice100/round", function () use ($app) {
    $game = $app->session->get("dice100");
    $action = $app->request->getPost("action");

    if ($action == "toss") {
        $game->toss();
    } else if ($action == "end_turn") {
        $game->endTurn();
    }

    // Update session
    $app->session->set("dice100", $game);

    // Check for any winners
    if ($game->gameOver()) {
        $url = $app->request->getBaseUrl();
        return $app->response->redirect("$url/dice100/end");
    }

    $url = $app->request->getCurrentUrl();
    $app->response->redirect($url);
});

$app->router->post("dice100/end", function () use ($app) {
    $app->session->delete("dice100");

    $baseUrl = $app->request->getBaseUrl();
    $app->response->redirect("{$baseUrl}/dice100");
});
