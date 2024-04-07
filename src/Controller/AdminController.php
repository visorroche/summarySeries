<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Repository\CategorysRepository;
use App\Service\ImdbService;
use Doctrine\ORM\EntityManagerInterface;

class AdminController extends AbstractController
{
    private $imdbService;
    private $categorysRepository;


    public function __construct(ImdbService $imdbService, 
                                CategorysRepository $categorysRepository,
                                EntityManagerInterface $entityManager)
    {
        $this->imdbService = $imdbService;
        $this->categorysRepository = $categorysRepository;
    }

    #[Route('/admin/categorys/update', name: 'app_admin_categoys', methods: ['GET'])]
    public function categorysUpdate(): Response
    {
        $data = $this->imdbService->getAllCategorys();
        foreach ($data as $category) {
            $cat[] = new Category($category['id'], $category['name']);
        }
        $this->categorysRepository->insertAllIgnoreDuplicate($cat);
        
        return new Response('Categorias atualizadas com sucesso');
    }

}
