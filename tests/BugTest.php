<?php

namespace App\Tests;

use App\Entity\Foo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BugTest extends KernelTestCase {
	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	protected function setUp(): void {
		$kernel = self::bootKernel();

		$this->em = $kernel->getContainer()
			->get('doctrine')
			->getManager();
	}

	// passes
	public function testChildCountBase() {
		$this->em->clear();

		$res = $this->em->createQueryBuilder()
			->select('foo')
			->from(Foo::class, 'foo')
			->leftJoin('foo.bars', 'bar')
			->addSelect('bar')
			->innerJoin('foo.bazs', 'baz')
			->addSelect('baz')
			->getQuery()
			->getResult();

		self::assertNotNull($res, 'Fixtures not loaded');
		self::assertCount(10, $res, 'Fixtures invalid');

		foreach ($res as $foo) {
			self::assertCount($foo->getExpectedBars(), $foo->getBars(), 'BUG: fetched only the first joined row on bar');
			self::assertCount(2, $foo->getBazs(), 'BUG: fetched only the first joined row on baz');
		}
	}

	// fails
	public function testChildCount() {
		$this->em->clear();

		$this->em->createQueryBuilder()
			->select('foo')
			->from(Foo::class, 'foo')
			->leftJoin('foo.bars', 'bar')
			->addSelect('bar')
			->innerJoin('foo.bazs', 'baz')
			->addSelect('baz')
			->orderBy('COUNT(DISTINCT bar.id)', 'DESC')
			->getQuery()
			->getResult();

		$res = $this->em->createQueryBuilder()
			->select('foo')
			->from(Foo::class, 'foo')
			->leftJoin('foo.bars', 'bar')
			->addSelect('bar')
			->innerJoin('foo.bazs', 'baz')
			->addSelect('baz')
			->getQuery()
			->getResult();

		self::assertNotNull($res, 'Fixtures not loaded');
		self::assertCount(10, $res, 'Fixtures invalid');

		foreach ($res as $foo) {
			self::assertCount($foo->getExpectedBars(), $foo->getBars(), 'BUG: fetched only the first joined row on bar');
			// ^ fails, count($foo->getBars()) === 1

			self::assertCount(2, $foo->getBazs(), 'BUG: fetched only the first joined row on baz');
			// ^ not reached but would fail the same way, count($foo->getBazs()) === 1
		}
	}

	// passes
	public function testChildCountWithClear() {
		$this->em->clear();

		$this->em->createQueryBuilder()
			->select('foo')
			->from(Foo::class, 'foo')
			->leftJoin('foo.bars', 'bar')
			->addSelect('bar')
			->innerJoin('foo.bazs', 'baz')
			->addSelect('baz')
			->orderBy('COUNT(DISTINCT bar.id)', 'DESC')
			->getQuery()
			->getResult();

		$this->em->clear();

		$res = $this->em->createQueryBuilder()
			->select('foo')
			->from(Foo::class, 'foo')
			->leftJoin('foo.bars', 'bar')
			->addSelect('bar')
			->innerJoin('foo.bazs', 'baz')
			->addSelect('baz')
			->getQuery()
			->getResult();

		self::assertNotNull($res, 'Fixtures not loaded');
		self::assertCount(10, $res, 'Fixtures invalid');

		foreach ($res as $foo) {
			self::assertCount($foo->getExpectedBars(), $foo->getBars(), 'BUG: fetched only the first joined row on bar');
			self::assertCount(2, $foo->getBazs(), 'BUG: fetched only the first joined row on baz');
		}
	}
}
