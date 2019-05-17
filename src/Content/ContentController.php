<?php

namespace Faxity\Content;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

/**
 * Route for GET /movie
 * @return object.
 */
/*public function indexActionGet() : object
{
    $query = $this->app->request->getGet('q', '');

    $this->app->page->add("", []);

    return $this->app->page->render([
        "title" => "Filmlista",
    ]);
}*/
/**
 * Route for POST /movie
 * @return object.
 */


/**
 * Route controller for a content CMS in Anax
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ContentController implements AppInjectableInterface
{
    use AppInjectableTrait;


    /**
     * Private methods
     */


    /**
     * Reads post variables from string into an associative array
     * Skipping empty values
     *
     * @return array object with the values (if any)
     */
    private function post(array $keys) : object
    {
        $data = (object) [];

        foreach ($keys as $key) {
            $value = $this->app->request->getPost($key);

            if (!empty($value)) {
                $data->{$key} = $value;
            }
        }

        return $data;
    }

    /**
     * Gets or sets a message to show in the next render
     * With no parameters set it will get the message
     * @param string $type Message type, info, ok, warning or error
     * @param string $title Message title
     * @param string $message Message
     * @return object or null
     */
    private function flash(string $type = null, string $title = null, string $message = null) : ?object
    {
        // Get flash
        if (!isset($type)) {
            $data = $this->app->session->get("content-flash");
            $this->app->session->delete("content-flash");
    
            return $data;
        }

        // Set flash
        $data = (object) [
            "type" => $type,
            "title" => $title,
            "message" => $message,
        ];

        $this->app->session->set("content-flash", $data);
        return null;
    }


    /**
     * GET Routes
     */

    /**
     * Runs before resolving a route
     */
    public function initialize()
    {
        $this->content = new Content($this->app->db);
    }


    /**
     * Route for GET /index
     * @return object.
     */
    public function indexActionGet()
    {
        $list = $this->content->list();

        $this->app->page->add("content/index", [
            "list" => $list,
            "flash" => $this->flash(),
        ]);

        return $this->app->page->render([
            "title" => "Content CMS",
        ]);
    }

    /**
     * Route for GET /admin
     * @return object.
     */
    public function adminActionGet()
    {
        $list = $this->content->list(true);

        $this->app->page->add("content/index", [
            "list" => $list,
            "admin" => true,
            "flash" => $this->flash(),
        ]);

        return $this->app->page->render([
            "title" => "Admin panel",
        ]);
    }

    /**
     * Route for GET /create
     * @return object.
     */
    public function createActionGet()
    {
        $this->app->page->add("content/create", [
            "flash" => $this->flash(),
        ]);

        return $this->app->page->render([
            "title" => "Skapa inlägg",
        ]);
    }

    /**
     * Route for GET /edit/:id
     * @return object.
     */
    public function editActionGet($id)
    {
        $content = $this->content->read($id);
        
        // Trigger anax 404
        if ($content != null) {
            $this->app->page->add("content/edit", [
                "content" => $content,
                "flash" => $this->flash(),
            ]);

            return $this->app->page->render([
                "title" => "Redigera inlägg",
            ]);
        }
    }

    /**
     * Route for GET /delete/:id
     * @return object.
     */
    public function deleteActionGet($id)
    {
        $content = $this->content->read($id);

        // Trigger anax 404
        if ($content != null) {
            $this->app->page->add("content/delete", [
                "content" => $content,
                "flash" => $this->flash(),
            ]);

            return $this->app->page->render([
                "title" => "Radera inlägg",
            ]);
        }
    }

    /**
     * Route for GET /page/:page
     * @return object.
     */
    public function pageActionGet($path)
    {
        $page = $this->content->readPage($path);

        // Trigger anax 404
        if ($page != null) {
            $this->app->page->add("content/page", [
                "page" => $page,
                "flash" => $this->flash(),
            ]);

            return $this->app->page->render([
                "title" => $page->title,
            ]);
        }
    }

    /**
     * Route for GET /blog/:slug
     * @return object.
     */
    public function blogActionGet($slug = null)
    {
        $data = [
            "flash" => $this->flash(),
        ];

        if ($slug == null) {
            $posts = $this->content->listPosts("post");
            $title = "Blogginlägg";
            $view = "content/posts";
            $data["posts"] = $posts;
        } else {
            $post = $this->content->readPost($slug);

            // Trigger anax 404
            if ($post == null) {
                return;
            }

            $title = $post->title;
            $view = "content/post";
            $data["post"] = $post;
        }

        // Render the page
        $this->app->page->add($view, $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * POST Routes
     */

    /**
     * Route for POST /create
     * @return object.
     */
    public function createActionPost()
    {
        // Get post values
        $data = $this->post(Content::FIELDS);
        $obj = new ContentObject($data);
        $url = "/admin";

        try {
            $this->content->create($obj);
            $this->flash(
                "ok",
                "Inlägget skapades!",
                "Inlägget skapades utan problem."
            );
        } catch (\Anax\Database\Exception\Exception $ex) {
            $url = "/create";
            $this->flash(
                "error",
                "Inlägget skapades inte!",
                "Kontrollera så sökvägen och slug är unika."
            );
        }

        $url = $this->app->request->getBaseUrl() . "/content" . $url;
        return $this->app->response->redirect($url);
    }

    /**
     * Route for POST /edit/:id
     * @return object.
     */
    public function editActionPost($id)
    {
        $data = $this->post(Content::FIELDS);

        try {
            $this->content->update($id, $data);
            $this->flash(
                "ok",
                "Inlägget uppdaterades!",
                "Inlägget uppdaterades utan problem."
            );
        } catch (\Anax\Database\Exception\Exception $ex) {
            $this->flash(
                "error",
                "Inlägget uppdaterades inte!",
                "Kontrollera så sökvägen och slug är unika."
            );
        }

        $url = $this->app->request->getCurrentUrl();
        return $this->app->response->redirect($url);
    }

    /**
     * Route for POST /delete/:id
     * @return object.
     */
    public function deleteActionPost($id)
    {
        try {
            $this->content->delete($id);
            $this->flash(
                "ok",
                "Inlägget raderades!",
                "Inlägget raderades utan problem."
            );
        } catch (\Anax\Database\Exception\Exception $ex) {
            $this->flash(
                "error",
                "Inlägget raderades inte!",
                "Inlägget kunde inte raderas, kontrollera så inlägget finns och inte är raderad."
            );
        }

        $url = $this->app->request->getBaseUrl() . "/content/admin";
        return $this->app->response->redirect($url);
    }
}
