<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeFormType;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_user")
     */
    public function table_user(UserRepository  $userRepository)
    {

        $users =  $userRepository->findAll();

        return $this->render('back/admin.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/addtype", name="addtype")
     */
    public function addtype(Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(TypeFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $type = new Type();
            //dd($form->get('type'));
            $type->setType($form->get('type')->getData());

            $manager->persist($type);
            $manager->flush();

            $this->addFlash('success', 'Le type a bien été créé');

            return $this->redirectToRoute('addtype');
        }


        return $this->render('back/addtype.html.twig', [
            'typeForm'=> $form->createView()
        ]);

    }

    /**
     * @Route("/admin/listtype", name="listtype")
     */
    public function listtype(Request $request, TypeRepository $typeRepository)
    {
        $types = $typeRepository->findAll();



        return $this->render('back/listtype.html.twig', [
            'types'=> $types
        ]);
    }
}
