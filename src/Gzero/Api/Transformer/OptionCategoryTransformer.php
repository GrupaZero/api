<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\OptionCategory;

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
class OptionCategoryTransformer extends AbstractTransformer {

    /**
     * Transforms option category entity
     *
     * @param array $option OptionCategory entity
     *
     * @return array
     */
    public function transform($option)
    {
        $options = $this->entityToArray(OptionCategory::class, $option);
        $data    = ['data' => []];
        foreach ($options as $option) {
            $data['data'][] = [
                'key' => $option,
            ];
        }

        return $data;
    }
}
