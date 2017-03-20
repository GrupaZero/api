<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\Route;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class RouteTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class RouteTransformer extends AbstractTransformer {

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'translations'
    ];

    /**
     * Transforms route entity
     *
     * @param Route|array $route route entity
     *
     * @return array
     */
    public function transform($route)
    {
        $route = $this->entityToArray(Route::class, $route);
        return [
            'id'        => (int) $route['id'],
            'createdAt' => $route['created_at'],
            'updatedAt' => $route['updated_at']
        ];
    }

    /**
     * Include Translations
     *
     * @param Route $route Translation
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeTranslations($route)
    {
        $translations = $route->translations;
        return $this->collection($translations, new RouteTranslationTransformer());
    }
}
