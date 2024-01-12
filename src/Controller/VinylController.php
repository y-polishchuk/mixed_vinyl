<?php

namespace App\Controller;

use App\Entity\VinylMix;
use App\Repository\VinylMixRepository;
use App\Service\MixRepository;
use Doctrine\ORM\EntityManagerInterface;
use function Symfony\Component\String\u;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VinylController extends AbstractController
{
    public function __construct(
        private MixRepository $mixRepository, 
        private bool $isDebug
        )
    {
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $tracks = [
            ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
            ['song' => 'Waterfalls', 'artist' => 'TLC'],
            ['song' => 'Creep', 'artist' => 'Radiohead'],
            ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
            ['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
            ['song' => 'Fantasy', 'artist' => 'Mariah Carey']
        ];

        return $this->render('vinyl/index.html.twig', [
            'title' => 'PB & Jams',
            'tracks' => $tracks
        ]);
    }

    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(VinylMixRepository $mixRepository, string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;
        // $mixes = $this->mixRepository->findAll();

        $mixes = $mixRepository->findAll(); // If you want to query from a table, you'll do that throught the repository of the entity, whose data you need
        
        return $this->render('vinyl/browse.html.twig', [
            'genre' => $genre,
            'mixes' => $mixes,
        ]);
    }
}
