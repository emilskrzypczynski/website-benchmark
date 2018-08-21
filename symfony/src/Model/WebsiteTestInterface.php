<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Model;


interface WebsiteTestInterface
{
    public function getId();

    public function setId($id): WebsiteTestInterface;

    public function getStatus(): ?int;

    public function setStatus(?int $status): WebsiteTestInterface;

    public function getLoadTime(): ?float;

    public function setLoadTime(?float $loadTime): WebsiteTestInterface;

    public function getCreatedAt(): ?\DateTimeInterface;

    public function setCreatedAt(?\DateTimeInterface $createdAt): WebsiteTestInterface;

    public function getWebsite(): ?WebsiteInterface;

    public function setWebsite(?WebsiteInterface $website): WebsiteTestInterface;

    public function getBenchmark(): ?BenchmarkInterface;

    public function setBenchmark(?BenchmarkInterface $benchmark): WebsiteTestInterface;
}