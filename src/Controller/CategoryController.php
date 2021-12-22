<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @route("/admin/creer-category", name="create_category", methods={"GET|POST"})
     */
    public function createCategory(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager) {
        $category = new Category();

        $form = $this->createForm(CategoryType::class,$category)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $category->setAlias($slugger->slug($category->getName()));

            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie est bien crée');
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('dashboard/form_category.html.twig',[
            'form' => $form->createView()
        ]);
    }
}