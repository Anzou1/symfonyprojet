<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Comment;
use App\Entity\Articles;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)

    
    {
       
            $faker = \Faker\Factory::create('fr_FR');

            // ceation de 3 catégories
            for($i = 1; $i <= 3;$i++)
            {
               $categorie = new Category;
               
               $categorie->setTitle($faker->sentence())
                         ->setDescription($faker->paragraph());
                         
                         $manager->persist($categorie);

                         //creation de 4 à 6 articles
                         for($j = 1; $j <= mt_rand(4,6); $j++)
                         {
                             $article = new Articles;

                             $content = '<p>' .join($faker->paragraphs(5), '</p><p>') . '</p>';

                             $article->setTitle($faker->sentence())
                                     ->setContent($content)
                                     ->setImage($faker->imageUrl())
                                     ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                                     ->setCategory($categorie);


                            $manager->persist($article);
                            
                            // creation de 4 à 10 commentaire
                            for($k = 1; $k <= mt_rand(4,10); $k++)
                            {
                                $comment = new Comment;

                                $content = '<p>' .join($faker->paragraphs(2), '</p><p>') . '</p>';

                                $now = new \DateTime;
                                $interval = $now->diff($article->getCreatedAt());
                                $days = $interval->days;
                                $minimum = '-' .$days . 'days'; //- 100 days

                                $comment->setAuthor($faker->name)
                                        ->setContent($content)
                                        ->setCreatedAt($faker->dateTimeBetween($minimum))
                                        ->setArticle($article);

                                $manager->persist($comment);        
                            }
                         }
            }

            $manager->flush();
    }
    
}
