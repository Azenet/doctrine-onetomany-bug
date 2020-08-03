<?php

namespace App\DataFixtures;

use App\Entity\Bar;
use App\Entity\Baz;
use App\Entity\Foo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FooFixtures extends Fixture {
	public function load(ObjectManager $manager) {
		for ($x = 0; $x < 10; $x++) {
			$bars = random_int(5, 10);

			$foo = new Foo();
			$foo->setExpectedBars($bars);

			for ($i = 0; $i < $bars; $i++) {
				$bar = new Bar();
				$foo->addBar($bar);

				$manager->persist($bar);
			}

			$baz = new Baz();
			$foo->addBaz($baz);
			$manager->persist($baz);

			$baz = new Baz();
			$foo->addBaz($baz);
			$manager->persist($baz);

			$manager->persist($foo);
		}

		$manager->flush();
	}
}
