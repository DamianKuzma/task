<?php

declare(strict_types=1);

namespace App\Validator;

use App\Entity\City;
use App\Exception\CityValidateException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CityValidator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(City $city)
    {
        $errors = $this->validator->validate($city);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $messages[] = $error->getMessage();
            }

            throw new CityValidateException(implode(', ', $messages));
        }

        return new JsonResponse([
            'message' => 'City is valid!'
        ]);
    }
}
