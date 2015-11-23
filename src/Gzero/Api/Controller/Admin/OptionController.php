<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\OptionCategoryTransformer;
use Gzero\Api\Transformer\OptionTransformer;
use Gzero\Api\Validator\OptionValidator;
use Gzero\Repository\OptionRepository;
use Gzero\Repository\RepositoryException;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class OptionController
 *
 * @package    Gzero\Admin\Controllers\Resource
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class OptionController extends ApiController {

    /**
     * @var OptionRepository
     */
    protected $optionRepo;

    /**
     * @var OptionValidator
     */
    protected $validator;

    /**
     * OptionController constructor
     *
     * @param OptionRepository $option    Option repo
     * @param OptionValidator  $validator validator
     */
    public function __construct(OptionRepository $option, OptionValidator $validator)
    {
        $this->validator  = $validator->setData(\Input::all());
        $this->optionRepo = $option;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->respondWithSuccess($this->optionRepo->getCategories(), new OptionCategoryTransformer);
    }

    /**
     * Display all options from selected category.
     *
     * @param string $key option category key
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($key)
    {
        try {
            $option = $this->optionRepo->getOptions($key);
            return $this->respondWithSuccess($option, new OptionTransformer);
        } catch (RepositoryException $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * Updates the specified resource in the database.
     *
     * @param string $categoryKey option category key
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Gzero\Validator\ValidationException
     *
     */
    public function update($categoryKey)
    {
        $input = $this->validator->validate('update');
        try {
            $this->optionRepo->updateOrCreateOption($categoryKey, $input['key'], $input['value']);
            return $this->respondWithSuccess($this->optionRepo->getOptions($categoryKey), new OptionTransformer);
        } catch (RepositoryException $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

}

/*
|--------------------------------------------------------------------------
| START API DOCS
|--------------------------------------------------------------------------
*/

/**
 * @api                 {get} /options 1. GET collection of categories
 * @apiVersion          0.1.0
 * @apiName             GetOptionCategories
 * @apiGroup            Options
 * @apiPermission       admin
 * @apiDescription      Get all option categories
 * @apiUse              OptionCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/options
 * @apiSuccessExample   Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "data": [
 *            {
 *              "key": "general"
 *            },
 *            {
 *              "key": "seo"
 *            }
 *       ]
 *     }
 */

/**
 * @api                 {get} /options/:category 2. GET category options
 * @apiVersion          0.1.0
 * @apiName             GetOptions
 * @apiGroup            Options
 * @apiPermission       admin
 * @apiDescription      Get all options within the given category
 * @apiParam {String}   key category unique key
 * @apiUse              Option
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/options/general
 * @apiSuccessExample   Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "defaultPageSize": {
 *         "en": 5,
 *         "pl": 5
 *       },
 *       "siteDesc": {
 *         "en": "Content management system.",
 *         "pl": "Content management system."
 *       }
 *       "siteName": {
 *         "en": "G-ZERO CMS",
 *         "pl": "G-ZERO CMS"
 *       },
 *     }
 *
 */

/**
 * @api                 {put} /options/:category 3. PUT category options
 * @apiVersion          0.1.0
 * @apiName             UpdateOptions
 * @apiGroup            Options
 * @apiPermission       admin
 * @apiDescription      Update selected option within the given category
 * @apiParam {String}   key option unique key
 * @apiParam {String}   value option value
 * @apiUse              Option
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/options/general
 * @apiSuccessExample   Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "defaultPageSize": {
 *         "en": 5,
 *         "pl": 5
 *       },
 *       "siteDesc": {
 *         "en": "Content management system.",
 *         "pl": "Content management system."
 *       }
 *       "siteName": {
 *         "en": "G-ZERO CMS",
 *         "pl": "G-ZERO CMS"
 *       },
 *     }
 *
 */

/**
 * @apiDefine Option
 * @apiSuccess {obj} data obj of all options in category
 */

/**
 * @apiDefine OptionCollection
 * @apiSuccess {Array[]} data Array of all options categories
 * @apiSuccess {String} data.key option key
 */

/*
|--------------------------------------------------------------------------
| END API DOCS
|--------------------------------------------------------------------------
*/
