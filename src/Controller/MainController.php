<?php


namespace App\Controller;


use App\Entity\Artist;
use App\Entity\Genre;
use App\Entity\Manga;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class MainController extends AbstractController
{
//    #[Route('/', name: 'app_homepage')]

    /**
     * @Route("/", name="app_homepage")
     */
    public function Homepage(ManagerRegistry $doctrine): Response
    {
        $manga = $doctrine->getRepository(Manga::class)->findAll();
        $artist = $doctrine->getRepository(Artist::class)->findAll();
        $genre = $doctrine->getRepository(Genre::class)->findAll();


        return $this->render('Main/homepage.html.twig', [
            'manga' => $manga,
            'artist' => $artist,
            'genre' => $genre
        ]);
    }

    /**
     * @Route("/manga/view/{id}", name="app_view_manga")
     */
    public function View(ManagerRegistry $doctrine, $id): Response
    {
        $manga = $doctrine->getRepository(Manga::class)->find($id);
        $artist = $doctrine->getRepository(Artist::class)->find($id);
        $genre = $doctrine->getRepository(Genre::class)->find($id);

        return $this->render('Main/View.html.twig', [
           'manga' => $manga,
           'artist' => $artist,
           'genre' => $genre
        ]);
    }


    /**
     * @Route("/latest", name="app_latest")
     */
    public function Latest(): Response
    {
        return $this->render('Main/latest.html.twig', [

        ]);
    }

}