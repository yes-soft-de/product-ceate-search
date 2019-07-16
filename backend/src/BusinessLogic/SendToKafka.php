<?php


namespace App\BusinessLogic;


use Kafka\Producer;
use Kafka\ProducerConfig;
use Symfony\Component\Serializer\SerializerInterface;

class SendToKafka implements SendToKafkaI
{
    private $crudMysql;
    private $status;
    private $serializer;

    public function __construct(CrudMysqLI $crudMysqli,  SerializerInterface $serializer)
    {
        $this->crudMysql = $crudMysqli;
        $this->serializer = $serializer;
    }

    public function sendToKafka($status)
    {
        $this->status = $status;

        $config = ProducerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList('127.0.0.1:9092');
        $config->setBrokerVersion('1.0.0');
        $config->setRequiredAck(1);
        $config->setIsAsyn(false);
        $config->setProduceInterval(500);

        $producer = new Producer(function () {

            //Add status
            $json = $this->serializer->serialize($this->crudMysql->getPainting(), 'json');
            $arr = json_decode($json, TRUE, 512, JSON_UNESCAPED_UNICODE);
            $arr["status"] = $this->status;

            if ($arr["status"] == "Deleted")
            {
                $arr["id"] = (int)$this->crudMysql->getId();
            }

            $json = $this->serializer->serialize($arr, 'json');

            return [
                [  'topic' => 'yes',
                    'value' =>$json,
                    'key' => '',
                ],
            ];
        });

        $producer->send(true);
    }
}