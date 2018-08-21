<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\Collection;


interface BenchmarkInterface
{
    public function getId();

    public function setId($id): BenchmarkInterface;

    public function getCreatedAt(): ?\DateTimeInterface;

    public function setCreatedAt(\DateTimeInterface $createdAt): BenchmarkInterface;

    public function getWebsiteTest(): ?WebsiteTestInterface;

    public function setWebsiteTest(?WebsiteTestInterface $websiteTest): BenchmarkInterface;

    public function getCompetitorTests(): Collection;

    public function addCompetitorTest(WebsiteTestInterface $competitorTest): BenchmarkInterface;

    public function removeCompetitorTest(WebsiteTestInterface $competitorTest): BenchmarkInterface;
}