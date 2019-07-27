<?php


namespace App\Manager;

use App\Entity\ExtraDataInterface;
use App\Repository\CrudInterface;
use Kafka\Producer;
use Kafka\ProducerConfig;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Yaml\Yaml;

class SendToKafka implements SendToKafkaInterface
{
    private $crudMysql;
    private $serializer;

    public function __construct(CrudInterface $crudMysqli, SerializerInterface $serializer)
    {
        $this->crudMysql = $crudMysqli;
        $this->serializer = $serializer;
    }

    public function sendToKafka($status, $topicName)
    {
        $this->KafkaConfig();

        $producer = new Producer(function () use ($status, $topicName) {

            return $this->prepareData($status, $topicName);
        });

        $producer->send(true);
    }

    public function prepareData($topicName, $status)
    {
        //Add status
        $data = $this->serializer->serialize($this->crudMysql->getPainting(), 'json');
        $arr = json_decode($data, TRUE, 512, JSON_UNESCAPED_UNICODE);
        $arr["status"] = $status;

        //Add id
        if ($arr["status"] == "Deleted") {
            $arr["id"] = (int)$this->crudMysql->getId();
        }

        $readyData = json_encode($arr);

        return [
            ['topic' => $topicName,
                'value' => $readyData,
                'key' => '',
            ],
        ];
    }

    public function KafkaConfig()
    {

        $yamlConfig = Yaml::parseFile('../config/kafka.yaml');

        $config = ProducerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs($yamlConfig['kafka']['MetadataRefreshIntervalMs']);
        $config->setMetadataBrokerList($yamlConfig['kafka']['MetadataBrokerList']);
        $config->setBrokerVersion($yamlConfig['kafka']['BrokerVersion']);
        $config->setRequiredAck($yamlConfig['kafka']['RequiredAck']);
        $config->setIsAsyn($yamlConfig['kafka']['IsAsync']);
        $config->setProduceInterval($yamlConfig['kafka']['ProduceInterval']);
    }
}