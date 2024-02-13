<?php

namespace App\Controller;

use App\Entity\Serie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/series', name: 'serie_')]
class SerieController extends AbstractController {
    #[Route('', name: 'list')]
    public function list(): Response {
        // TODO: aller chercher les séries en bdd
        return $this->render('serie/list.html.twig', []);
    }

    #[Route('/details/{id}', name: 'details')]
    public function details(int $id): Response {
        // TODO: aller chercher les séries en bdd
        return $this->render('serie/details.html.twig', []);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response {
        dump($request);
        return $this->render('serie/create.html.twig', []);
    }

    #[Route('/demo', name: 'demo')]
    public function demo(EntityManagerInterface $entityManager): Response {
//        Crée une instance de mon entité
        $serie = new Serie();

//        Hydrate toutes les propriétés
        $serie->setName('pif');
        $serie->setBackdrop('fsg');
        $serie->setPoster('gsfcyuh');
        $serie->setDateCreated(new \DateTime());
        $serie->setDate(new \DateTime("- 1 year"));
        $serie->setDateModified(new \DateTime("- 6 month"));
        $serie->setGenres('drama');
        $serie->setOverview("fhudksjbhujsbvudshbfrrfvnedi");
        $serie->setPopularity(286.03);
        $serie->setVote(1.2);
        $serie->setStatus("Canceled");
        $serie->setTmdbId(321654);

        dump($serie);

        $entityManager->persist($serie);
        $entityManager->flush();

        dump($serie);

//        $entityManager->remove($serie);
        $serie->setName("Le regard entre les yeux");
        $entityManager->flush();

        return $this->render('serie/demo.html.twig', []);
    }


}
