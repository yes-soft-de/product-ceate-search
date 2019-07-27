<?php


namespace App\Validator;

use App\Entity\Painting;
use App\Enum\RequestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validate implements ValidateInterface
{
    private $validator;
    private $entityManager;

    public function __construct(ValidatorInterface $validator, EntityManagerInterface $entityManagerInterface)
    {
        $this->validator = $validator;
        $this->entityManager = $entityManagerInterface;
    }

    public function validateNewRequest(Request $request, $requestType){
        $error = $this->requestValidator($request, $requestType);
        if ($error != null){
            return $error;
        }

        if ($requestType === RequestType::$REQUEST_SEARCH){
            $error = $this->searchQueryValidator($request);
            if ($error != null){
                return $error;
            }
        } else {
            $error = $this->pantingValidator($request, $requestType);
            if ($error != null) {
                return $error;
            }
        }
        return null;
    }

    public function requestValidator(Request $request, $type)
    {
        switch ($type) {
            case RequestType::$REQUEST_CREATE:
                return $this->validateRequestCreate($request);
                break;
            case RequestType::$REQUEST_UPDATE:
                return $this->validateRequestUpdate($request);
                break;
            case RequestType::$REQUEST_DELETE:
                return $this->validateRequestDelete($request);
                break;
            case RequestType::$REQUEST_SEARCH:
                return $this->validateRequestSearch($request);
            default:
                return "This API Doesn't Support This Request Type";
        }
    }

    public function pantingValidator(Request $request, $type)
    {
        $input = json_decode($request->getContent(), true);

        $constraints = new Assert\Collection([

            'id' => [
                new Required(),
                new Assert\NotBlank(),
            ],
            'name' => [
                new Required(),
                new Assert\NotBlank(),
            ],
            'image_url' => [
                new Required(),
                new Assert\NotBlank(),
            ],
            'description' => [
                new Required(),
                new Assert\NotBlank(),
            ],
            'size' => [
                new Required(),
                new Assert\NotBlank(),
            ],
            'medium' => [
                new Required(),
                new Assert\NotBlank(),
            ],
            'category' => [
                new Required(),
                new Assert\NotBlank(),
            ]
        ]);

        if ($type == 'create') {
            unset($constraints->fields['id']);
        }
        if ($type == "delete") {
            unset($constraints->fields['name']);
            unset($constraints->fields['image_url']);
            unset($constraints->fields['description']);
            unset($constraints->fields['size']);
            unset($constraints->fields['medium']);
            unset($constraints->fields['category']);
        }

        $violations = $this->validator->validate($input, $constraints);

        if (count($violations) > 0) {
            $accessor = PropertyAccess::createPropertyAccessor();

            $errorMessages = [];

            foreach ($violations as $violation) {
                $accessor->setValue($errorMessages,
                    $violation->getPropertyPath(),
                    $violation->getMessage());
            }

            $result = json_encode($errorMessages);

            return $result;
        }

        if ($type != "create") {
            if (!$this->entityManager->getRepository(Painting::class)->find($input["id"])) {
                return "No panting with this id!";
            }
        }
        return null;
    }

    public function searchQueryValidator(Request $request)
    {
        $input = json_decode($request->getContent(), true);

        $constraints = new Assert\Collection([
            'query' => [
                new Required(),
                new Assert\NotBlank(),
            ]
        ]);

        $violations = $this->validator->validate($input, $constraints);

        if (count($violations) > 0) {
            $accessor = PropertyAccess::createPropertyAccessor();

            $errorMessages = [];

            foreach ($violations as $violation) {
                $accessor->setValue($errorMessages,
                    $violation->getPropertyPath(),
                    $violation->getMessage());
            }

            $result = $errorMessages;

            return json_encode($result);
        }
        return null;
    }

    // region Class Specific Validation Methods
    private function validateRequestCreate(Request $request)
    {
        $method = $request->getMethod();

        if ($method === 'POST')
            return null;
        else {
            return "Method Not Allowed (Allow: POST)";
        }
    }

    private function validateRequestUpdate(Request $request)
    {
        $method = $request->getMethod();

        if ($method === 'PUT')
            return null;
        else
            return "Method Not Allowed (Allow: PUT)";
    }

    private function validateRequestDelete(Request $request){
        $method = $request->getMethod();
        if ($method === "DELETE")
            return null;
        else
            return "Method Not Allowed (Allow: DELETE)";
    }

    private function validateRequestSearch(Request $request){
        $method = $request->getMethod();
        if ($method === "POST")
            return null;
        else
            return "Method Not Allowed (Allow: POST)";
    }
    // endregion
}