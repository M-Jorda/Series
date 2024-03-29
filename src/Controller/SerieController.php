<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/series', name: 'serie_')]
class SerieController extends AbstractController {

    #[Route('', name: 'list')]
    public function list(SerieRepository $serieRepository): Response {
//        $series = $serieRepository->findBy([], ['popularity' => 'DESC', 'vote' => 'DESC'], 30, 3);
            $series = $serieRepository->findBestSeries();
        return $this->render('serie/list.html.twig', [
            "series" => $series
        ]);
    }

    #[Route('/details/{id}', name: 'details')]
    public function details(int $id, SerieRepository $serieRepository): Response {

        $serie = $serieRepository->find($id);

        if (!$serie) {
            throw $this->createNotFoundException('Nop');
        }

        return $this->render('serie/details.html.twig', [
            "serie" => $serie
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $serie = new Serie();
        $serie->setDateCreated(new \DateTime());

        $serieFrom = $this->createForm(SerieType::class, $serie);

        $serieFrom->handleRequest($request);

        if ($serieFrom->isSubmitted() && $serieFrom->isValid()) {
            $entityManager->persist($serie);
            $entityManager->flush();

            $this->addFlash('success', 'Serie added');
            return $this->redirectToRoute('serie_details', ['id' => $serie->getId()
            ]);
        }

        return $this->render('serie/create.html.twig', [
            'serieForm' => $serieFrom->createView()
        ]);
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
        $serie->setFirstDate(new \DateTime("- 1 year"));
        $serie->setLastDate(new \DateTime("- 6 month"));
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

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Serie $serie, EntityManagerInterface $entityManager) {
    $entityManager->remove($serie);
    $entityManager->flush();

    return $this->redirectToRoute('main_home');
    }

}
