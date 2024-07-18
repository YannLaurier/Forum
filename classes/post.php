<?php

class post extends bdd
{
    private $title;
    private $content;
    private $author;
    private $subcat;

    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setSubCat($subcat)
    {
        $this->subcat = $subcat;
    }

    public function getSubCat()
    {
        return $this->subcat;
    }
}