<?php


namespace App\Factory;


use App\Entity\Country;

class CountryFactory
{
    public function create(string $name, string $canonicalName)
    {
        $country = new Country();
        $country->setName($name);
        $country->setCanonicalName($canonicalName);

        return $country;
    }
}