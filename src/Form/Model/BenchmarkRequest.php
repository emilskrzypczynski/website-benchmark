<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);


namespace App\Form\Model;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


class BenchmarkRequest
{
    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="global.url.blank")
     * @Assert\Length(max="180")
     * @Assert\Regex(
     *     pattern="/^((https?):\/\/)?(www.)?[a-z0-9]+\.[a-z]+(\/[a-zA-Z0-9#]+\/?)*$/",
     *     message="global.url.invalid"
     * )
     */
    private $website;

    /**
     * @var ArrayCollection
     *
     * @Assert\Count(
     *     min="1",
     *     max="10",
     *     minMessage="benchmark.competitors.min",
     *     maxMessage="benchmark.competitors.max"
     * )
     *
     * @Assert\All({
     *      @Assert\Regex(
     *          pattern="/^((https?):\/\/)?(www.)?[a-z0-9]+\.[a-z]+(\/[a-zA-Z0-9#]+\/?)*$/",
     *          message="global.url.invalid.with_value"
     *      ),
     *      @Assert\Expression(
     *          "value != this.getWebsite()",
     *          message="benchmark.competitors.website_duplication"
     *      )
     * })
     */
    private $competitors;


    public function __construct()
    {
        $this->competitors = new ArrayCollection();
    }

    /**
     * @return null|string
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param null|string $website
     * @return BenchmarkRequest
     */
    public function setWebsite(?string $website): BenchmarkRequest
    {
        $this->website = $website;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCompetitors(): ArrayCollection
    {
        return $this->competitors;
    }

    /**
     * @param ArrayCollection $competitors
     * @return BenchmarkRequest
     */
    public function setCompetitors(ArrayCollection $competitors): BenchmarkRequest
    {
        $this->competitors = $competitors;
        return $this;
    }
}