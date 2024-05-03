<?php

namespace App\DataFixtures;

use App\Entity\Stadium;
use App\Entity\User;
use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class AppFixtures extends Fixture
{
    /**
     * @var User[]
     */
    private $users = [];

    /**
     * @var Stadium[]
     */
    private$stadiums = [];

    private function makeFakeStadium(): Stadium
    {
        $faker = \Faker\Factory::create();

        $openTime = new DateTime();
        $closeTime = new DateTime();
        $openHour = $faker->numberBetween(0, 22);
        $closeHour = $faker->numberBetween($openHour, 23);
        $openTime->setTime($openHour, 0);
        $closeTime->setTime($closeHour, 0);

        $stadium = new Stadium();
        $stadium->setName($faker->name);
        $stadium->setOpeningTime($openTime);
        $stadium->setClosingTime($closeTime);
        $stadium->setPricePerHour($faker->randomFloat(2, 0, 100));
        $stadium->setCity($faker->city);
        $stadium->setZipCode($faker->numberBetween(2000, 4000));
        $stadium->setAddress($faker->address);
        $stadium->setHasShower($faker->boolean);
        $stadium->setHasPark($faker->boolean);

        return $stadium;
    }

    public function load(ObjectManager $manager): void
    {
        $faker  = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setPhoneNumber($faker->numberBetween(0, 99999999));
            if ($faker->boolean) {
                $user->setRoles(['ROLE_OWNER']);
                for ($j = 0; $j < 5; $j++) {
                    $stadium = $this->makeFakeStadium();
                    $stadium->setOwner($user);
                    $manager->persist($stadium);
                    $this->stadiums[] = $stadium;
                }
            }
            $this->users[] = $user;
            $manager->persist($user);
        }

        foreach ($this->stadiums as $stadium){
            for ($i = 0; $i < 20; $i++) {
                $reservation = new Reservation();
                $reservation->setStadium($stadium);
                $reservation->setUser($this->users[$faker->numberBetween(0, 9)]);
                $reservation->setDate($faker->dateTimeBetween('-3 day', '+10 day'));

                $startTime = new DateTime();
                $endTime = new DateTime();
                $startHour = $faker->numberBetween(0, 22);
                $endHour = $faker->numberBetween($startHour, 23);
                $startTime->setTime($startHour, 0);
                $endTime->setTime($endHour, 0);

                $reservation->setStartTime($startTime);
                $reservation->setEndTime($endTime);
                $manager->persist($reservation);
            }
        }

        $manager->flush();
    }
}
