<?php namespace Gzero\Api\Transformer;

use League\Fractal\TransformerAbstract;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class AbstractTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class AbstractTransformer extends TransformerAbstract {

    /**
     * Return entity transformed to array
     *
     * @param string $class  Entity class
     * @param mixed  $object Entity object or array
     *
     * @return array
     */
    protected function entityToArray($class, $object)
    {
        if (is_object($object) && get_class($object) == $class) {
            $object = $object->toArray();
        }
        return $object;
    }
}
