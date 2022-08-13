<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Genre;
use App\Entity\Manga;
use App\Form\AddToCartType;
use App\Manager\CartManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryController extends AbstractController
{
//    #[Route('/category', name: 'app_category')]

    /**
     * @Route("/category/MangaWithGenre", name="app_category_manga")
     */
    public function List(ManagerRegistry $doctrine): Response
    {
        $mangas = $doctrine->getRepository(Manga::class)->findAll();
        $genres = $doctrine->getRepository(Genre::class)->findAll();
        return $this->render('category/index.html.twig', ['mangas' => $mangas,
            'genres' => $genres
        ]);
    }

    /**
     * @Route("/add/mangaByGenre/{id}", name="mangaByGenre")
     */
    public function mangaByGenreAction(ManagerRegistry $doctrine, $id): Response
    {
        $genre = $doctrine->getRepository(Genre::class)->find($id);
        $mangas = $genre->getMangas();
        $genres = $doctrine->getRepository(Genre::class)->findAll();
        return $this->render('category/index.html.twig', [
            'mangas' => $mangas,
            'genres' => $genres
        ]);

    }

//    /**
//     * @Route("/category/sortByAZ", name="mangaByAZ")
//     */
//    public function mangaByAZAction(ManagerRegistry $doctrine, $value): Response
//    {
//        $mangas = $doctrine->getRepository(Manga::class)->findMangaByAZ($value);
//        $mangas = $genre->getMangas();
//        return $this->render('category/index.html.twig', [
//            'mangas' => $mangas
//        ]);
//    }


//    public function adminDashboard(): Response
//    {
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
//    }
}
