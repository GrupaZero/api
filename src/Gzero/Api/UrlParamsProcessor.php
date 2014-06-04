<?php namespace Gzero\Api;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class UrlParamsProcessor
 *
 * @package    Gzero\Api
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class UrlParamsProcessor {

    private
        $page = 1,
        $filter = [],
        $orderBy = [];

    public function __construct(Array $input)
    {
        $this->process($input);
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getOrderByParams()
    {
        return $this->orderBy;
    }

    public function getFilterParams()
    {
        return $this->filter;
    }

    private function process($input)
    {
        if (!empty($input['sort'])) {
            foreach (explode(',', $input['sort']) as $sort) {
                if (substr($sort, 0, 1) == '-') {
                    $this->orderBy[substr($sort, 1)] = 'DESC';
                } else {
                    $this->orderBy[$sort] = 'ASC';
                }
            }
        }
        if (!empty($input['page']) and is_numeric($input['page'])) {
            $this->page = $input['page'];
        }
        foreach ($input as $key => $param) {
            if (!in_array($key, ['sort', 'page'], TRUE)) {
                $this->filter[$key] = $param;
            }
        }
    }
}
