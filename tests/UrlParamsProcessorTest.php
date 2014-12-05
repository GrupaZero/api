<?php
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
class UrlParamsProcessorTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var UrlParamsProcessor
     */
    protected $processor;

    protected function setUp()
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
                'lang'  => [
                    'value'     => 'en',
                    'operation' => '=',
                    'relation'  => null
                ],
                'test2' => [
                    'value'     => 'test2',
                    'operation' => '=',
                    'relation'  => null
                ]
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
        $this->assertEquals($this->processor->getOrderByParams(), ['test1' => 'DESC', 'test2' => 'ASC', 'test3' => 'ASC']);
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
                    'lang'  => [
                        'value'     => 'en',
                        'operation' => '=',
                        'relation'  => null
                    ],
                    'test2' => [
                        'value'     => 'test2',
                        'operation' => '=',
                        'relation'  => null
                    ]
                ],
                'orderBy' => [
                    'test1' => 'DESC',
                    'test2' => 'ASC',
                    'test3' => 'ASC'
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
                'sort'    => '-test1,test2,test3',
                'page'    => 3,
                'perPage' => 21,
                'lang'    => 'en',
                'test2'   => 'test2'
            ]
        );
    }
}
