<?php

namespace App\Entity;

use App\Repository\FooRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FooRepository::class)
 */
class Foo {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\OneToMany(targetEntity=Bar::class, mappedBy="foo", orphanRemoval=true)
	 */
	private $bars;

	/**
	 * @ORM\OneToMany(targetEntity=Baz::class, mappedBy="foo")
	 */
	private $bazs;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $expectedBars;

	public function __construct() {
		$this->bars = new ArrayCollection();
		$this->bazs = new ArrayCollection();
	}

	public function getId(): ?int {
		return $this->id;
	}

	/**
	 * @return Collection|Bar[]
	 */
	public function getBars(): Collection {
		return $this->bars;
	}

	public function addBar(Bar $bar): self {
		if (!$this->bars->contains($bar)) {
			$this->bars[] = $bar;
			$bar->setFoo($this);
		}

		return $this;
	}

	public function removeBar(Bar $bar): self {
		if ($this->bars->contains($bar)) {
			$this->bars->removeElement($bar);
			// set the owning side to null (unless already changed)
			if ($bar->getFoo() === $this) {
				$bar->setFoo(null);
			}
		}

		return $this;
	}

	/**
	 * @return Collection|Baz[]
	 */
	public function getBazs(): Collection {
		return $this->bazs;
	}

	public function addBaz(Baz $baz): self {
		if (!$this->bazs->contains($baz)) {
			$this->bazs[] = $baz;
			$baz->setFoo($this);
		}

		return $this;
	}

	public function removeBaz(Baz $baz): self {
		if ($this->bazs->contains($baz)) {
			$this->bazs->removeElement($baz);
			// set the owning side to null (unless already changed)
			if ($baz->getFoo() === $this) {
				$baz->setFoo(null);
			}
		}

		return $this;
	}

	public function getExpectedBars(): ?int {
		return $this->expectedBars;
	}

	public function setExpectedBars(int $expectedBars): self {
		$this->expectedBars = $expectedBars;

		return $this;
	}
}
