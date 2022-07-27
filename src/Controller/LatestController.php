<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Entity\Manga;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LatestController extends AbstractController
{
    /**
     * @Route("/latest", name="app_latest_manga")
     */
    public function List(ManagerRegistry $doctrine, $create_date): Response
    {
        $entitymanager = $doctrine->getManager();
        $manga = $doctrine->getRepository(Manga::class);


        $data = $mangas->findMangaLatest($create_date);
        return $this->render('latest/index.html.twig', array (
            'manga' => $manga,
        ));
    }
}
