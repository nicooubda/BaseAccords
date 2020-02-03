<?php

namespace App\Controller;

use App\Entity\User as EntityUser;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @var AccordsRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, UserRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/security/inscription", name="security.inscription")
     *
     *@param Request $request
     *
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function registraion(Request $request, UserPasswordEncoderInterface $encode)
    {
        $user = new EntityUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encode->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/security/listeUser", name="security.userListe")
     *
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $ListeUser = $this->repository->findAll();

        return $this->render('security/showUser.html.twig', [
            'users' => $ListeUser, ]);
    }

    /**
     * @Route("/", name="security_login")
     *
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function login()
    {
        $user = $this->getUser();
        $boolAdmin = 0;

        if ($user != null) {
            foreach (($user->getRoles()) as $key => $value) {
                if ($value == 'ROLE_ADMIN') {
                    $boolAdmin = 1;
                }
            }
            if ($boolAdmin == 1) {
                return $this->redirectToRoute('admin.langue.index');
            } else {
                return $this->render('userSimple/home.html.twig');
            }
        }

        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/security/edit/{id}", name="security.edit", methods="GET|POST")
     *
     * @param EntityUser $user
     * @param Request    $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(EntityUser $user, Request $request, UserPasswordEncoderInterface $encode)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encode->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Modifier avec succes');

            return $this->redirectToRoute('security.userListe');
        }

        return $this->render('security/editUser.html.twig', [
            'users' => $user,
            'form' => $form->createView(), ]);
    }
}
