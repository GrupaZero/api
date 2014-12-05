<?php namespace Gzero\Api;

use Gzero\Repository\BaseRepository;

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

    private $perPage = BaseRepository::ITEMS_PER_PAGE; // Default value from repository

    private $filter = [];

    private $orderBy = [];


    /**
     * Returns page number
     *
     * @return int
     */
    public function getPage()
    {
        return (int) $this->page;
    }

    /**
     * Returns page number
     *
     * @return int
     */
    public function getPerPage()
    {
        return (int) $this->perPage;
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
            'orderBy' => $this->orderBy
        ];
    }

    /**
     * Process params
     *
     * @param array $input Array with parameters to process
     *
     * @return $this
     */
    public function process(Array $input)
    {
        if (!empty($input['sort'])) {
            foreach (explode(',', $input['sort']) as $sort) {
                $this->processOrderByParams($sort);
            }
        }
        $input = $this->processPageParams($input);
        foreach ($input as $key => $param) {
            if (!in_array($key, ['sort', 'page', 'perPage'], true)) {
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
        $direction = (substr($sort, 0, 1) == '-') ? 'DESC' : 'ASC';
        $relation  = null;
        if (preg_match('|\.|', $sort)) {
            $temp     = explode('.', preg_replace('|^-|', '', $sort));
            $field    = array_pop($temp);
            $relation = trim(implode('.', $temp), '.');
        } else {
            $field = (substr($sort, 0, 1) == '-') ? substr($sort, 1) : $sort;
        }
        $this->orderBy[$field] = [
            'direction' => $direction,
            'relation'  => $relation
        ];
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
        }
        if (!empty($input['perPage']) && is_numeric($input['perPage'])) {
            $this->perPage = $input['perPage'];
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
        if (preg_match('|_|', $key)) {
            $temp                           = explode('_', $key);
            $this->filter[array_pop($temp)] = [
                'value'     => (is_numeric($param)) ? (float) $param : $param,
                'operation' => '=',
                'relation'  => trim(implode('.', $temp), '.')
            ];

        } else {
            $this->filter[$key] = [
                'value'     => (is_numeric($param)) ? (float) $param : $param,
                'operation' => '=',
                'relation'  => null
            ];
        }
    }
}
