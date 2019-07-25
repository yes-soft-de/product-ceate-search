<?php

namespace App\Controller;

use App\Manager\ElasticSearchQueryManager;
use App\Repository\CrudInterface;
use App\Service\PaintingService;
use App\Validator\ValidateInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PaintingController extends BaseController
{
    private $paintingService;

    public function __construct(CrudInterface $crudMysqli, EventDispatcherInterface $eventDispatcher, ValidateInterface $validate)
    {
        // TODO: Service Should Not Depend That Much on Controller But it's fine Now... =(
        $this->paintingService = new PaintingService($crudMysqli, $eventDispatcher, $validate);
    }

    /**
     * @Route("/painting/create", name="createPainting")
     * @return Response
     * @param Request $request
     */
    public function create(Request $request)
    {
        // Main Job: Call the Painting Service, and Format the result

        $result = $this->paintingService->createPainting($request);

        $response = new JsonResponse($result, $result['status_code']);

        // For Local Server Accessibility
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route("/painting/update", name="updatePainting")
     * @return Response
     * @param Request $request
     */
    public function update(Request $request)
    {
        // Main Job: Call the Painting Service, and Format the result

        $result = $this->paintingService->updatePainting($request);

        $response = new JsonResponse($result, $result['status_code']);

        // For Local Server Accessibility
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route("/painting/delete", name="deletePainting")
     * @return Response
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $result = $this->paintingService->deletePainting($request);
        $response = new JsonResponse($result, $result['status_code']);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/painting/search", name="painting_search")
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {

        $result = $this->paintingService->searchPainting($request);

        $response = new JsonResponse($result, $result['status_code']);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

    }

}
