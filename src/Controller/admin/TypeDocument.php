<?php

namespace App\Controller\admin;

use App\Entity\TypeDocument as EntityTypeDocument;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\TypeDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TypeDocumentType;
use Symfony\Component\Routing\Annotation\Route;

class TypeDocument extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var TypeDocumentRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, TypeDocumentRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/typedocument/typeDoc", name="admin.typeDoc.index")
     *
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $ListetypeDocuments = $this->repository->findAll();

        return $this->render('admin/showTypeDoc.html.twig', [
            'typeDocuments' => $ListetypeDocuments, ]);
    }

    /**
     * @Route("/admin/typedocument/new",name="admin.typeDoc.new")
     *
     *@param Request $request
     *
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function newType(Request $request)
    {
        $typeDocument = new EntityTypeDocument();
        $form = $this->createForm(TypeDocumentType::class, $typeDocument);
        $form->handleRequest($request);
        $exist = false;
        $exisType = $this->repository->findBy(['type' => $form->get('type')->getData()]);

        if (!empty($exisType)) {
            $exist = true;
        } elseif ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($typeDocument);
            $this->em->flush();
            $this->addFlash('success', 'Type de document ajoutée avec succès');

            return $this->redirectToRoute('admin.typeDoc.index');
        }

        return $this->render('admin/newTypeDoc.html.twig', [
            'typeDocuments' => $typeDocument,
            'exist' => $exist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/typedocument/edit/{id}", name="admin.typeDoc.edit", methods="GET|POST")
     *
     * @param TypeDocument $typeDocument
     * @param Request      $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(EntityTypeDocument $typeDocument, Request $request)
    {
        $form = $this->createForm(TypeDocumentType::class, $typeDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Modifie avec succes');
            $this->addFlash('success', 'Type de document modifiée avec succès');

            return $this->redirectToRoute('admin.typeDoc.index');
        }

        return $this->render('admin/editTypeDoc.html.twig', [
            'typeDocument' => $typeDocument,
            'form' => $form->createView(), ]);
    }
}
