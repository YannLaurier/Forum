<?php

class answer extends bdd
{
    private $content;
    private $author;
    private $post;

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

    public function setPost($post)
    {
        $this->post = $post;
    }

    public function getPost()
    {
        return $this->post;
    }
}