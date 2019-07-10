<?php

namespace App\Controller;

use App\Entity\Painting;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaintingController extends AbstractController
{
    /**
     * @Route("/createPainting", name="painting")
     */
    public function create(ObjectManager $opjectManager, Request $request)
    {
        $painting = new Painting();

        $name = $request->request->get("name");
        $image_url = $request->request->get("image_url");
        $description = $request->request->get("description");
        $size = $request->request->get("size");
        $medium = $request->request->get("medium");
        $category = $request->request->get("category");

        $painting->setName($name);
        $painting->setImageUrl(@$image_url);
        $painting->setDescription($description);
        $painting->setMedium($medium);
        $painting->setCategory($category);
        $painting->setSize($size);

        $opjectManager->persist($painting);
        $opjectManager->flush();

        //return
        return $this->json([
            'id' => $painting->getId(),
            'name' => $painting->getName(),
            'image_url' => $painting->getImageUrl(),
            'description' => $painting->getDescription(),
            'size' => $painting->getSize(),
            'medium' => $painting->getMedium(),
            'category' => $painting->getCategory()
        ],
            200
        );

    }
}
