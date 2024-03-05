<?php

namespace App\Controller;

use App\Entity\Article1;
use App\Entity\Comment1;
use App\Entity\LikeDislike;
use App\Entity\User1;
use App\Form\Article1Type;
use App\Repository\Article1Repository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTime;
use App\Form\Comment1Type;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/article1')]
class Article1Controller extends AbstractController
{
    
    #[Route('/', name: 'app_article1_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $article1s = $entityManager
            ->getRepository(Article1::class)
            ->findAll();

        return $this->render('article1/index.html.twig', [
            'article1s' => $article1s,
        ]);
    }

   /* #[Route('/front', name: 'app_article1_front', methods: ['GET'])]
    public function indexf(EntityManagerInterface $entityManager): Response
    {
        $article1s = $entityManager
            ->getRepository(article1::class)
            ->findAll();

        return $this->render('article1/blog.html.twig', [
            'articles' => $article1s,
        ]);
    }*/

    #[Route('/front', name: 'app_article1_front', methods: ['GET'])]
public function indexf(Article1Repository $article1Repository, Request $request, PaginatorInterface $paginator, EntityManagerInterface $entityManager): Response
{
    $pagination = $paginator->paginate(
        $article1Repository->paginationQuery(),
        $request->query->get('page', 1),
    );

    // Récupérer les likes et dislikes pour chaque article
    $likesCounts = [];
    $dislikesCounts = [];
    foreach ($pagination as $article) {
        $likesCounts[$article->getId()] = $entityManager->getRepository(LikeDislike::class)->count(['article' => $article, 'type' => 'like']);
        $dislikesCounts[$article->getId()] = $entityManager->getRepository(LikeDislike::class)->count(['article' => $article, 'type' => 'dislike']);

        // Limiter le contenu de l'article à 5 mots
        $content = explode(' ', $article->getContenu());
        $shortContent = implode(' ', array_slice($content, 0, 5));
        $article->setContenu($shortContent . '...');
    }

    return $this->render('article1/blog.html.twig', [
        'articles' => $pagination,
        'likesCounts' => $likesCounts,
        'dislikesCounts' => $dislikesCounts,
    ]);
}



    #[Route('/desc', name: 'app_article1_desc', methods: ['GET'])]
    public function desc(Article1Repository $article1Repository, Request $request,PaginatorInterface $paginator,EntityManagerInterface $entityManager): Response
    {
        $pagination = $paginator->paginate(

            $article1Repository->orderbydesc_contenu(),
            $request->query->get('page',1),
            3
        );
            

      // Récupérer les likes et dislikes pour chaque article
      $likesCounts = [];
      $dislikesCounts = [];
      foreach ($pagination as $article) {
          $likesCounts[$article->getId()] = $entityManager->getRepository(LikeDislike::class)->count(['article' => $article, 'type' => 'like']);
          $dislikesCounts[$article->getId()] = $entityManager->getRepository(LikeDislike::class)->count(['article' => $article, 'type' => 'dislike']);
      }

      return $this->render('article1/blog.html.twig', [
          'articles' => $pagination,
          'likesCounts' => $likesCounts,
          'dislikesCounts' => $dislikesCounts,
      ]);
    }
    #[Route('/asc', name: 'app_article1_asc', methods: ['GET'])]
    public function asc(Article1Repository $article1Repository, Request $request,PaginatorInterface $paginator,EntityManagerInterface $entityManager): Response
    {
        $pagination = $paginator->paginate(

            $article1Repository->orderbyasc_contenu(),
            $request->query->get('page',1),
            3
        );
            

      // Récupérer les likes et dislikes pour chaque article
      $likesCounts = [];
      $dislikesCounts = [];
      foreach ($pagination as $article) {
          $likesCounts[$article->getId()] = $entityManager->getRepository(LikeDislike::class)->count(['article' => $article, 'type' => 'like']);
          $dislikesCounts[$article->getId()] = $entityManager->getRepository(LikeDislike::class)->count(['article' => $article, 'type' => 'dislike']);
      }

      return $this->render('article1/blog.html.twig', [
          'articles' => $pagination,
          'likesCounts' => $likesCounts,
          'dislikesCounts' => $dislikesCounts,
      ]);
    }



    #[Route('/new', name: 'app_article1_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article1 = new article1();
        $form = $this->createForm(Article1Type::class, $article1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                        // Traitement de l'image téléchargée
                    
            $imageFile = $form->get('imageFile')->getData();
                    
            if($imageFile instanceof UploadedFile)
            {
                        
            // Gérer l'upload de l'image avec VichUploaderBundle
                        
            $article1->setImageFile($imageFile);
                    
            }



            $article1->setCreated(new DateTime());
            $entityManager->persist($article1);
            $entityManager->flush();

            return $this->redirectToRoute('app_article1_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article1/new.html.twig', [
            'article1' => $article1,
            'form' => $form,
        ]);
    }




  /*  #[Route('/like/{id}', name: 'app_article1_like', methods: ['POST'])]
public function like(Article1 $article1,Security $security): Response
{
    $like = new LikeDislike();
    $like->setArticle($article1)
        ->setType('like');
    $user = $security->getUser();
    if ($user !== null) {
        // if ($_SESSION["id"]!= null)
            //$like->setUser($article1)=$_SESSION["id"];

        $like->setUser($user);
    } else {
        // Handle the case where user is null, perhaps throw an exception or redirect
    }

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($like);
    $entityManager->flush();

    return $this->redirectToRoute('app_article1_front', ['id' => $article1->getId()]);
}
#[Route('/Dislike/{id}', name: 'app_article1_dislike', methods: ['POST'])]
public function dislike(Article1 $article1,Security $security): Response
{
    $like = new LikeDislike();
    $like->setArticle($article1)
        ->setType('dislike');

    $user = $security->getUser();
    if ($user !== null) {
        $like->setUser($user);
    } else {
        // Handle the case where user is null, perhaps throw an exception or redirect
    }

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($like);
    $entityManager->flush();

    return $this->redirectToRoute('app_article1_front', ['id' => $article1->getId()]);
}
*/

#[Route('/like/{id}', name: 'app_article1_like', methods: ['POST'])]
public function like(Article1 $article1, Security $security, EntityManagerInterface $entityManager): Response
{
    $user = $security->getUser();
    
    // Vérifier si l'utilisateur a déjà liké cet article
    $existingLike = $entityManager->getRepository(LikeDislike::class)->findOneBy(['article' => $article1, 'user' => $user, 'type' => 'like']);

    if ($existingLike) {
        // L'utilisateur a déjà liké cet article, redirigez ou affichez un message d'erreur
        // par exemple:
        // return $this->redirectToRoute('app_article1_front', ['id' => $article1->getId()]);
        // ou
        // throw new \Exception('Vous avez déjà liké cet article.');
    } else {
        // Créer un nouveau LikeDislike
        $like = new LikeDislike();
        $like->setArticle($article1)
            ->setType('like')
            ->setUser($user);

        $entityManager->persist($like);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_article1_front', ['id' => $article1->getId()]);
}

#[Route('/dislike/{id}', name: 'app_article1_dislike', methods: ['POST'])]
public function dislike(Article1 $article1, Security $security, EntityManagerInterface $entityManager): Response
{
    $user = $security->getUser();
    
    // Vérifier si l'utilisateur a déjà disliké cet article
    $existingDislike = $entityManager->getRepository(LikeDislike::class)->findOneBy(['article' => $article1, 'user' => $user, 'type' => 'dislike']);

    if ($existingDislike) {
        // L'utilisateur a déjà disliké cet article, redirigez ou affichez un message d'erreur
        // par exemple:
        // return $this->redirectToRoute('app_article1_front', ['id' => $article1->getId()]);
        // ou
        // throw new \Exception('Vous avez déjà disliké cet article.');
    } else {
        // Créer un nouveau LikeDislike
        $dislike = new LikeDislike();
        $dislike->setArticle($article1)
            ->setType('dislike')
            ->setUser($user);

        $entityManager->persist($dislike);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_article1_front', ['id' => $article1->getId()]);
}

    #[Route('/{id}', name: 'app_article1_show', methods: ['GET', 'POST'])]
    public function show(Article1 $article1, Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment1();
        $form = $this->createForm(Comment1Type::class, $comment);
        $form->handleRequest($request);
        $comments = $entityManager
            ->getRepository(Comment1::class)
            ->findBy(['idArticle' => $article1]);
            $likeRepository = $entityManager->getRepository(LikeDislike::class);
        $likesCount = $likeRepository->count(['article' => $article1, 'type' => 'like']);
        $dislikesCount = $likeRepository->count(['article' => $article1, 'type' => 'dislike']);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setIdArticle($article1);
            $users = new User1();
            $users->setId(1);
            $comment->setIdUser1($users);
            $comment->setCreated(new DateTime());
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('app_article1_show', ['id' => $article1->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('article1/show.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'article1' => $article1,
            'comments' => $comments,
            'likesCount' => $likesCount,
            'dislikesCount' => $dislikesCount,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article1_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article1 $article1, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Article1Type::class, $article1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article1->setUpdated(new DateTime());
            $entityManager->flush();

            return $this->redirectToRoute('app_article1_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article1/edit.html.twig', [
            'article1' => $article1,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article1_delete', methods: ['POST'])]
    public function delete(Request $request, Article1 $article1, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article1->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article1);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article1_index', [], Response::HTTP_SEE_OTHER);
    }

   






















}
