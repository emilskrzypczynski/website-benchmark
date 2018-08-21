<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\Collection;


interface WebsiteInterface
{
    public function getId();

    public function setId($id): WebsiteInterface;

    public function getUrl(): ?string;

    public function setUrl(string $url): WebsiteInterface;

    public function getTests(): Collection;

    public function addTest(WebsiteTest $test): WebsiteInterface;

    public function removeTest(WebsiteTest $test): WebsiteInterface;
}