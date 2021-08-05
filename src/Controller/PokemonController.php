<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Form\AddPokemonType;
use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokemonController extends AbstractController
{
    /**
     * @Route("/add_pokemon", name="add_pokemon")
     * @Security("is_granted('ROLE_ADMIN')", is_granted
     */
    public function ajoutPokemon(Request $request, EntityManagerInterface $manager)
    {
        $pokemon = new Pokemon();
        $form = $this->createForm(AddPokemonType::class, $pokemon );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $imageFile = $form->get('image')->getData();

            $nomImage = date("YmdHis") . "-" . $imageFile->getClientOriginalName();
            $imageFile->move(
                $this->getParameter('image_pokemon'),
                $nomImage
            );

            $pokemon->setImage($nomImage);

            $manager->persist($pokemon);
            $manager->flush();
            $this->addFlash('success', 'Pokemon ajouté!');

            return $this->redirectToRoute('listpokemon');
        }
            


        return $this->render('pokemon/addpokemon.html.twig', [
            'formPokemon' => $form->createView(),
            'pokemon'=>$pokemon
        ]);
    }


    /**
     * @Route("/listpokemon", name="listpokemon")
     */
    public function listPokemon(PokemonRepository $pokemonRepository)
    {
        $pokemons = $pokemonRepository->findAll();


        return $this->render('pokemon/listpokemon.html.twig',[
            'pokemons'=> $pokemons
        ]);
    }


    /**
     * @Route("/updatepokemon/{id}", name="updatepokemon")
     */
    public function updatePokemon(Pokemon $pokemon, Request $request, EntityManagerInterface $manager)
    {

        $form = $this->createForm(AddPokemonType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()):

            if ($pokemon->getImage()):
                //unlink('image_pokemon')."/". $pokemon->getImage();

                $imageFile = $form->get('editImage')->getData();

                $nomImage = date("YmdHis") . "-" . $imageFile->getClientOriginalName();
                $imageFile->move(
                    $this->getParameter('image_pokemon'),
                    $nomImage
                );



                $pokemon->setImage($nomImage);

                $manager->persist($pokemon);
                $manager->flush();
                $this->addFlash('success', 'Pokemon modifié!');

                return $this->redirectToRoute('listpokemon');


            endif;
            endif;

            return $this->render('pokemon/editpokemon.html.twig', [
                'formPokemon' => $form->createView()
            ]);


    }

    /**
     * @Route("/deletepokemon/{id}", name="deletepokemon")
     */
    public function deletePokemon(EntityManagerInterface $manager, Pokemon $pokemon)
    {
        $manager->remove($pokemon);
        $manager->flush();
        $this->addFlash('success', 'Pokemon supprimé!');

        return $this->redirectToRoute('listpokemon', [

        ]);
    }
}
