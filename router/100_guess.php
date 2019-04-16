<?php

/**
 * Showing message Hello World, rendered within the standard page layout.
 */
$app->router->get("guess", function () use ($app) {
    $app->page->add("guess/default");

    return $app->page->render([
        "title" => "Guess the number",
    ]);
});

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

$app->router->post("guess/cheat", function () use ($app) {
    $baseUrl = $app->request->getBaseUrl();

    $session->set("guess_cheat", "");
    $app->response->redirect($baseUrl . "/guess");
});

/*


    // Reset session (if we need)
    if ($action == "reset") {
        $session->destroy();
        $guess = new \Faxity\Guess\Guess();
    } else {
        // Enable cheats or make guess
        $guess = $session->get("guess") ?? new \Faxity\Guess\Guess();

        if ($action == "cheat") {
            $cheat = $session->set("cheat", true);
        } else if ($action == "guess") {
            $result = $guess->makeGuess($req->getPost("guess", 0));
            $session->set("result", $result);
        }
    }

    // Save guess object and redirect
    $session->set("guess", $guess);
    $app->response->redirect($req->getCurrentUrl());
*/
