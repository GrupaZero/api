<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\Block;
use ReflectionClass;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class BlockTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class BlockTransformer extends AbstractTransformer {

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'author',
        'blockabale',
        'translations'
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * Transforms block entity
     *
     * @param Block|array $block Block entity
     *
     * @return array
     */
    public function transform($block)
    {
        $block = $this->entityToArray(Block::class, $block);
        return [
            'id'          => $this->setNullableValue($block['id']),
            'type'        => $block['type'],
            'region'      => $block['region'],
            'filter'      => $block['filter'],
            'options'     => $block['options'],
            'theme'       => $block['theme'],
            'weight'      => (int) $block['weight'],
            'isActive'    => (bool) $block['isActive'],
            'isCacheable' => (bool) $block['isActive'],
            'createdAt'   => $block['createdAt'],
            'updatedAt'   => $block['updatedAt']
        ];
    }


    /**
     * Include Translations
     *
     * @param Block $block Translation
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeTranslations(Block $block)
    {
        $translations = $block->translations;
        return $this->collection($translations, new BlockTranslationTransformer());
    }

    /**
     * Include Author
     *
     * @param Block $block User
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeAuthor(Block $block)
    {
        $author = $block->author;
        return (!empty($author)) ? $this->item($author, new UserTransformer()) : null;
    }

    /**
     * Include Author
     *
     * @param Block $block User
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeBlockabale(Block $block)
    {
        $blockable = $block->blockable;
        if (!empty($blockable)) {
            $entityClassName  = (new ReflectionClass($blockable))->getShortName();
            $transformerClass = 'Gzero\\Api\\Transformer\\' . $entityClassName . 'Transformer';
            return $this->item($blockable, new $transformerClass());
        }
        return null;
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
