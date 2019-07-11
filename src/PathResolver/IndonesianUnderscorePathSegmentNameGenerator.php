<?php

namespace App\PathResolver; //namespace of location this file


use ApiPlatform\Core\Operation\PathSegmentNameGeneratorInterface;

use Doctrine\Common\Inflector\Inflector;


final class IndonesianUnderscorePathSegmentNameGenerator implements PathSegmentNameGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getSegmentName(string $name, bool $collection = true): string
    {
        $name = Inflector::tableize($name);

        //return $collection ? Inflector::pluralize($name) : $name; this add S in end of word
        return $name;
    }
}
