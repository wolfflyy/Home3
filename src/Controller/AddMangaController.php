<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Genre;
use App\Entity\Manga;
use App\Form\AddMangaType;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AddMangaController extends AbstractController
{
//    #[Route('/add/MangaWithGenreAndArtist/{id}', name: 'app_list_manga')]
    /**
     * @Route("/add/MangaWithGenreAndArtist/{id}", name="app_list_manga")
     */
    public function Show(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger, $id): Response
    {
        $entitymanager = $doctrine->getManager();
        $manga = $entitymanager->getRepository(Manga::class);
        $genre = $entitymanager->getRepository(Genre::class);
        $artist = $entitymanager->getRepository(Artist::class);

//        $manga = $doctrine->getRepository(Manga::class)->findMangaWithGenreAndArtist();
//        $genre = $doctrine->getRepository(Genre::class)->findAll();
//        $artist = $doctrine->getRepository(Artist::class)->findAll();

//        $genreName = $manga->getGenre()->getGenreName();

        $manga = $manga->findMangaWithGenreAndArtist($id);
        return $this->render('add_manga/index.html.twig', array (
            'manga' => $manga,
            'genre' => $genre,
            'artist' => $artist,
        ));
    }

    /**
     * @Route("/add/manga/create", name="app_create_manga")
     */
    public function create(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger)
    {
        $manga = new Manga();
        $form = $this->createForm(AddMangaType::class, $manga);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
//            $uploadedFile = $form['image']->getData();
//            $destination = $this->getParameter('kernel.project.dir').'/public/uploads/manga_image';
//            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
//            $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
//
//            $uploadedFile->move(
//                $destination,
//                $newFilename
//            );
//            $addMangaType->setImage($newFilename);


            $uploadedFile = $form->get('image')->getData();
            if ($uploadedFile) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

                // Move the file to the directory where image are stored
                try {
                    $uploadedFile->move(
//                        $this->getParameter('kernel.project.dir') . '/public/uploads/manga_image',
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash(
                      'error',
                      'Cannot Upload'
                    );
                    // ... handle exception if something happens during file upload
                }
                $manga->setImage($newFilename);


//            $uploadedFile = $form->get('image')->getData();
//            if ($uploadedFile) {
//                $NewFilename = $fileUploader->upload($uploadedFile);
//                $manga->setImage($NewFilename);
//            }

                $entitymanager = $doctrine->getManager();
                $entitymanager->persist($manga);
                $entitymanager->flush();

                $this->addFlash(
                    'notice',
                    'New Manga Added'
                );
                return $this->redirectToRoute('app_create_manga');
            }
        }
        return $this->render('add_manga/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add/manga/edit", name="app_edit_manga")
     */
    public function edit(ManagerRegistry $doctrine, $id, Request $request, SluggerInterface $slugger): Response
    {
        $manga = new Manga();
        $form = $this->createForm(AddMangaType::class, $manga);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entitymanager = $doctrine->getManager();
            $manga = $entitymanager->getRepository(Manga::class)->find($id);
            $entitymanager->flush();

            $this->addFlash(
                'notice',
                'Manga edited'
            );

            return $this->redirectToRoute('app_homepage');
        }
        return $this->render('add_manga/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/add/manga/delete", name="app_delete_manga")
     */
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $entitymanager = $doctrine->getManager();
        $manga = $entitymanager->getRepository(Manga::class)->find($id);
        $entitymanager->remove($manga);
        $entitymanager->flush();

        $this->addFlash(
            'notice',
            'Manga Deleted'
        );

        return $this->redirectToRoute('app_homepage');
    }
//    public function adminDashboard(): Response
//    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');
//
//        // or add an optional message - seen by developers
//        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
//    }

}
