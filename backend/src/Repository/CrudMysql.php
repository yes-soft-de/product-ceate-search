<?php


namespace App\Repository;
use App\Entity\Painting;
use App\Mapper\PaintingMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CrudMysql implements CrudInterface
{
    private $painting;
    private $entityManager;
    private $id;
    private $paintingMapper;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManager = $entityManagerInterface;
        $this->paintingMapper = new PaintingMapper();
    }

    public function getPainting()
    {
        return $this->painting;
    }

    public function getSetData(Request $request)
    {
        // Allocate JSON Object
        $data = json_decode($request->getContent(), true);
        $this->painting = $this->paintingMapper->JsonToPainting($data);
    }

    public function create(Request $request)
    {
        $this->getSetData($request);

        $this->entityManager->persist($this->painting);
        $this->entityManager->flush();
    }

    public function update(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $id = $data["id"];
        $this->painting = $this->entityManager->getRepository(Painting::class)->find($id);

        $this->getSetData($request);

        $this->entityManager->flush();
    }

    public function delete(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $id = $data["id"];

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