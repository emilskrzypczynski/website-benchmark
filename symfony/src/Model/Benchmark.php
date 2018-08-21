<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


class Benchmark implements BenchmarkInterface
{
    /**
     * @var mixed|null
     */
    protected $id;

    /**
     * @var WebsiteTestInterface|null
     */
    protected $websiteTest;

    /**
     * @var Collection|WebsiteTestInterface[]
     */
    protected $competitorTests;

    /**
     * @var \DateTimeInterface|null
     */
    protected $createdAt;


    public function __construct()
    {
        $this->competitorTests = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): BenchmarkInterface
    {
        $this->id = $id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): BenchmarkInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getWebsiteTest(): ?WebsiteTestInterface
    {
        return $this->websiteTest;
    }

    public function setWebsiteTest(?WebsiteTestInterface $websiteTest): BenchmarkInterface
    {
        $this->websiteTest = $websiteTest;

        return $this;
    }

    public function getCompetitorTests(): Collection
    {
        return $this->competitorTests;
    }

    public function addCompetitorTest(WebsiteTestInterface $competitorTest): BenchmarkInterface
    {
        if (!$this->competitorTests->contains($competitorTest)) {
            $this->competitorTests[] = $competitorTest;
            $competitorTest->setBenchmark($this);
        }

        return $this;
    }

    public function removeCompetitorTest(WebsiteTestInterface $competitorTest): BenchmarkInterface
    {
        if ($this->competitorTests->contains($competitorTest)) {
            $this->competitorTests->removeElement($competitorTest);
            // set the owning side to null (unless already changed)
            if ($competitorTest->getBenchmark() === $this) {
                $competitorTest->setBenchmark(null);
            }
        }

        return $this;
    }
}