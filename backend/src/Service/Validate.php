<?php


namespace App\Service;

use App\Entity\Painting;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validate implements ValidateInterface
{
    private $validator;
    private $entityManager;

    public function __construct(ValidatorInterface $validator, EntityManagerInterface $entityManagerInterface)
    {
        $this->validator = $validator;
        $this->entityManager= $entityManagerInterface;
    }

    public function pantingValidator(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (isset($data["id"]))
        {
            $id = $data["id"];
            $input = ['id' => $id];

            $constraints = new Assert\Collection([
                'id' => new Assert\NotBlank
            ]);

            $violations = $this->validator->validate($input, $constraints);

            if (count($violations) > 0)
            {
                $accessor = PropertyAccess::createPropertyAccessor();

                $errorMessages = [];

                foreach ($violations as $violation)
                {
                    $accessor->setValue($errorMessages,
                        $violation->getPropertyPath(),
                        $violation->getMessage());
                }

                $result = json_encode($errorMessages);

                return $result;
            }

            if(!$this->entityManager->getRepository(Painting::class)->find($id))
            {
                return "No panting with this id!";
            }
        }
        else
        {
            return "id, is not in the request!";
        }
    }
}