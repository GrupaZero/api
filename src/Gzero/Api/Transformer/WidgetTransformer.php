<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\Widget;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class WidgetTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class WidgetTransformer extends AbstractTransformer {

    /**
     * Transforms widget entity
     *
     * @param Widget|array $widget Widget entity
     *
     * @return array
     */
    public function transform($widget)
    {
        $widget = $this->entityToArray(Widget::class, $widget);
        return [
            'id'          => (int) $widget['id'],
            'name'        => $widget['name'],
            'args'        => array_camel_case_keys($widget['args']),
            'isActive'    => (bool) $widget['is_active'],
            'isCacheable' => (bool) $widget['is_cacheable'],
            'createdAt'   => $widget['created_at'],
            'updatedAt'   => $widget['updated_at'],
        ];
    }
}
