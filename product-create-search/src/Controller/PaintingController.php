<?php

namespace App\Controller;

use App\Entity\Painting;
use App\Entity\PaintingInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaintingController extends AbstractController
{
    private  $painting;
    private $entityManager;

    public function __construct(PaintingInterface $paintingI, EntityManagerInterface $entityManagerInterface)
    {
        $this->painting = $paintingI;
        $this->entityManager = $entityManagerInterface;
    }

    /**
     * @Route("/createPainting", name="createPainting")
     */
    public function create(Request $request)
    {
        $name = $request->request->get("name");
        $image_url = $request->request->get("image_url");
        $description = $request->request->get("description");
        $size = $request->get("size");
        $medium = $request->request->get("medium");
        $category = $request->request->get("category");

        $this->painting->setName($name)
                       ->setImageUrl(@$image_url)
                       ->setDescription($description)
                       ->setMedium($medium)
                       ->setCategory($category)
                       ->setSize($size);

        $this->entityManager->persist($this->painting);
        $this->entityManager->flush();

        //return
        //$repository = $this->entityManager->getRepository(Painting::class);
        //$returnPainting = $repository->findAll();
        //
        $result = $this->container->get('serializer')->serialize($this->painting, 'json');

        return new Response($result, Response::HTTP_OK, ['content-type' => 'application/json']);

    }

    /**
     * @Route("/updatePainting", name="updatePainting")
     */
    public function update(Request $request)
    {
        $id = $request->request->get("id");

        $this->painting = $this->entityManager->getRepository(Painting::class)->find($id);

        if(!$this->painting)
        {
            throw $this->createNotFoundException(
                'No painting found for id '.$id
            );
        }

        $name = $request->request->get("name");
        $image_url = $request->request->get("image_url");
        $description = $request->request->get("description");
        $size = $request->get("size");
        $medium = $request->request->get("medium");
        $category = $request->request->get("category");

        $this->painting->setName($name)
            ->setImageUrl(@$image_url)
            ->setDescription($description)
            ->setMedium($medium)
            ->setCategory($category)
            ->setSize($size);

        $this->entityManager->flush();

        $result = $this->container->get('serializer')->serialize($this->painting, 'json');

        return new Response($result, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/deletePainting", name="deletePainting", methods={"delete"})
     */
    public function delete(Request $request)
    {
        $id = $request->request->get("id");

        $this->painting = $this->entityManager->getRepository(Painting::class)->find($id);

        if(!$this->painting)
        {
            throw $this->createNotFoundException(
                'No painting found for id '.$id
            );
        }

        $this->entityManager->remove($this->painting);
        $this->entityManager->flush();

        return new Response('Deleting painting id: '.$id.' Success', Response::HTTP_OK, ['content-type' => 'application/json']);
    }
}
