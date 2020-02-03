<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AccordsRepository;
use App\Entity\Accords as EntityAccord;
use App\Form\AccordType;

class Accord extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var AccordsRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, AccordsRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/accord", name="admin.accord.index")
     *
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $listeAccord = $this->repository->findAll();

        return $this->render('admin/accord/show.html.twig', [
            'accords' => $listeAccord,
            'nombre' => count($listeAccord), ]);
    }

    /**
     * @Route("/admin/accord/new",name="admin.accord.new")
     *
     *@param Request $request
     *
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function newType(Request $request)
    {
        $accord = new EntityAccord();
        $form = $this->createForm(AccordType::class, $accord);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($accord);
            $this->em->flush();

            return $this->redirectToRoute('admin.accord.index');
        }

        return $this->render('admin/accord/new.html.twig', [
            'accords' => $accord,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/accord/edit/{id}", name="admin.accord.edit", methods="GET|POST")
     *
     * @param EntityAccord $accord
     * @param Request      $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(EntityAccord $accord, Request $request)
    {
        $form = $this->createForm(AccordType::class, $accord);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Modifie avec succes');

            return $this->redirectToRoute('admin.accord.index');
        }

        return $this->render('admin/accord/editLangue.html.twig', [
            'accords' => $accord,
            'form' => $form->createView(), ]);
    }
}
