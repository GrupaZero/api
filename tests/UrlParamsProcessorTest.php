<?php

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
     * @test
     */
    public function is_working()
    {
        $processor = new \Gzero\Api\UrlParamsProcessor([
            'sort'         => '-test1,test2,-test3',
            'page'         => 3,
            'filter_param' => 'test'
        ]);
        $this->assertEquals(
            $processor->getOrderByParams(),
            [
                'test1' => 'DESC',
                'test2' => 'ASC',
                'test3' => 'DESC'
            ]
        );
        $this->assertEquals($processor->getPage(), 3);
        $this->assertEquals($processor->getFilterParams(), ['filter_param' => 'test']);
    }
}
