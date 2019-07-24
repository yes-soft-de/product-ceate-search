<?php
/**
 * Created by PhpStorm.
 * User: TEC-GATE
 * Date: 7/23/2019
 * Time: 9:56 PM
 */

namespace App\Mapper;


use App\Entity\Painting;

class PaintingMapper
{
    private $painting;

    public function __construct()
    {
        $this->painting = new Painting();
    }

    public function JsonToPainting($data){
        //Get data
        $name = $data["name"];
        $image_url = $data["image_url"];
        $description = $data["description"];
        $size = $data["size"];
        $medium = $data["medium"];
        $category = $data["category"];

        $this->painting = new Painting();

        $this->painting->setName($name)
            ->setImageUrl(@$image_url)
            ->setDescription($description)
            ->setMedium($medium)
            ->setCategory($category)
            ->setSize($size);

        return $this->painting;
    }
}