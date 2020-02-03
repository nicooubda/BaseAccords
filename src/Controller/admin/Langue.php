<?php

namespace App\Controller\admin;

use App\Entity\Langue as EntityLangue;
use App\Repository\LangueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\LangueType;

class Langue extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var SousTypeDocumentRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, LangueRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/langue", name="admin.langue.index")
     *
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $listeLangues = $this->repository->findAll();

        return $this->render('admin/langue/showLangue.html.twig', [
            'langues' => $listeLangues, ]);
    }

    /**
     * @Route("/admin/langue/new",name="admin.langue.new")
     *
     *@param Request $request
     *
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function newType(Request $request)
    {
        $langue = new EntityLangue();
        $exist = false;
        $form = $this->createForm(LangueType::class, $langue);
        $form->handleRequest($request);
        $exist = false;
        $existLangue = $this->repository->findBy(['langue' => $form->get('langue')->getData()]);

        if (!empty($existLangue)) {
            $exist = true;
        } elseif ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($langue);
            $this->em->flush();
            $this->addFlash('success', 'Langue ajoutée avec succès');

            return $this->redirectToRoute('admin.langue.index');
        }

        return $this->render('admin/langue/newLangue.html.twig', [
            'langues' => $langue,
            'exist' => $exist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/langue/edit/{id}", name="admin.langue.edit", methods="GET|POST")
     *
     * @param EntityLangue $langue
     * @param Request      $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(EntityLangue $langue, Request $request)
    {
        $form = $this->createForm(LangueType::class, $langue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Langue modifiée avec succès');

            return $this->redirectToRoute('admin.langue.index');
        }

        return $this->render('admin/langue/editLangue.html.twig', [
            'langues' => $langue,
            'form' => $form->createView(), ]);
    }
}
