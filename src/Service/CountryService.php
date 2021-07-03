<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Country;
use App\Exception\CountryException;
use App\Factory\CountryFactory;
use App\Repository\CountryRepository;
use App\Validator\CountryValidator;
use Doctrine\ORM\EntityManagerInterface;

class CountryService
{
    private CountryRepository $countryRepository;
    private CountryFactory $countryFactory;
    private CountryValidator $countryValidator;
    private EntityManagerInterface $entityManagerInterface;

    public function __construct(CountryRepository $countryRepository, CountryFactory $countryFactory, CountryValidator $countryValidator, EntityManagerInterface $entityManagerInterface)
    {
        $this->countryRepository = $countryRepository;
        $this->countryFactory = $countryFactory;
        $this->countryValidator = $countryValidator;
        $this->entityManagerInterface = $entityManagerInterface;
    }

    public function checkCountry(string $name, string $canonicalName)
    {
        $country = $this->countryRepository->findOneBy(['canonicalName' => $canonicalName]);

        if (null !== $country) {

            throw new CountryException(sprintf('Country with canonical name %s exist!', $canonicalName));
        }

        $country = $this->countryFactory->create($name, $canonicalName);
        $this->countryValidator->validate($country);
        $this->saveCountry($country);
    }

    private function saveCountry(Country $country)
    {
        $this->entityManagerInterface->persist($country);
        $this->entityManagerInterface->flush();
    }
}
