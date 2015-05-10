<?php namespace Gzero\Api;

use \League\Fractal\Serializer\ArraySerializer as LeagueSerializer;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class ArraySerializer
 *
 * @package    Gzero\Api
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class ArraySerializer extends LeagueSerializer {

    /**
     * WE DON'T ADD ANY ADDITIONAL KEY TO STORE COLLECTIONS
     * Serialize a collection
     *
     * @param string $resourceKey Resource key
     * @param array  $data        Serialized data
     *
     * @SuppressWarnings("unused")
     *
     * @return array
     **/
    public function collection($resourceKey, array $data)
    {
        return $data;
    }

    //@codingStandardsIgnoreStart

    /**
     * WE DISABLED ALL ADDITIONAL FIELDS IN SERIALIZER
     * Serialize the meta
     *
     * @param array $meta Meta data
     *
     * @SuppressWarnings("unused")
     *
     * @return array
     **/
    public function meta(array $meta)
    {
        return [];
    }

    //@codingStandardsIgnoreEnd
}
