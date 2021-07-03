<?php

namespace App\Controller;

use App\Exception\CountryException;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    /**
     * @Route("/country/{canonicalName}", name="country")
     */
    public function index(string $canonicalName, CountryRepository $countryRepository): JsonResponse
    {
        $country = $countryRepository->findOneBy(['canonicalName' => $canonicalName]);

        if (null === $country) {

            throw new CountryException(sprintf('Country with canonical name %s not found!', $canonicalName));
        }

        return $this->json([
            'country' => $country->getName(),
            'cities' => json_encode($country->getCities()),
        ]);
    }
}
