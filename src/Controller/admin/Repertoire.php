<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Repertoire as EntityRepertoire;
use App\Entity\AccordSearch as EntityAccordSearch;
use App\Form\AccordSearchType;
use App\Form\AccordType;
use App\Form\RepertoireType;
use App\Repository\RepertoireRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class Repertoire extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var RepertoireRepository
     */
    private $repository;

    public $boolAdmin = 0;

    /**
     * @var string
     */
    public function __construct(EntityManagerInterface $em, RepertoireRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/repertoire", name="admin.repertoire.index")
     *
     **@param Request $request
     *
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function index(?Request $request)
    {
        $user = $this->getUser();
        $boolAdmin = 0;
        if ($user != null) {
            foreach (($user->getRoles()) as $key => $value) {
                if ($value == 'ROLE_ADMIN') {
                    $boolAdmin = 1;
                }
            }
        }
        $accordSearch = new EntityAccordSearch();
        $form = $this->createForm(AccordSearchType::class, $accordSearch);
        $form->handleRequest($request);
        $listeRepertoire = $this->repository->findAll();

        if ($form->isSubmitted()) {
            $type = $form->get('type')->getData();
            $titre = $form->get('titre')->getData();
            $lieu = $form->get('lieu')->getData();
            $motCle = $form->get('motCle')->getData();
            $langue = $form->get('langue')->getData();
            $date = $form->get('dates')->getData();
            $resume = $form->get('resume')->getData();
            $result = $this->repository->findT($titre, $type, $langue, $lieu, $motCle, $date, $resume);

            if ($boolAdmin == 1) {
                return $this->render('admin/repertoire/show.html.twig', [
                'repertoires' => $result,
                'form' => $form->createView(), ]);
            } else {
                return $this->render('userSimple/recherche.html.twig', [
                    'repertoires' => $result,
                    'form' => $form->createView(), ]);
            }
        } else {
            if ($boolAdmin == 1) {
                return $this->render('admin/repertoire/show.html.twig', [
            'repertoires' => $listeRepertoire,
            'form' => $form->createView(), ]);
            } else {
                return $this->render('userSimple/recherche.html.twig', [
                    'repertoires' => $listeRepertoire,
                    'form' => $form->createView(), ]);
            }
        }
    }

    /**
     * @Route("/admin/repertoire/new",name="admin.repertoire.new")
     *
     *@param Request $request
     *
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function newType(Request $request)
    {
        $repertoire = new EntityRepertoire();
        $form = $this->createForm(RepertoireType::class, $repertoire);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('repertoire')->getData();
            dump('e');
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                //$safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                            $this->getParameter('upload_directory'),
                            $newFilename
                        );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $repertoire->setRepertoire($newFilename);
                $this->em->persist($repertoire);
                $this->em->flush();
            }

            return $this->redirectToRoute('admin.accord.index');
        }

        return $this->render('admin/repertoire/new.html.twig', [
            'repertoires' => $repertoire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/repertoire/edit/{id}", name="admin.repertoire.edit", methods="GET|POST")
     *
     * @param EntityRepertoire $repertoire
     * @param Request          $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(EntityRepertoire $repertoire, Request $request)
    {
        $form = $this->createForm(AccordType::class, $repertoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Modifie avec succes');

            return $this->redirectToRoute('admin.repertoire.index');
        }

        return $this->render('admin/repertoire/edit.html.twig', [
            'repertoires' => $repertoire,
            'form' => $form->createView(), ]);
    }
}
