<?php

namespace App\Controller;

use App\Entity\User as EntityUser;
use App\Form\HistoriqueType;
use App\Form\ResetPassType;
use App\Form\UserType;
use App\Repository\UserRepository;
use DH\DoctrineAuditBundle\Reader\AuditReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

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
    public function registration(Request $request, UserPasswordEncoderInterface $encode, \Swift_Mailer $mailer)
    {
        $user = new EntityUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encode->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $user->setActivationToken(md5(uniqid()));
            $user->setResetToken(md5(uniqid()));
            $this->em->persist($user);
            $this->em->flush();
            $message = (new \Swift_Message('Activation de votre compte'))
                    ->setFrom('worn.succes@yahoo.fr')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'email/activation.html.twig',
                            ['token' => $user->getResetToken()]
                        ),
                        'text/html'
                    );

            $mailer->send($message);
            $this->addFlash('message', 'L\'utilisateur a été ajouté avec succès');

            return $this->redirectToRoute('security.userListe');
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
     */
    public function login(Request $request)
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
                return $this->redirectToRoute('security.userListe');
            } else {
                return $this->render('userSimple/home.html.twig');
            }
        } else {
            $this->addFlash('message', 'Veuillez renseigner les bons identifiants.');

            return $this->render('security/login.html.twig', ['message' => 'Veuillez renseigner les bons identifiants.']);
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
            $this->addFlash('success', 'Modifier avec succès');

            return $this->redirectToRoute('security.userListe');
        }

        return $this->render('security/editUser.html.twig', [
            'users' => $user,
            'form' => $form->createView(), ]);
    }

    /**
     * @Route("/security/delete/{id}", name="security.delete", methods="DELETE")
     *
     * @param EntityUser $user
     * @param Request    $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(EntityUser $user, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->get('_token'))) {
            $this->em->remove($user);
            $this->em->flush();
            $this->addFlash('success', 'Utilisateur supprimé.');

            return $this->redirectToRoute('security.userListe');
        }
    }

    /**
     * @Route("/activation/{token}",name="activation")
     */
    public function activation($token, UserRepository $userRepository, Request $request)
    {
        //On verifie si un utilisateur a ce token
        $user = $userRepository->findOneBy(['activation_token' => $token]);
        //Si aucun utilisateur m'existe pas avec ce token
        if (!$user) {
            //Erreur 404
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        //On supprime le token
        $user->setActivationToken(null);
        $token = $user->getResetToken();
        $user->setResetToken(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        //ajout de flash message
        $this->addFlash('message', 'Votre compte a été activé');
        $boolAdmin = 0;

        if ($user != null) {
            /*foreach (($user->getRoles()) as $key => $value) {
                if ($value == 'ROLE_ADMIN') {
                    $boolAdmin = 1;
                }
            }
            if ($boolAdmin == 1) {
                return $this->redirectToRoute('admin.langue.index');
            } else {
                return $this->render('userSimple/home.html.twig');
            }
        }*/
            return $this->redirectToRoute('app_reset_password', ['token' => $token]);
        }
    }

    /**
     *@Route("/oubli-pass",name="app_forgotten_pass")
     *
     * @param Request $request
     */
    public function forgottenPass(Request $request, UserRepository $userRepository, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $donnees = $form->getData();
            $user = $userRepository->findOneByEmail($donnees['email']);

            if (!$user) {
                $this->addFlash('message', 'cette adresse n\'existe pas');

                return $this->render('security/resetPass.html.twig', [
                    'form' => $form->createView(), ]);
            }
            $token = $tokenGenerator->generateToken();
            try {
                $user->setResetToken($token);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', 'Une erreur est survenue');

                return $this->redirectToRoute('security_login');
            }
            $url = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
            $message = (new \Swift_Message('Mot de passe oublié'))
                    ->setFrom('no-reply@yahoo.fr')
                    ->setTo($user->getEmail())
                    ->setBody(
                        'Bonjour,<br><br>Une demande de r&eacuteinitialisation a &eacutet&eacute effectu&eacute sur la plateforme de base de donn&eacutees des traitées et accords du misnistère des affaires étrangères de Burkina Faso. Veuillez cliquez sur le lien suivant:'.$url,
                        'text/html'
                    );

            $mailer->send($message);
            $this->addFlash('message', 'Un e-mail de réinitialisation de mot de passe a été envoyé à l\'adresse indiquée');

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/resetPass.html.twig', [
            'form' => $form->createView(), ]);
    }

    /**
     * @Route("/reset-pass/{token}",name="app_reset_password")
     */
    public function resetPassword($token, Request $request, UserPasswordEncoderInterface $encode)
    {
        $user = $this->getDoctrine()->getRepository(EntityUser::class)->findOneBy(['reset_token' => $token]);
        if (!$user) {
            $this->addFlash('danger', 'Token inconnu');

            return $this->redirectToRoute('security_login');
        }
        if ($request->isMethod('POST')) {
            if ($request->request->get('_password') == $request->request->get('_cpassword')) {
                $user->setResetToken(null);
                $user->setActivationToken(null);
                $user->setPassword($encode->encodePassword($user, $request->request->get('_password')));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('message', 'Mot de passe modifié avec succes');

                return $this->redirectToRoute('security_login');
            } else {
                $this->addFlash('message', 'Les mot de passe sont differents.');

                return $this->render('security/newPass.html.twig', ['token' => $token, 'message' => 'Les mots de passe sont différents.']);
            }
        } else {
            return $this->render('security/newPass.html.twig', ['token' => $token]);
        }
    }

    /**
     * @Route("/audit/details", name="dh_doctrine_audit_show_audit_entry")
     *
     *@param Request $request
     */
    public function indexe(AuditReader $reader, Request $request)
    {
        $form = $this->createForm(HistoriqueType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donnees = $form->getData();
            $table = str_replace(' ', '', $donnees['table']);

            $date_f = $donnees['date'];
            $date_f = date_timestamp_get($date_f);

            $entity = 'App\Entity\\'.$table;
            $action = $donnees['action'];

            if ($action == 'INSERT') {
                $data = $reader->filterBy(AuditReader::INSERT);
            } elseif ($action == 'UPDATE') {
                $data = $reader->filterBy(AuditReader::UPDATE);
            } else {
                $data = $reader->filterBy(AuditReader::REMOVE);
            }
            $data = $reader->getAudits($entity);

            for ($i = 0; $i < count($data); ++$i) {
                $date = $data[$i]->getCreatedAt();
                $date = strtotime(explode(' ', $date)[0]);
                if ($date < $date_f) {
                    unset($data[$i]);
                    array_values($data);
                }
            }
            dump($data);

            return $this->render('/security/historique.html.twig', [
                'form' => $form->createView(),
                'entity' => $entity,
                'entry' => $data,
            ]);
            //return $this->render('@DHDoctrineAudit/Audit/entry.html.twig', [
        }

        return $this->render('/security/historique.html.twig', [
            'form' => $form->createView(),
            'entity' => '',
            'entry' => '',
        ]);
    }
}
