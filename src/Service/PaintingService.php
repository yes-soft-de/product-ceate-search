<?php
/**
 * Created by PhpStorm.
 * User: TEC-GATE
 * Date: 7/25/2019
 * Time: 12:11 PM
 */

namespace App\Service;

use App\Enum\RequestType;
use App\Manager\ElasticSearchQueryManager;
use App\Validator\ValidateInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Repository\CrudInterface;
use App\Event\KafkaEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PaintingService
{
    private $crudMysql;
    private $validate;
    private $eventDispatcher;

    public function __construct(CrudInterface $crudMysqli, EventDispatcherInterface $eventDispatcher, ValidateInterface $validate)
    {
        // TODO: This Needs to Be Fixed BUT It's OK for now!
        $this->crudMysql = $crudMysqli;
        $this->eventDispatcher = $eventDispatcher;
        $this->validate = $validate;
    }

    public function createPainting(Request $request)
    {
        // 1. Validate Request Using the Validator
        $validateResult = $this->validateRequest($request, RequestType::$REQUEST_CREATE);
        if ($validateResult != null) {
            return [
                "status_code" => Response::HTTP_BAD_REQUEST,
                "msg" => $validateResult
            ];
        }

        $this->crudMysql->create($request);
        $this->dispatch("yes", "New");

        return [
            "status_code" => Response::HTTP_OK,
            "msg" => "Painting Created Successfully."
        ];
    }

    public function updatePainting(Request $request)
    {
        $validateResult = $this->validateRequest($request, RequestType::$REQUEST_UPDATE);
        if ($validateResult != null) {
            return [
                "status_code" => Response::HTTP_BAD_REQUEST,
                "msg" => $validateResult
            ];
        }

        $this->crudMysql->update($request);
        $this->dispatch("yes", "Updated");

        return [
            "status_code" => Response::HTTP_OK,
            "msg" => "Painting Updated Successfully."
        ];
    }

    public function deletePainting(Request $request)
    {
        $validateResult = $this->validateRequest($request, RequestType::$REQUEST_DELETE);
        if ($validateResult != null) {
            return [
                "status_code" => Response::HTTP_BAD_REQUEST,
                "msg" => $validateResult
            ];
        }

        //delete from Mysql
        $this->crudMysql->delete($request);

        //Event (Kafka)
        $this->dispatch("yes", "Deleted");

        return [
            "status_code" => Response::HTTP_OK,
            "msg" => "Deleting Success"
        ];
    }

    public function searchPainting(Request $request)
    {
        $validationResult = $this->validate->validateNewRequest($request, RequestType::$REQUEST_SEARCH);
        if ($validationResult != null) {
            return [
                "status_code" => Response::HTTP_BAD_REQUEST,
                "msg" => $validationResult
            ];
        }
        $QueryManager = new ElasticSearchQueryManager();
        $resultData = $QueryManager->ProcessSearchRequest($request);

        return $resultData;

    }

    private function dispatch($topicName, $status)
    {
        $this->eventDispatcher->dispatch(new KafkaEvent($topicName, $status));
    }

    private function validateRequest(Request $request, $type)
    {
        /*
         * This Function Checks For Request and Validate,
         *      If OK returns   : Null
         *      If not returns  : "<Error Message>"
         */

        $validationResult = $this->validate->validateNewRequest($request, RequestType::$REQUEST_CREATE);
        return $validationResult == null ? null : $validationResult;
    }
}