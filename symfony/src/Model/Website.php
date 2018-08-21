<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


class Website implements WebsiteInterface
{
    /**
     * @var mixed|null
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $url;

    /**
     * @var Collection|WebsiteTestInterface[]
     */
    protected $tests;


    public function __construct()
    {
        $this->tests = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): WebsiteInterface
    {
        $this->id = $id;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): WebsiteInterface
    {
        $this->url = $url;

        return $this;
    }

    public function getTests(): Collection
    {
        return $this->tests;
    }

    public function addTest(WebsiteTest $test): WebsiteInterface
    {
        if (!$this->tests->contains($test)) {
            $this->tests[] = $test;
            $test->setWebsite($this);
        }

        return $this;
    }

    public function removeTest(WebsiteTest $test): WebsiteInterface
    {
        if ($this->tests->contains($test)) {
            $this->tests->removeElement($test);
            // set the owning side to null (unless already changed)
            if ($test->getWebsite() === $this) {
                $test->setWebsite(null);
            }
        }

        return $this;
    }
}