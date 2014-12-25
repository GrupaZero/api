<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\LangTransformer;
use Gzero\Repository\LangRepository;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class LangController
 *
 * @package    Gzero\Admin\Controllers\Resource
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class LangController extends ApiController {

    /**
     * @var LangRepository
     */
    protected $langRepo;

    /**
     * ContentController constructor
     *
     * @param LangRepository $lang Content repo
     */
    public function __construct(LangRepository $lang)
    {
        $this->langRepo = $lang;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->respondWithSuccess($this->langRepo->getAll(), new LangTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param int $code Lang code
     *
     * @return Response
     */
    public function show($code)
    {
        $lang = $this->langRepo->getByCode($code);
        if (empty($lang)) {
            return $this->respondNotFound();
        }
        return $this->respondWithSuccess($lang, new LangTransformer);
    }

}

/*
|--------------------------------------------------------------------------
| START API DOCS
|--------------------------------------------------------------------------
*/

/**
 * @api                 {get} /langs 1. GET collection of entities
 * @apiVersion          0.1.0
 * @apiName             GetLangList
 * @apiGroup            Language
 * @apiPermission       admin
 * @apiDescription      Get all languages
 * @apiUse              LangCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/langs
 * @apiSuccessExample   Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "data": [
 *            {
 *              "code": "en",
 *              "i18n": "en_US",
 *              "isEnabled": false,
 *              "isDefault": true
 *            },
 *            {
 *              "code": "pl",
 *              "i18n": "pl_PL",
 *              "isEnabled": false,
 *              "isDefault": false
 *            }
 *       ]
 *     }
 */

/**
 * @api                 {get} /langs/:code 2. GET single entity
 * @apiVersion          0.1.0
 * @apiName             GetLang
 * @apiGroup            Language
 * @apiPermission       admin
 * @apiDescription      Get a single language by passing lang code
 * @apiParam {String}   code Lang unique code
 * @apiUse              Lang
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/langs/en
 * @apiSuccessExample   Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "code": "en",
 *       "i18n": "en_US",
 *       "isEnabled": false,
 *       "isDefault": true
 *     }
 */

/**
 * @apiDefine Lang
 * @apiSuccess {String} code Lang code
 * @apiSuccess {String} i18n Lang i18n code
 * @apiSuccess {Boolean} is_enabled Flag if language is enabled
 * @apiSuccess {Boolean} is_default Flag if language is default
 */

/**
 * @apiDefine LangCollection
 * @apiSuccess {Array[]} data Array of Languages
 * @apiSuccess {String} data.code Lang code
 * @apiSuccess {String} data.i18n Lang i18n code
 * @apiSuccess {Boolean} data.is_enabled Flag if language is enabled
 * @apiSuccess {Boolean} data.is_default Flag if language is default
 */

/*
|--------------------------------------------------------------------------
| END API DOCS
|--------------------------------------------------------------------------
*/
