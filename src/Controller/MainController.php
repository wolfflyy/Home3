<?php


namespace App\Controller;


use App\Entity\Artist;
use App\Entity\Genre;
use App\Entity\Manga;
use App\Form\AddToCartType;
use App\Manager\CartManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * Class MainController
 * @package App\Controller
 */
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
            'genre' => $genre,
        ]);
    }

//    /**
//     * @Route("/add/manga_view/{id}", name="app_view_manga")
//     */
//    public function detail(Manga $manga)
//    {
//        $form = $this->createForm(AddToCartType::class);
//
//        return $this->render('Main/View.html.twig', [
//            'manga' => $manga,
//            'form' => $form->createView()
//        ]);
//    }



    /**
     * @Route("/add/manga_view/{id}", name="app_view_manga")
     */
    public function Show(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger, int $id, Manga $manga, CartManager $cartManager): Response
    {
        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $item->setManga($manga);

            $cart = $cartManager->getCurrentCart();
            $cart
                ->addItem($item)
                ->setUpdatedAt(new \DateTime());

            $cartManager->save($cart);

            return $this->redirectToRoute('app_view_manga', ['id' => $manga->getId()]);
        }

//        $entitymanager = $doctrine->getManager();
//        $manga = $entitymanager->getRepository(Manga::class);
//        $genre = $entitymanager->getRepository(Genre::class);
//        $artist = $entitymanager->getRepository(Artist::class);

//        $manga = $doctrine->getRepository(Manga::class)->findMangaWithGenreAndArtist();
//        $genre = $doctrine->getRepository(Genre::class)->findAll();
//        $artist = $doctrine->getRepository(Artist::class)->findAll();

//        $genreName = $manga->getGenre()->getGenreName();

        $manga = $doctrine->getRepository(Manga::class)->findManga($id);
        $genre = $doctrine->getRepository(Genre::class)->findAll();
        $artist = $doctrine->getRepository(Artist::class)->findAll();
//        $genre = $manga->getGenre();
//        $artist = $manga->getArtist();
//        $form = $this->createForm(AddToCartType::class);

        return $this->render('Main/View.html.twig', array (
            'manga' => $manga,
            'genre' => $genre,
            'artist' => $artist,
            'form' => $form->createView()
        ));
    }


//    /**
//     * @Route("/add/manga_view/{id}", name="app_view_manga")
//     */
//    public function detail(Manga $manga, Request $request, CartManager $cartManager)
//    {
//        $form = $this->createForm(AddToCartType::class);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $item = $form->getData();
//            $item->setManga($manga);
//
//            $cart = $cartManager->getCurrentCart();
//            $cart
//                ->addItem($item)
//                ->setUpdatedAt(new \DateTime());
//
//            $cartManager->save($cart);
//
//            return $this->redirectToRoute('app_view_manga', ['id' => $manga->getId()]);
//        }
//
//        return $this->render('Main/View.html.twig', [
//            'manga' => $manga,
//            'form' => $form->createView()
//        ]);
//    }



//    /**
//     * @Route("/manga/view/{id}", name="app_view_manga")
//     */
//    public function View(ManagerRegistry $doctrine, $id): Response
//    {
//        $manga = $doctrine->getRepository(Manga::class)->find($id);
//        $artist = $doctrine->getRepository(Artist::class)->find($id);
//        $genre = $doctrine->getRepository(Genre::class)->find($id);
//
//        return $this->render('Main/View.html.twig', [
//           'manga' => $manga,
//           'artist' => $artist,
//           'genre' => $genre
//        ]);
//    }


//    /**
//     * @Route("/latest", name="app_latest")
//     */
//    public function Latest(): Response
//    {
//        return $this->render('Main/latest.html.twig', [
//
//        ]);
//    }

}