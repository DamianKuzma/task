<?php

declare(strict_types=1);

namespace App\Validator;

use App\Entity\Country;
use App\Exception\CountryException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CountryValidator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(Country $country)
    {
        $errors = $this->validator->validate($country);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $messages[] = $error->getMessage();
            }

            throw new CountryException(implode(', ', $messages));
        }

        return new JsonResponse([
            'message' => 'Country is valid!'
        ]);
    }
}