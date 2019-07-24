<?php


namespace App\Service;

use App\Entity\ExtraDataInterface;
use App\Repository\CrudInterface;
use Kafka\Producer;
use Kafka\ProducerConfig;
use Symfony\Component\Serializer\SerializerInterface;

class SendToKafka implements SendToKafkaInterface
{
    private $crudMysql;
    private $serializer;
    private $extraData;

    public function __construct(CrudInterface $crudMysqli, SerializerInterface $serializer, ExtraDataInterface $extraData)
    {
        $this->crudMysql = $crudMysqli;
        $this->serializer = $serializer;
        $this->extraData = $extraData;
    }

    public function sendToKafka()
    {
        $this->KafkaConfig();

        $producer = new Producer(function () {

            return $this->prepareData();
        });

        $producer->send(true);
    }

    public function prepareData()
    {
        //Add status
        $data = $this->serializer->serialize($this->crudMysql->getPainting(), 'json');
        $arr = json_decode($data, TRUE, 512, JSON_UNESCAPED_UNICODE);
        $arr["status"] = $this->extraData->getStatus();

        //Add id
        if ($arr["status"] == "Deleted")
        {
            $arr["id"] = (int)$this->crudMysql->getId();
        }

        $readyData = json_encode($arr);

        return $this->producerReturn($readyData);
    }

    public function producerReturn($readyData)
    {
        return [
            [   'topic' => $this->extraData->getTopicName(),
                'value' =>$readyData,
                'key' => '',
            ],
        ];
    }

    public function KafkaConfig()
    {
        $config = ProducerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList('127.0.0.1:9092');
        $config->setBrokerVersion('1.0.0');
        $config->setRequiredAck(1);
        $config->setIsAsyn(false);
        $config->setProduceInterval(500);
    }
}