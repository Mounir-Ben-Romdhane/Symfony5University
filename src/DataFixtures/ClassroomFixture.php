<?php

namespace App\DataFixtures;

use App\Entity\Classroom;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClassroomFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    
        $Classroom1 = new Classroom();
        $Classroom1->setName("2A28");
        $Classroom2 = new Classroom();
        $Classroom2->setName("3B16");
        $Classroom3 = new Classroom();
        $Classroom3->setName("5A12");
        $Classroom4 = new Classroom();
        $Classroom4->setName("3A26");
        $Classroom5 = new Classroom();
        $Classroom5->setName("3P11");
        $Classroom6 = new Classroom();
        $Classroom6->setName("3A1");
        $Classroom7 = new Classroom();
        $Classroom7->setName("2A28");
        $Classroom8 = new Classroom();
        $Classroom8->setName("3B16");
        
        $manager->persist($Classroom1); 
        $manager->persist($Classroom2); 
        $manager->persist($Classroom3); 
        $manager->persist($Classroom4); 
        $manager->persist($Classroom5); 
        $manager->persist($Classroom6); 
        $manager->persist($Classroom7); 
        $manager->persist($Classroom8); 
        
        $manager->flush();
    }
}
