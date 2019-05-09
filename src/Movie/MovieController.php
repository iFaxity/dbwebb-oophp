<?php

namespace Faxity\Movie;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

/**
 * Route controller for the dice game 100 in Anax
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * Gets an array of all the movies within the database
     * @return array.
     */
    private function listMovies($query = null) : array
    {
        $this->app->db->connect();

        if (!isset($query)) {
            return $this->app->db->executeFetchAll('SELECT * FROM movies');
        }

        $query = "%{$query}%";
        $sql = 'SELECT * FROM movies WHERE title LIKE ? OR year LIKE ?';

        return $this->app->db->executeFetchAll($sql, [ $query, $query ]);
    }

    /**
     * Reads a specific movie from teh database
     * @return object.
     */
    private function readMovie($id) : object
    {
        $this->app->db->connect();

        $sql = 'SELECT * FROM movies WHERE id = ?';
        return $this->app->db->executeFetch($sql, [ $id ]);
    }

    /**
     * Adds a movie to the database
     * @return void.
     */
    private function createMovie($data) : void
    {
        $this->app->db->connect();
        $this->app->db->execute('INSERT INTO movies SET title = ?, year = ?, `image` = ?', [
            $data["title"],
            $data["year"],
            $data["image"],
        ]);
    }

    /**
     * Deletes a movie from the database
     * @return void.
     */
    private function deleteMovie($id) : void
    {
        $this->app->db->connect();
        $this->app->db->execute('DELETE FROM movies WHERE id = ?', [ $id ]);
    }

    /**
     * Updates a specific movie
     * @return void.
     */
    private function updateMovie($id, $data) : void
    {
        $this->app->db->connect();
        $this->app->db->execute('UPDATE movies SET title = ?, year = ?, `image` = ? WHERE id = ?', [
            $data["title"],
            $data["year"],
            $data["image"],
            $id,
        ]);
    }



    /**
     * Route for GET /movie
     * @return object.
     */
    public function indexActionGet() : object
    {
        $query = $this->app->request->getGet('q', '');
        $movies = $this->listMovies($query);

        $this->app->page->add("movie/index", [
            "movies" => $movies,
            "query" => $query,
        ]);

        return $this->app->page->render([
            "title" => "Filmlista",
        ]);
    }

    /**
     * Route for GET /movie/create
     * @return object.
     */
    public function createActionGet() : object
    {
        $this->app->page->add("movie/create");

        return $this->app->page->render([
            "title" => "Lägg till film",
        ]);
    }

    /**
     * Route for GET /movie/update
     * @return object.
     */
    public function updateActionGet($id) : object
    {
        $movie = $this->readMovie($id);

        $this->app->page->add("movie/update", [
            "movie" => $movie,
        ]);

        return $this->app->page->render([
            "title" => "Uppdatera film",
        ]);
    }

    /**
     * Route for GET /movie/delete
     * @return object.
     */
    public function deleteActionGet($id) : object
    {
        $movie = $this->readMovie($id);

        $this->app->page->add("movie/delete", [
            "movie" => $movie,
        ]);

        return $this->app->page->render([
            "title" => "Ta bort film",
        ]);
    }



    /**
     * Route for POST /movie/create
     * @return object.
     */
    public function createActionPost() : object
    {
        $data = [
            "title" => $this->app->request->getPost("title"),
            "year"  => $this->app->request->getPost("year"),
            "image" => $this->app->request->getPost("image"),
        ];

        $this->createMovie($data);

        $url = $this->app->request->getBaseUrl();
        return $this->app->response->redirect("$url/movie");
    }

    /**
     * Route for POST /movie/update
     * @return object.
     */
    public function updateActionPost($id) : object
    {
        $app = $this->app;

        $data = [
            "title" => $app->request->getPost("title"),
            "year" => $app->request->getPost("year"),
            "image" => $app->request->getPost("image"),
        ];

        $this->updateMovie($id, $data);

        $url = $app->request->getBaseUrl();
        return $app->response->redirect("$url/movie");
    }

    /**
     * Route for POST /movie/delete
     * @return object.
     */
    public function deleteActionPost($id) : object
    {
        $this->deleteMovie($id);

        $url = $this->app->request->getBaseUrl();
        return $this->app->response->redirect("$url/movie");
    }
}
