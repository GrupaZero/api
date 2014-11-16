<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\Content;
use League\Fractal\TransformerAbstract;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class ContentTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class ContentTransformer extends TransformerAbstract {

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * Transforms content entity
     *
     * @param Content|Array $content Content entity
     *
     * @throws \Exception Test
     * @return array
     */
    public function transform($content)
    {
        if (is_object($content) && get_class($content) == '\Gzero\Model\Content') {
            $content = $content->toArray();
        }
        return [
            'id'        => $content['id'],
            'category'  => $content['typeName'],
            'weight'    => $content['weight'],
            'isActive'  => $content['isActive'],
            'createdAt' => $content['createdAt'],
            'updatedAt' => $content['updatedAt']
        ];
    }
}
