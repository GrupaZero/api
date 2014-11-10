<?php namespace Gzero\Api;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class IsActiveFilter
 *
 * @package    Gzero\Api
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class IsActiveFilter extends SQLFilter {


    /**
     * Doctrine isActive filter
     *
     * @param ClassMetaData $targetEntity     ClassMetaData object
     * @param string        $targetTableAlias Table alias
     *
     * @return string
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        // Check if the entity implements the LocalAware interface
        if (!$targetEntity->reflClass->implementsInterface('LocaleAware')) {
            return "";
        }

        return $targetTableAlias . '.isActive = ' . $this->getParameter('isActive'); // getParameter applies quoting automatically
    }
}
