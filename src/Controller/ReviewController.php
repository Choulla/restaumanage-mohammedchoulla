<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    /**
     * @Route("/review", name="review.index")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
        $users = $doctrine->getRepository(User::class)->findAll();

        return $this->render(
            'review/index.html.twig',
            ["restaurants" => $restaurants, "users" => $users]
        );
    }

    /**
     * @Route("/review/store",name="review.store")
     */
    public function addReview(Request $request,ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $review = new Review();
        $review->setMessage($request->get("message"));
        $review->setRating($request->get("rating"));
        $review->setCreatedAt(new \DateTime());
        $restaurant = $doctrine->getRepository(Restaurant::class)->find($request->get("restaurantId"));
        $user = $doctrine->getRepository(User::class)->find($request->get("userId"));
        $review->setRestaurantId($restaurant);
        $review->setUserId($user);
        //dd($review);
        $entityManager->persist($review);
        $entityManager->flush();
        $this->addFlash("success","Operation Successfully Completed");
        return $this->redirectToRoute("review.show");
    }

    /**
     * @Route("/review/show",name="review.show")
     */
    public function show(ManagerRegistry $doctrine){
        $reviews = $doctrine->getRepository(Review::class)->findAll();
        return new Response(
            $this->renderView(
                "review/show.html.twig",
                [
                    "reviews"=>$reviews
                ]
            )
        );
    }

}
