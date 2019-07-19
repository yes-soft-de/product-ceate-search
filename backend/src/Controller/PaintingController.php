<?php

namespace App\Controller;

use App\BusinessLogic\CrudMysqLI;
use App\BusinessLogic\SendToKafkaI;
use App\Events\KafkaEvent;
use App\Listeners\KafkaListenerI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PaintingController extends AbstractController
{
    private $result;
    private $crudMysql;
    private $sendToKafka;
    private $kafkaListener;
    private $status;
    private $eventDispatcher;

    public function __construct(CrudMysqLI $crudMysqli, SendToKafkaI $sendToKafka, KafkaListenerI $kafkaListenerI, EventDispatcherInterface $eventDispatcher)
    {
        $this->crudMysql = $crudMysqli;
        $this->sendToKafka = $sendToKafka;
        $this->kafkaListener = $kafkaListenerI;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @Route("/createPainting", name="createPainting", methods={"post"})
     * @return Response
     * @param Request $request
     */
    public function create(Request $request)
    {

        // Save to Mysql
        $this->crudMysql->create($request);

        // Prepare json
        $result = $this->container->get('serializer')->serialize($this->crudMysql->getPainting(), 'json');
        $this->result = $result;

        //Send event to kafka
        $this->status = "New";
        $this->sendEventToKafka();

        $resultResponse = new Response($result, Response::HTTP_OK, ['content-type' => 'application/json']);
        $resultResponse->headers->set('Access-Control-Allow-Origin', '*');
        $resultResponse->setStatusCode(Response::HTTP_OK);

        //Return
        return new $resultResponse;
    }

    /**
     * @Route("/updatePainting", name="updatePainting", methods={"put"})
     * @return Response
     * @param Request $request
     */
    public function update(Request $request)
    {
        //Save to Mysql
        $this->crudMysql->create($request);
        //Prepare json
        $result = $this->container->get('serializer')->serialize($this->crudMysql->getPainting(), 'json');
        $this->result = $result;
        //Send event to kafka
        $this->status = "New";
        $this->sendEventToKafka();
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

        //Prepare json
        $result = json_encode($this->crudMysql->getPainting());
        // $result = $this->container->get('serializer')->serialize($this->crudMysql->getPainting(), 'json');
        $this->result = $result;

        //Send event to kafka
        $this->status = "Deleted";
        $this->sendEventToKafka();

        //Return
        return new Response('Deleting painting id: '.$request->request->get("id").' Success',
            Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    public function sendEventToKafka()
    {
        $this->eventDispatcher->addListener('kafka.event', array($this->kafkaListener, 'onKafkaEvent'));
        $this->kafkaListener->setStatus($this->status);
        $this->eventDispatcher->dispatch(KafkaEvent::NAME);
    }
}
