<?php

namespace App\Controller\admin;

use App\Repository\SousTypeDocumentRepository;
use App\Entity\SousTypeDocument as EntitySousType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SousTypeDocType;
use Symfony\Component\Routing\Annotation\Route;

class SousType extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var SousTypeDocumentRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, SousTypeDocumentRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/soustype", name="admin.sousType.index")
     *
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $ListetypeDocuments = $this->repository->findAll();

        return $this->render('admin/sousType/showSousTypeDoc.html.twig', [
            'soustypes' => $ListetypeDocuments, ]);
    }

    /**
     * @Route("/admin/soustype/new",name="admin.SousTypeDoc.new")
     *
     *@param Request $request
     *
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function newType(Request $request)
    {
        $typeDocument = new EntitySousType();
        $form = $this->createForm(SousTypeDocType::class, $typeDocument);
        $form->handleRequest($request);
        $exist = false;
        $exisType = $this->repository->findBy(['sousType' => $form->get('sousType')->getData()]);

        if (!empty($exisType)) {
            $exist = true;
        } elseif ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($typeDocument);
            $this->em->flush();
            $this->addFlash('success', 'Sous type ajoutée avec succès');

            return $this->redirectToRoute('admin.sousType.index');
        }

        return $this->render('admin/sousType/newSousTypeDoc.html.twig', [
            'typeDocuments' => $typeDocument,
            'exist' => $exist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/soustype/edit/{id}", name="admin.soustype.edit", methods="GET|POST")
     *
     * @param EntitySousType $typeDocument
     * @param Request        $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(EntitySousType $typeDocument, Request $request)
    {
        $form = $this->createForm(SousTypeDocType::class, $typeDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Modifié avec succès');
            $this->addFlash('success', 'Sous type modifiée avec succès');

            return $this->redirectToRoute('admin.sousType.index');
        }

        return $this->render('admin/editTypeDoc.html.twig', [
            'typeDocument' => $typeDocument,
            'form' => $form->createView(), ]);
    }
}
