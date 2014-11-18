<?php namespace Gzero\Api;

use \League\Fractal\Serializer\ArraySerializer as LeagueSerializer;

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
