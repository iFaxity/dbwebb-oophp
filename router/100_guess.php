<?php

/**
 * Renders the guess view within Anax, with required data.
 */
$app->router->get("guess", function () use ($app) {
    $guess = $app->session->get("guess");

    if (!isset($guess)) {
        $guess = new \Faxity\Guess\Guess();

        $app->session->set("guess", $guess);
    }

    // Add view and required data
    $app->page->add("guess/default", [
        "cheat" => $app->session->has("guess_cheat"),
        "result" => $app->session->get("guess_result"),
        "guesses" => $guess->guesses(),
        "number" => $guess->number(),
        "tries" => $guess->tries(),
        "lastGuess" => $guess->lastGuess(),
    ]);

    return $app->page->render([
        "title" => "Guess the number",
    ]);
});

/**
 * Makes a guess within the current guess session
 * If no guess session is found then nothing happens
 */
$app->router->post("guess", function () use ($app) {
    $guess = $app->session->get("guess");

    if (isset($guess)) {
        $guess_post = $app->request->getPost("guess", 0);
        $result = $guess->makeGuess($guess_post);

        $app->session->set("guess_result", $result);
        $app->session->set("guess", $guess);
    }

    $url = $app->request->getCurrentUrl();
    $app->response->redirect($url);
});

/**
 * Resets the session variables used in the guess my number game
 * Also recreates the guess variable in the session
 */
$app->router->post("guess/reset", function () use ($app) {
    $guess = new \Faxity\Guess\Guess();

    // Destroy session
    $app->session->delete("guess_cheat");
    $app->session->delete("guess_result");
    $app->session->delete("guess");
    $app->session->set("guess", $guess);

    $baseUrl = $app->request->getBaseUrl();
    $app->response->redirect($baseUrl . "/guess");
});

/**
 * Enables cheating to see the answer in the guess session
 */
$app->router->post("guess/cheat", function () use ($app) {
    $baseUrl = $app->request->getBaseUrl();

    $app->session->set("guess_cheat", "");
    $app->response->redirect($baseUrl . "/guess");
});
