<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Article;
use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Form\UserType;
use SoftUniBlogBundle\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();


            return $this->redirectToRoute('security_login');
        }

        return $this->render(
            'user/register.html.twig',
            array('form' => $form->createView())
        );
    }



    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/profile", name="user_profile")
     */
    public function profileAction()
    {
        $user = $this->getUser();
        $articles = $this->getDoctrine()->getRepository(Article::class)->findBy(
            ['authorId' => $user->getId()],
            ['dateAdded' => 'DESC']
        );

        $articles = array_slice($articles, 0, 4);

        return $this->render("user/profile.html.twig", [
            'user'=>$user,
            'articles' => $articles
        ]);
    }

    /**
     * @param id
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/profile/delete/{id}")
     * @return RedirectResponse
     */
    public function deleteProfileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        $articles = $em->getRepository(Article::class)->findBy(['authorId' => $id]);
        foreach ($articles as $article){
            $em->remove($article);
        }
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('security_login');
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/profile/articles", name="user_articles")
     */
    public function profileArticlesAction()
    {
        $user = $this->getUser();
        $articles = $this->getDoctrine()->getRepository(Article::class)->findBy(
            ['authorId' => $user->getId()],
            ['dateAdded' => 'DESC']
        );

        return $this->render("user/articles.html.twig", [
            'user'=>$user,
            'articles' => $articles
        ]);
    }
}
