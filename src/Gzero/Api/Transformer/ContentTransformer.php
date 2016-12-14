<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\Content;

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
class ContentTransformer extends AbstractTransformer {

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'route',
        'author',
        'children',
        'translations'
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * Transforms content entity
     *
     * @param Content|array $content Content entity
     *
     * @return array
     */
    public function transform($content)
    {
        $content = $this->entityToArray(Content::class, $content);
        return [
            'id'               => $this->setNullableValue($content['id']),
            'parentId'         => $this->setNullableValue($content['parent_id']),
            'type'             => $content['type'],
            'theme'            => $content['theme'],
            'weight'           => (int) $content['weight'],
            'rating'           => (int) $content['rating'],
            'visits'           => (int) $content['visits'],
            'isActive'         => (bool) $content['is_active'],
            'isOnHome'         => (bool) $content['is_on_home'],
            'isCommentAllowed' => (bool) $content['is_comment_allowed'],
            'isPromoted'       => (bool) $content['is_promoted'],
            'isSticky'         => (bool) $content['is_sticky'],
            'path'             => $this->buildPath($content['path']),
            'publishedAt'      => $content['published_at'],
            'createdAt'        => $content['created_at'],
            'updatedAt'        => $content['updated_at']
        ];
    }

    /**
     * Include Children
     *
     * @param Content $content Translation
     *
     * @return \League\Fractal\ItemResource|null
     */
    public function includeChildren(Content $content)
    {
        if ($content->isChildrenLoaded()) {
            return $this->collection($content->children, new ContentTransformer()); // We don't want LAZY LOADING !
        }
        return null;
    }

    /**
     * Include Translations
     *
     * @param Content $content Translation
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeTranslations(Content $content)
    {
        $translations = $content->translations;
        return $this->collection($translations, new ContentTranslationTransformer());
    }

    /**
     * Include Route
     *
     * @param Content $content Route
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeRoute(Content $content)
    {
        $route = $content->route;
        return (!empty($route)) ? $this->item($route, new RouteTransformer()) : null;
    }

    /**
     * Include Author
     *
     * @param Content $content User
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeAuthor(Content $content)
    {
        $author = $content->author;
        return (!empty($author)) ? $this->item($author, new UserTransformer()) : null;
    }

    /**
     * Returns array of path ids as integers
     *
     * @param Content $path path to explode
     *
     * @return Array extracted path
     */
    private function buildPath($path)
    {
        $result = [];
        foreach (explode('/', $path) as $value) {
            if (!empty($value)) {
                $result[] = (int) $value;
            }
        }
        return $result;
    }

    /**
     * Returns integer value or null
     *
     * @param int $value to evaluate
     *
     * @return int|null
     */
    private function setNullableValue($value)
    {
        return ($value !== null) ? (int) $value : null;
    }
}
