<?php

namespace Api;

use Gzero\Api\UrlParamsProcessor;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class UrlParamsProcessorTest
 *
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class UrlParamsProcessorTest extends \Codeception\Test\Unit {

    /**
     * @var UrlParamsProcessor
     */
    protected $processor;

    protected function _before()
    {
        $this->processor = $this->initClass();

    }

    /**
     * @test
     */
    public function is_instantiable()
    {
        $this->assertInstanceOf('\Gzero\Api\UrlParamsProcessor', $this->processor);
    }

    /**
     * @test
     */
    public function can_filter_params()
    {
        $this->assertEquals(
            $this->processor->getFilterParams(),
            [
                ['lang', '=', 'en'],
                ['test2', '=', 'test2'],
                ['translation.lang_code', '=', 'en']
            ]
        );
    }

    /**
     * @test
     */
    public function is_returning_page_params()
    {
        $this->assertEquals($this->processor->getPage(), 3);
        $this->assertEquals($this->processor->getPerPage(), 21);
    }

    /**
     * @test
     */
    public function can_process_sort_params()
    {
        $this->assertEquals(
            $this->processor->getOrderByParams(),
            [
                ['test1', 'DESC'],
                ['test2', 'ASC'],
                ['created_at', 'ASC'],
            ]
        );
    }

    /**
     * @test
     */
    public function is_returning_processed_fields_in_correct_format()
    {
        $this->assertEquals(
            $this->processor->getProcessedFields(),
            [
                'page'    => 3,
                'perPage' => 21,
                'filter'  => [
                    ['lang', '=', 'en'],
                    ['test2', '=', 'test2'],
                    ['translation.lang_code', '=', 'en']
                ],
                'orderBy' => [
                    ['test1', 'DESC'],
                    ['test2', 'ASC'],
                    ['created_at', 'ASC'],
                ]
            ]
        );
    }

    /**
     * @return UrlParamsProcessor
     */
    protected function initClass()
    {
        return (new UrlParamsProcessor())->process(
            [
                'sort'                  => '-test1,test2,createdAt',
                'page'                  => 3,
                'per_page'              => 21,
                'lang'                  => 'en',
                'test2'                 => 'test2',
                'translation.lang_code' => 'en'
            ]
        );
    }
}
