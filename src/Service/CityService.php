<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\City;
use App\Exception\CountryException;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CityService
{
    private CountryRepository $countryRepository;

    private EntityManagerInterface $entityManager;

    public function __construct(CountryRepository $countryRepository, EntityManagerInterface $entityManager)
    {
        $this->countryRepository = $countryRepository;
        $this->entityManager = $entityManager;
    }

    public function checkAndStoreCity(City $city)
    {
        $country = $this->countryRepository->findOneBy(['id' => $city->getCountry()->getId()]);

        if (null === $country) {
            throw new CountryException('Country not found!');
        }

        $this->saveNewCity($city);
    }

    private function saveNewCity(City $city)
    {
        $this->entityManager->persist($city);
        $this->entityManager->flush();
    }
}