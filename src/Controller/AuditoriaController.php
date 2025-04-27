<?php

namespace App\Controller;

use App\Repository\AuditoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuditoriaController extends AbstractController
{
    #[Route('/auditoria', name: 'app_auditoria_index')]
    public function index(AuditoriaRepository $auditoriaRepository): Response
    {
        $auditorias = $auditoriaRepository->findBy([], ['dateTime' => 'DESC']);
        return $this->render('auditoria/index.html.twig', [
            'auditorias' => $auditorias,
        ]);
    }
}
