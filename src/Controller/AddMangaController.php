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
     * @Route("/add/MangaWithGenreAndArtist", name="app_list_manga")
     */
    public function List(ManagerRegistry $doctrine): Response
    {
        $mangas = $doctrine->getRepository(Manga::class)->findAll();
        $genres = $doctrine->getRepository(Genre::class)->findAll();
        return $this->render('add_manga/index.html.twig', ['mangas' => $mangas,
            'genres' => $genres
        ]);
    }

    /**
     * @Route("/add/mangaByGenre", name="mangaByGenre")
     */
    public function mangaByGenreAction(ManagerRegistry $doctrine, $id): Response
    {
        $genre = $doctrine->getRepository(Genre::class)->find($id);
        $mangas = $genre->getMangas();
        $genres = $doctrine->getRepository(Genre::class)->findAll();
        return $this->render('add_manga/index.html.twig', [
            'mangas' => $mangas,
            'genres' => $genres
        ]);

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
     * @Route("/add/manga/edit/{id}", name="app_edit_manga")
     */
    public function edit(ManagerRegistry $doctrine, int $id, Request $request): Response
    {
        $entitymanager = $doctrine->getManager();
        $manga = $entitymanager->getRepository(Manga::class)->find($id);
        $form = $this->createForm(AddMangaType::class, @$manga);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entitymanager = $doctrine->getManager();
            $entitymanager->persist($manga);
            $entitymanager->flush();

            return $this->redirectToRoute('app_list_manga', [
                'id' => $manga->getId()
            ]);
        }
        return $this->render('add_manga/edit.html.twig', [
            'form' => $form,
        ]);
    }
    public function saveChanges(ManagerRegistry $doctrine, $form, $request, $manga)
    {
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manga->setName($request->request->get('manga')['name']);
            $manga->setGenre($request->request->get('manga')['genre']);
            $manga->setDescription($request->request->get('manga')['description']);
            $manga->setPrice($request->request->get('manga')['price']);
            $manga->setDate(\DateTime::createFromFormat('Y-m-d', $request->request->get('manga')['create_date']));
            $entitymanager = $doctrine->getManager();
            $entitymanager->persist($manga);
            $entitymanager->flush();

            return true;
        }

        return false;
    }


    /**
     * @Route("/add/manga/delete/{id}", name="app_delete_manga")
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

        return $this->redirectToRoute('app_list_manga');
    }
//    public function adminDashboard(): Response
//    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');
//
//        // or add an optional message - seen by developers
//        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
//    }

}
