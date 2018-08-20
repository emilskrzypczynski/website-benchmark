<?php
/**
 * @author: Emil Skrzypczyński <emilskrzypczynski09 at gmail.com>
 */

declare(strict_types=1);

namespace App\Form\DataTransformer;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CompetitorsTransformer implements DataTransformerInterface
{
    /**
     * @param mixed $competitors
     * @return string
     */
    public function transform($competitors): string
    {
        if ($competitors instanceof ArrayCollection) {
            return '';
        }

        return implode(PHP_EOL, $competitors);
    }

    /**
     * @param mixed $string
     * @return Collection
     */
    public function reverseTransform($string): Collection
    {
        if (null === $string) {
            return new ArrayCollection();
        }

        $array = explode(PHP_EOL, $string);

        $filtered = array_unique(array_map('trim', $array));

        return new ArrayCollection($filtered);
    }
}