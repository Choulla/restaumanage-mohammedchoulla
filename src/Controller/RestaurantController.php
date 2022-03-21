<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Restaurant;
use App\Entity\RestaurantPicture;
use Doctrine\Persistence\ManagerRegistry;
use MongoDB\Driver\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{

    /**
     * @Route("/restaurants", name="restaurant.index" , methods={"GET","POST"})
     */
    public function restaurants(ManagerRegistry $doctrine)
    {
        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
        $restaurantsPicture = $doctrine->getRepository(RestaurantPicture::class)->findAll();
        return new Response(
            $this->renderView(
                "restaurant/restaurants.html.twig",
                [
                    "restaurants"=>$restaurants,
                    "restaurantsPicture"=>$restaurantsPicture
                ]
            )
        );
    }
    /**
     * @Route("/restaurant/new",name="restaurant.new", methods={"GET"})
     */
    public function new(ManagerRegistry $doctrine)
    {
        //get all cities
        $cities = $doctrine->getRepository(City::class)->findAll();

        return new Response(
            $this->renderView(
                "restaurant/index.html.twig",
                [
                    "cities" => $cities,
                ]
            )
        );
    }

    /**
     * @Route("/restaurant",name="restaurant.name" , methods={"POST"})
     */
    public function create(Request $request, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();

        $city = $doctrine->getRepository(City::class)->find($request->get("cityId"));
        $restaurant = new Restaurant();
        $restaurant->setName($request->get("name"));
        $restaurant->setDescription($request->get("description"));
        $restaurant->setCreatedAt(new \DateTime());

        $restaurant->setCityId($city);
        $entityManager->persist($restaurant);
        $entityManager->flush();

        $image = $request->files->get('picture');
        $imageName = uniqid().".".$image->guessExtension();
        $image->move($this->getParameter("images_dir"), $imageName);
        $restaurantPicture = new RestaurantPicture();
        $restaurantPicture->setFilename($imageName);
        $restaurantPicture->setRestaurantId($restaurant);

        $entityManager->persist($restaurantPicture);
        $entityManager->flush();
        $this->addFlash("success", "Operation Successfully Completed");

        return $this->redirectToRoute("restaurant.index");
    }

    /**
     * @Route("/restaurants/search/form",name="restaurant.search.form")
     */
    public function searchRestaurantForm()
    {
        return new Response(
            $this->renderView("restaurant/search.html.twig")
        );
    }

    /**
     * @Route("/restaurants/search",name="restaurant.search")
     */
    public function searchRestaurant(Request $request, ManagerRegistry $doctrine)
    {
        //dd($request->query->get("restaurantName"));
        $restaurant = $doctrine->getRepository(Restaurant::class)->findOneBy(
            [
                "name" => $request->query->get("restaurantName"),
            ]
        );
        if ($restaurant != null) {
            $this->addFlash("success", "restaurant exist");

            return $this->redirectToRoute("restaurant.search.form");
        } else {
            $this->addFlash("danger", "restaurant does not exist");

            return $this->redirectToRoute("restaurant.search.form");
        }
    }

    /**
     * @Route("/restaurants/{restaurant}",methods={"GET"})
     * NOTE: we can check by this url (get) or by form (route implemented above) if restaurant exist or not
     */
    public function restaurant($restaurant, ManagerRegistry $doctrine)
    {
        $restaurant = $doctrine->getRepository(Restaurant::class)->findOneBy(
            [
                "name" => $restaurant,
            ]
        );
        if ($restaurant != null) {
            $this->addFlash("success", "restaurant exist");

            return $this->redirectToRoute("restaurant.search.form");
        } else {
            $this->addFlash("danger", "restaurant does not exist");

            return $this->redirectToRoute("restaurant.search.form");
        }
    }

    /**
     * @Route("/query/first", name="query.first")
     * les 6 derniers restaurants créés
     */
    public function derniersRestaurantsCrees(ManagerRegistry $doctrine){
        $restaurants = $doctrine->getRepository(Restaurant::class)
            ->lastCreatedRestaurants(6);
        $restaurantsPicture = $doctrine->getRepository(RestaurantPicture::class)->findAll();
        return new Response(
            $this->renderView(
                "queries/first.html.twig",
                [
                    "restaurants"=>$restaurants,
                    "restaurantsPicture"=>$restaurantsPicture
                ]
            )
        );
    }

    /**
     * @Route("/query/two", name="query.two")
     * Afficher la valeur moyenne de la note d'un restaurant
     */
    public function valeurMoyenneRestaurant(ManagerRegistry $doctrine){
        $restaurantAvgValue = $doctrine->getRepository(Restaurant::class)
            ->avgValueOfRestaunat();
        return new Response(
            $this->renderView(
                "queries/two.html.twig",
                [
                    "restaurantAvgValue"=>$restaurantAvgValue
                ]
            )
        );
    }

    /**
     * @Route("/query/three", name="query.three")
     * Afficher les 3 top meilleurs restaurants
     */
    public function top3Restaurants(ManagerRegistry $doctrine){
        $top3restaurants = $doctrine->getRepository(Restaurant::class)
            ->theThreebestRestaurants();
        return new Response(
            $this->renderView(
                "queries/three.html.twig",
                [
                    "top3restaurants"=>$top3restaurants
                ]
            )
        );
    }

    /**
     * @Route("/query/four", name="query.four")
     * Lister les restaurants et leurs détails (review, city..)
     */
    public function restaurantsDetails(ManagerRegistry $doctrine):Response{
        $restaurants = $doctrine->getRepository(Restaurant::class)
            ->restaurantsDetails();
        dd($restaurants);
    }

    /**
     * @Route("/query/five", name="query.five")
     * classer les restaurants pas voté
     */
    public function restaurantPasVote(ManagerRegistry $doctrine){
        $restaurants = $doctrine->getRepository(Restaurant::class)
            ->restaurantNotVoted();
        return new Response(
            $this->renderView(
                "queries/five.html.twig",
                [
                    "restaurants"=>$restaurants
                ]
            )
        );
    }

}
