<?php

namespace App\Controller;

use App\BusinessLogic\CrudMysqLI;
use App\BusinessLogic\SendToKafkaI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaintingController extends AbstractController
{
    private $result;
    private $crudMysql;
    private $sendToKafka;

    public function __construct(CrudMysqLI $crudMysqli, SendToKafkaI $sendToKafka)
    {
        $this->crudMysql = $crudMysqli;
        $this->sendToKafka = $sendToKafka;
    }

    /**
     * @Route("/createPainting", name="createPainting", methods={"post"})
     * @return Response
     * @param Request $request
     */
    public function create(Request $request)
    {
        //Save to Mysql
        $this->crudMysql->create($request);

        //Prepare json
        $result = $this->container->get('serializer')->serialize($this->crudMysql->getPainting(), 'json');
        $this->result = $result;

        //Send to kafka
        $this->sendToKafka->sendToKafka("New");

        //Return
        return new Response($result, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/updatePainting", name="updatePainting", methods={"put"})
     * @return Response
     * @param Request $request
     */
    public function update(Request $request)
    {
        //update in Mysql
        $this->crudMysql->update($request);

        //Exception
        $this->notFoundException($request->request->get("id"));

        //Prepare json
        $result = $this->container->get('serializer')->serialize($this->crudMysql->getPainting(), 'json');
        $this->result = $result;

        //Send to kafka
        $this->sendToKafka->sendToKafka("Update");

        //Return
        return new Response($result, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/deletePainting", name="deletePainting", methods={"delete"})
     * @return Response
     * @param Request $request
     */
    public function delete(Request $request)
    {
        //delete from Mysql
        $this->crudMysql->delete($request);

        //Exception
        $this->notFoundException($request->request->get("id"));

        //Prepare json
        $result = $this->container->get('serializer')->serialize($this->crudMysql->getPainting(), 'json');
        $this->result = $result;

        //Send to kafka
        $this->sendToKafka->sendToKafka("Delete");

        //Return
        return new Response('Deleting painting id: '.$request->request->get("id").' Success',
            Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    public function notFoundException($id)
    {
        if(!$this->crudMysql->getPainting())
        {
            throw $this->createNotFoundException(
                'No painting found for id '.$id
            );
        }
    }
}
