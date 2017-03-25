<?php namespace Gzero\Api;

use Gzero\Repository\QueryBuilder;

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

    /**
     * @var int
     */
    private $page = 1;

    /**
     * @var int
     */
    private $perPage = QueryBuilder::ITEMS_PER_PAGE;

    /**
     * @var array
     */
    private $filter = [];

    /**
     * @var array
     */
    private $orderBy = [];

    /**
     * @var null
     */
    private $searchQuery = null;


    /**
     * Returns page number
     *
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Returns page number
     *
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * Returns orderBy array
     *
     * @return array
     */
    public function getOrderByParams(): array
    {
        return $this->orderBy;
    }

    /**
     *  Returns filter array
     *
     * @return array
     */
    public function getFilterParams(): array
    {
        return $this->filter;
    }

    /**
     *  Returns filter array
     *
     * @return string
     */
    public function getSearchQuery(): string
    {
        return $this->searchQuery;
    }

    /**
     * Returns array with all processed fields
     *
     * @return array
     */
    public function getProcessedFields()
    {
        return [
            'page'    => $this->getPage(),
            'perPage' => $this->getPerPage(),
            'filter'  => $this->filter,
            'orderBy' => $this->orderBy,
            'query'   => $this->searchQuery
        ];
    }

    /**
     * Process params
     *
     * @param array $input Array with parameters to process
     *
     * @return $this
     */
    public function process(array $input)
    {
        if (!empty($input['q'])) {
            $this->searchQuery = $input['q'];
        }
        if (!empty($input['sort'])) {
            foreach (explode(',', $input['sort']) as $sort) {
                $this->processOrderByParams($sort);
            }
        }
        $input = $this->processPageParams($input);
        foreach ($input as $key => $param) {
            if (!in_array($key, ['sort', 'page', 'per_page', 'q'], true)) {
                $this->processFilterParams($key, $param);
            }
        }
        return $this;
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
        $direction       = (substr($sort, 0, 1) == '-') ? 'DESC' : 'ASC';
        $field           = (substr($sort, 0, 1) == '-') ? substr($sort, 1) : $sort;
        $this->orderBy[] = [
            snake_case($field),
            $direction
        ];
    }

    /**
     * Process page params
     *
     * @param array $input Array of parameters
     *
     * @return mixed
     */
    private function processPageParams(array $input)
    {
        if (!empty($input['page']) && is_numeric($input['page'])) {
            $this->page = $input['page'];
        }
        if (!empty($input['per_page']) && is_numeric($input['per_page'])) {
            $this->perPage = $input['per_page'];
        }
        return $input;
    }

    /**
     * Process filter params
     *
     * @param string $key   Param name
     * @param string $param Param value
     *
     * @return void
     */
    private function processFilterParams($key, $param)
    {
        $this->filter[] = [
            $key,
            '=',
            (is_numeric($param)) ? (float) $param : $param
        ];
    }
}
