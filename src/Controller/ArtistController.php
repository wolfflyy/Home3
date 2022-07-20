<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\ArtistType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArtistController extends AbstractController
{
    #[Route('/artist', name: 'app_artist')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $artist = $doctrine->getRepository(Artist::class)->findAll();

        return $this->render('artist/index.html.twig', [
            'artist' => $artist,
        ]);
    }

    /**
     * @Route("/add/artist/create", name="app_create_artist")
     */
    public function create(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger)
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $doctrine->getManager();
            $entitymanager->persist($form->getData());
            $entitymanager->flush();

            $this->addFlash(
                'notice',
                'New Artist Added'
            );
            return $this->redirectToRoute('app_create_artist');
        }
        return $this->render('artist/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
