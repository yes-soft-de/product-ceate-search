<?php


namespace App\BusinessLogic;
use App\Entity\Painting;
use App\Entity\PaintingInterface;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\Request;

class CrudMysql implements CrudMysqLI
{
    private $painting;
    private $entityManager;
    private $id;

    public function __construct(PaintingInterface $paintingI, EntityManagerInterface $entityManagerInterface)
    {
        $this->painting = $paintingI;
        $this->entityManager = $entityManagerInterface;
    }

    public function getPainting()
    {
        return $this->painting;
    }

    public function getSetData(Request $request)
    {
        //Get data
        $name = $request->request->get("name");
        $image_url = $request->request->get("image_url");
        $description = $request->request->get("description");
        $size = $request->get("size");
        $medium = $request->request->get("medium");
        $category = $request->request->get("category");

        //Set data
        $this->painting->setName($name)
            ->setImageUrl(@$image_url)
            ->setDescription($description)
            ->setMedium($medium)
            ->setCategory($category)
            ->setSize($size);
    }

    public function create(Request $request)
    {
        $this->getSetData($request);

        $this->entityManager->persist($this->painting);
        $this->entityManager->flush();
    }

    public function update(Request $request)
    {
        $id = $request->request->get("id");
        $this->painting = $this->entityManager->getRepository(Painting::class)->find($id);

        $this->getSetData($request);

        $this->entityManager->flush();
    }

    public function delete(Request $request)
    {
        $id = $request->request->get("id");
        $this->id = $id;

        $this->painting = $this->entityManager->getRepository(Painting::class)->find($id);

        $this->entityManager->remove($this->painting);
        $this->entityManager->flush();
    }

    public function getId()
    {
        return $this->id;
    }
}