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

    private $page = 1;

    private $filter = [];

    private $orderBy = [];

    /**
     * UrlParamsProcessor constructor
     *
     * @param array $input Array with parameters to process
     */
    public function __construct(Array $input)
    {
        $this->process($input);
    }

    /**
     * Returns page number
     *
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Returns orderBy array
     *
     * @return array
     */
    public function getOrderByParams()
    {
        return $this->orderBy;
    }

    /**
     *  Returns filter array
     *
     * @return array
     */
    public function getFilterParams()
    {
        return $this->filter;
    }

    /**
     * Process params
     *
     * @param array $input Array with parameters to process
     *
     * @return void
     */
    private function process(Array $input)
    {
        if (!empty($input['sort'])) {
            foreach (explode(',', $input['sort']) as $sort) {
                $this->processOrderByParams($sort);
            }
        }
        $input = $this->processPageParams($input);
        foreach ($input as $key => $param) {
            if (!in_array($key, ['sort', 'page'], true)) {
                $this->filter[$key] = $param;
            }
        }
    }

    /**
     * Process order by params
     *
     * @param string $sort Sort parameter
     *
     * @return void
     */
    private function processOrderByParams($sort)
    {
        if (substr($sort, 0, 1) == '-') {
            $this->orderBy[substr($sort, 1)] = 'DESC';
        } else {
            $this->orderBy[$sort] = 'ASC';
        }
    }

    /**
     * Process page params
     *
     * @param array $input Array of parameters
     *
     * @return mixed
     */
    private function processPageParams(Array $input)
    {
        if (!empty($input['page']) && is_numeric($input['page'])) {
            $this->page = $input['page'];
            return $input;
        }
        return $input;
    }
}
