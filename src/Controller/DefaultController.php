<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    public function about()
    {
        return new Response('About page – produced by my first Symfony controller');
    }

    public function welcome()
    {
        return new Response('Welcome page – produced by my first Symfony controller');
    }

    public function contact()
    {
        return new Response('Contact page – produced by my first Symfony controller');
    }

    #[Route('/hello/world', name: 'hello_world')]
    public function helloAction(): Response
    {
        return $this->render('hello.html.twig');
    }

    public function helloNameAction(string $name): Response
    {
        return $this->render('hello_name.html.twig', ['name' => $name]);
    }

    public function incrementAction(int $digit): Response
    {
        return $this->render('increment.html.twig', [
            'digit' => $digit,
            'result' => $digit + 1,
        ]);
    }

    public function greetingAction(string $salutation, string $name): Response
    {
        return $this->render('greeting.html.twig', [
            'salutation' => $salutation,
            'name' => $name,
        ]);
    }

    public function contactsAction(): Response
    {
        $contacts = [
            ['name' => 'Jane Smith', 'email' => 'jane@smith.com'],
            ['name' => 'John Smith', 'email' => 'john@smith.com'],
            ['name' => 'Bill Gates', 'email' => 'bill@microsoft.com'],
        ];

        dump($contacts);

        return $this->render('contacts.html.twig', ['contacts' => $contacts]);
    }
}
