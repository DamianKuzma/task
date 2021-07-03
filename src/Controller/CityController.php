<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\City;
use App\Exception\AccessDeniedException;
use App\Form\CityFormType;
use App\Service\CityService;
use App\Validator\CityValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    /**
     * @Route("/city", name="city_add", methods={"PUT"})
     */
    public function create(Request $request, CityValidator $validator, CityService $cityService): Response
    {
        if (null === $this->getUser()) {

            throw new AccessDeniedException('Access denied. No user found!');
        }

        $city = new City();
        $form = $this->createForm(CityFormType::class, $city, ['csrf_protection' => false]);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {

            $cityService->checkAndStoreCity($city);

            return $this->json([
                    'saved' => true,
                ]
            );
        }

        $validator->validate($city);

        return $this->json([
            'form' => $form->createView(),
        ]);
    }
}
