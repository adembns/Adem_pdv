<?php

namespace App\Controller;

use App\Entity\Comment1;
use App\Form\Comment1Type;
use App\Repository\Comment1Repository;
use App\Controller\FileException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
Use DateTime;
use Symfony\Component\HttpFoundation\File\Exception\FileException as ExceptionFileException;

#[Route('/comment1')]
class Comment1Controller extends AbstractController
{
    #[Route('/', name: 'app_comment1_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $comments = $entityManager
            ->getRepository(Comment1::class)
            ->findAll();

        return $this->render('comment1/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/new', name: 'app_comment1_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment1();
        $form = $this->createForm(Comment1Type::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avatarFile = $form['avatar']->getData();
            if ($avatarFile) {
                $newFilename = uniqid().'.'.$avatarFile->guessExtension();
    
                // Déplacez le fichier vers le répertoire où vous stockez les avatars
                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (ExceptionFileException$e) {
                    // Gérer l'exception si le fichier n'a pas pu être téléchargé
                }
    
                // Mettez à jour la propriété avatar de l'entité Comment1 avec le chemin du fichier
                //$comment->setAvatar($newFilename);
            }


            
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_comment1_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment1/new.html.twig', [
            'comment' => $comment,
            'form' => $form ->createView(),
        ]);
    }
   
    #[Route('/date', name: 'app_comment1_date', methods: ['GET'])]
    public function date(Comment1Repository $repo): Response
    {
            return $this->render('article1/show.html.twig', [
            'comments' => $repo->orderbydesc_date(),
        ]);
    }

    #[Route('/{id}', name: 'app_comment1_show', methods: ['GET'])]
    public function show(Comment1 $comment): Response
    {
        return $this->render('comment1/show.html.twig', [
            'comment1' => $comment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comment1_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment1 $comment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Comment1Type::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUpdated(new DateTime());
            $entityManager->flush();

            return $this->redirectToRoute('app_article1_front', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment1/edit.html.twig', [
            'comment1' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comment1_delete', methods: ['POST'])]
    public function delete(Request $request, Comment1 $comment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_article1_front', [], Response::HTTP_SEE_OTHER);
    }
}
