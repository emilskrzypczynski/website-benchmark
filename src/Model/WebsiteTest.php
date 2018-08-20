<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Model;


class WebsiteTest implements WebsiteTestInterface
{
    /**
     * @var mixed|null
     */
    protected $id;

    /**
     * @var int|null
     */
    protected $status;

    /**
     * @var float|null
     */
    protected $loadTime;

    /**
     * @var \DateTimeInterface|null
     */
    protected $createdAt;

    /**
     * @var WebsiteInterface|null
     */
    protected $website;

    /**
     * @var BenchmarkInterface|null
     */
    protected $benchmark;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }


    public function setId($id): WebsiteTestInterface
    {
        $this->id = $id;
        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): WebsiteTestInterface
    {
        $this->status = $status;
        return $this;
    }

    public function getLoadTime(): ?float
    {
        return $this->loadTime;
    }

    public function setLoadTime(?float $loadTime): WebsiteTestInterface
    {
        $this->loadTime = $loadTime;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): WebsiteTestInterface
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getWebsite(): ?WebsiteInterface
    {
        return $this->website;
    }

    public function setWebsite(?WebsiteInterface $website): WebsiteTestInterface
    {
        $this->website = $website;

        return $this;
    }

    public function getBenchmark(): ?BenchmarkInterface
    {
        return $this->benchmark;
    }

    public function setBenchmark(?BenchmarkInterface $benchmark): WebsiteTestInterface
    {
        $this->benchmark = $benchmark;

        return $this;
    }
}