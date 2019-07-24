<?php

namespace App\Controller;

use App\Repository\CrudInterface;
use App\Event\KafkaEvent;
use App\Event\KafkaEventInterface;
use App\Service\ValidateInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PaintingController extends AbstractController
{
    private $crudMysql;
    private $eventDispatcher;
    private $kafkaEvent;
    private $validate;
    //private $paintingMapper;

    public function __construct(CrudInterface $crudMysqli, EventDispatcherInterface $eventDispatcher, KafkaEventInterface $kafkaEvent, ValidateInterface $validate)
    {
        $this->crudMysql = $crudMysqli;
        $this->eventDispatcher = $eventDispatcher;
        $this->kafkaEvent = $kafkaEvent;
        $this->validate = $validate;
        //$this->paintingMapper = new PaintingMapper();
    }

    /**
     * @Route("/createPainting", name="createPainting", methods={"post"})
     * @return Response
     * @param Request $request
     */
    public function create(Request $request)
    {
        // Mapping Request to Painting
        // $painting = $this->paintingMapper->JsonToPainting($request->getContent());
        // TODO: Call the Request Validator if OK then continue
        // TODO: Create Manager to Handle this work if Validation was OK
        // This Should be in a separate Service

        // Save to Mysql
        $this->crudMysql->create($request);

        //Event (Kafka)
        //$this->dispatch("yes", "New");

        //Return
        $result = "Create panting, success.";
        $resultResponse = new Response($result, Response::HTTP_OK, ['content-type' => 'text/plain']);
        $resultResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $resultResponse;
    }

    /**
     * @Route("/updatePainting", name="updatePainting", methods={"put"})
     * @return Response
     * @param Request $request
     */
    public function update(Request $request)
    {
        $validateResult = $this->validate->pantingValidator($request);

        if (!empty($validateResult))
        {
            $resultResponse = new Response($validateResult, Response::HTTP_OK, ['content-type' => 'application/json']);
            $resultResponse->headers->set('Access-Control-Allow-Origin', '*');
            return $resultResponse;
        }

        //Save to Mysql
        $this->crudMysql->update($request);

        //Event (Kafka)
        //$this->dispatch("yes", "Updated");

        //Return
        $result = "Update panting, success.";
        $resultResponse = new Response($result, Response::HTTP_OK, ['content-type' => 'application/json']);
        $resultResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $resultResponse;
    }

    /**
     * @Route("/deletePainting", name="deletePainting", methods={"delete"})
     * @return Response
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $validateResult = $this->validate->pantingValidator($request);

        if (!empty($validateResult))
        {
            $resultResponse = new Response($validateResult, Response::HTTP_OK, ['content-type' => 'application/json']);
            $resultResponse->headers->set('Access-Control-Allow-Origin', '*');
            return $resultResponse;
        }

        //delete from Mysql
        $this->crudMysql->delete($request);

        //Event (Kafka)
        //$this->dispatch("yes", "Deleted");

        //Return
        $data = json_decode($request->getContent(), true);
        $id = $data["id"];
        $resultResponse = new Response('Deleting painting id: '.$id.' Success',
            Response::HTTP_OK, ['content-type' => 'application/json']);
        $resultResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $resultResponse;
    }

    public function dispatch($topicName, $status)
    {
        $this->kafkaEvent->setTopicName($topicName);
        $this->kafkaEvent->setStatus($status);
        $this->eventDispatcher->dispatch(KafkaEvent::NAME);
    }
}
