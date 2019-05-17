<?php

namespace Faxity\Content;

/**
 * Class for holding content objects
 */
class ContentObject
{
    /**
     * @var $id Content database id
     * @var $path Content path
     * @var $slug Blog post slug, only for blog posts of course
     * @var $title Content title
     * @var $data Content text, unfiltered
     * @var $type Content type, page or post
     * @var $filter Filters to run on the data when showing the content
     * @var $published The date the content is published on, wont be shown until then
     * @var $created The date the content was created
     * @var $updated The date when the content was last updated
     * @var $deleted The date when the content was deleted
     */
    public $id;
    public $path;
    public $slug;
    public $title;
    public $data;
    public $type;
    public $filter;
    public $published;
    public $created;
    public $updated;
    public $deleted;

    public function __construct(object $fields = null)
    {
        if (isset($fields)) {
            foreach ($fields as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }

        if ($this->type == "post" && !$this->slug) {
            $this->slug = $this->slugify($this->title);
        }
    }

    /**
     * Create a slug of a string, to be used as url.
     * @param string $str the string to format as slug.
     * @return string the formatted slug.
     */
    private function slugify(string $str) : string
    {
        $str = mb_strtolower(trim($str));
        $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }

    /**
     * Transforms the data in the content using the filters provided
     * @return string transformed data as string.
     */
    public function filterData() : string
    {
        $filter = new \Faxity\TextFilterer\TextFilter();
        $filters = explode(",", $this->filter);

        return $filter->parse($this->data, $filters);
    }

    /**
     * Gets the latest date the content was modified
     * @param bool $iso - if the string should output as ISO date time string, optional.
     * @return string formatted date.
     */
    public function modified($iso = false) : string
    {
        if ($this->updated) {
            $updated = new \DateTime($this->updated);
            $published = new \DateTime($this->published);

            $date = $updated > $published ? $updated : $published;
        } else {
            $date = new \DateTime($this->published);
        }

        if ($iso) {
            return $date->format(\DateTime::ISO8601);
        }

        return $date->format("Y-m-d");
    }
}
