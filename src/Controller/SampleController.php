<?php

namespace App\Controller;

use App\Entity\Sample;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SampleController extends AbstractController
{
    #[Route('/sample-controller', name: 'sample')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $sample = new Sample();
        $sample->setIsActive(false);
        $sample->setComment(null);
        $entityManager->persist($sample);
        $entityManager->flush();

        dump($sample);

        return $this->render('sample/index.html.twig', [
            'controller_name' => 'SampleController',
        ]);
    }
}
