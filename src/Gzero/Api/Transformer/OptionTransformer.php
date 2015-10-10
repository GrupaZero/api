<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\Option;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class LangTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class OptionTransformer extends AbstractTransformer {

    /**
     * Transforms option entity
     *
     * @param Array $option Content entity
     *
     * @throws \Exception Test
     * @return array
     */
    public function transform($option)
    {
        $option = $this->entityToArray('\Gzero\Entity\Option', $option);
        return $option;
    }
}
