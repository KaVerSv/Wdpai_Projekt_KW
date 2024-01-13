<?php

namespace models;

class Book
{
    private $id;
    private $title;
    private $author;
    private $publish_date;
    private $description;
    private $price;
    private $image;

    public function __construct($id,$title, $author, $publish_date, $description, $price, $image)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->publish_date = $publish_date;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
    }


    public function getImage()
    {
        return $this->image;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getPublishDate()
    {
        return $this->publish_date;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->price;
    }


}