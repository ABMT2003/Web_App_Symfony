<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Repository\AnnouncementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AnnouncementController extends AbstractController
{
    #[Route('/new_announcement/{message}', name: 'new_announcement')]
    public function newAnnouncement(string $message, EntityManagerInterface $entityManager): Response
    {
        $announcement = new Announcement();
        $announcement->setMessage($message);
        $announcement->setTimestamp(new \DateTimeImmutable());

        $entityManager->persist($announcement);
        $entityManager->flush();

        return new Response('Saved announcement with id ' . $announcement->getId());
    }

    #[Route('/announcement/{id}', name: 'show_announcement', requirements: ['id' => '\d+'])]
    public function show(int $id, AnnouncementRepository $repository): Response
    {
        $announcement = $repository->find($id);

        if (!$announcement) {
            throw $this->createNotFoundException('No announcement with id ' . $id);
        }

        return $this->render('announcement/show.html.twig', ['announcement' => $announcement]);
    }

    #[Route('/announcements', name: 'list_announcements')]
    public function list(AnnouncementRepository $repository): Response
    {
        return $this->render('announcement/list.html.twig', [
            'announcements' => $repository->findAll(),
        ]);
    }
}
