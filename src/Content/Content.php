<?php

namespace Faxity\Content;

/**
 * Class for content CMS database management
 */
class Content
{
    const FIELDS = [
        "path",
        "slug",
        "title",
        "data",
        "type",
        "filter",
        "published",
    ];

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Converts an iteratable into a INSERT INTO field set
     * @param mixed $data Iteratable data
     * @return array [ sql string, pdo params ]
     */
    private function extractParams($data) : array
    {
        $fields = [];
        $params = [];

        foreach ($data as $key => $value) {
            $value = trim($value);

            if (!empty($value) && in_array($key, self::FIELDS)) {
                $fields[] = "$key = ?";
                $params[] = $value;
            }
        }

        $fields = implode(", ", $fields);
        return [ $fields, $params ];
    }

    /**
     * Lists all the content in the database
     * @param bool $all - deleted content should show, optional
     * @return ContentObject[].
     */
    public function list(bool $all = false) : array
    {
        $sql = "SELECT * FROM content";

        if ($all != true) {
            $sql .= " WHERE deleted IS NULL";
        }

        $this->db->connect();
        $this->db->execute($sql);
        return $this->db->fetchAllClass("\Faxity\Content\ContentObject");
    }

    /**
     * Reads a content page/post from the database
     * @param int $id content id
     * @return ContentObject|null.
     */
    public function read(int $id) : ?object
    {
        $sql = "SELECT * FROM content WHERE id = ?";

        $this->db->connect();
        $this->db->execute($sql, [ $id ]);
        return $this->db->fetchClass("\Faxity\Content\ContentObject");
    }

    /**
     * Creates a new content entry in the database
     * @param object $data Content data
     * @return int id of the created entry
     */
    public function create(object $data) : int
    {
        [ $fields, $params ] = $this->extractParams($data);
        $sql = "INSERT INTO content SET {$fields}";

        $this->db->connect();
        $this->db->execute($sql, $params);
        return $this->db->lastInsertId();
    }

    /**
     * Updates a content entry in the database
     * @param int $id Content id
     * @param object $data Data to update
     * @return void.
     */
    public function update(int $id, object $data) : void
    {
        [ $fields, $params ] = $this->extractParams($data);
        $sql = "UPDATE content SET {$fields} WHERE id = ? AND deleted IS NULL";
        $params[] = $id;

        $this->db->connect();
        $this->db->execute($sql, $params);
    }

    /**
     * Deletes a content entry from the database
     * @param int $id Content id
     * @return void.
     */
    public function delete(int $id) : void
    {
        $sql = "UPDATE content SET deleted = NOW() WHERE id = ? AND deleted IS NULL";

        $this->db->connect();
        $this->db->execute($sql, [ $id ]);
    }

    /**
     * Lists all the blog posts in the database
     * @return ContentObject[].
     */
    public function listPosts() : array
    {
        $sql = "
        SELECT *
        FROM content
        WHERE
            type = ?
            AND (deleted IS NULL OR deleted > NOW())
            AND published <= NOW()
        ORDER BY published DESC
        ";

        $this->db->connect();
        $this->db->execute($sql, [ "post" ]);
        return $this->db->fetchAllClass("\Faxity\Content\ContentObject");
    }

    /**
     * Reads a blog post from the database
     * @param string $slug Post slug
     * @return ContentObject|null.
     */
    public function readPost(string $slug) : ?object
    {
        $sql = "
        SELECT *
        FROM content
        WHERE
            slug = ?
            AND type = ?
            AND (deleted IS NULL OR deleted > NOW())
            AND published <= NOW()
        ";

        $this->db->connect();
        $this->db->execute($sql, [ $slug, "post" ]);
        return $this->db->fetchClass("\Faxity\Content\ContentObject");
    }

    /**
     * Reads a page from the database
     * @param string $path Page path
     * @return object|null.
     */
    public function readPage(string $path) : ?object
    {
        $sql = "
        SELECT *
        FROM content
        WHERE
            path = ?
            AND type = ?
            AND (deleted IS NULL OR deleted > NOW())
            AND published <= NOW()
        ";

        $this->db->connect();
        $this->db->execute($sql, [ $path, "page" ]);
        return $this->db->fetchClass("\Faxity\Content\ContentObject");
    }
}
