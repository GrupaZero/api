<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\BlockTranslationTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Api\Validator\BlockTranslationValidator;
use Gzero\Repository\BlockRepository;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class BlockTranslationController
 *
 * @package    Gzero\Admin\Controllers\Resource
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class BlockTranslationController extends ApiController {

    /**
     * @var BlockRepository
     */
    protected $repository;

    /**
     * @var BlockTranslationValidator
     */
    protected $validator;

    /**
     * BlockTranslationController constructor
     *
     * @param UrlParamsProcessor        $processor Url processor
     * @param BlockRepository           $block     Block repository
     * @param BlockTranslationValidator $validator Block validator
     */
    public function __construct(UrlParamsProcessor $processor, BlockRepository $block, BlockTranslationValidator $validator)
    {
        parent::__construct($processor);
        $this->validator  = $validator->setData(\Input::all());
        $this->repository = $block;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int|null $id Id used for nested resources
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $input  = $this->validator->validate('list');
        $params = $this->processor->process($input)->getProcessedFields();
        $block  = $this->repository->getById($id);
        if (!empty($block)) {
            $results = $this->repository->getTranslations(
                $block,
                $params['filter'],
                $params['orderBy'],
                $params['page'],
                $params['perPage']
            );
            return $this->respondWithSuccess($results, new BlockTranslationTransformer);
        } else {
            return $this->respondNotFound();
        }
    }

    /**
     * Display a specified resource.
     *
     * @param int $id            Id of the block
     * @param int $translationId Id of the block translation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, $translationId)
    {
        $block = $this->getBlock($id);
        if (!empty($block)) {
            $translation = $this->repository->getBlockTranslationById($block, $translationId);
            if (!empty($translation)) {
                return $this->respondWithSuccess($translation, new BlockTranslationTransformer);
            }
        }
        return $this->respondNotFound();
    }

    /**
     * Stores newly created translation for specified block entity in database.
     *
     * @param int $id Id of the block
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id)
    {
        $block = $this->getBlock($id);
        if (!empty($block)) {
            $input       = $this->validator->validate('create');
            $translation = $this->repository->createTranslation($block, $input);
            return $this->respondWithSuccess($translation, new BlockTranslationTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Each translations update always creates new record in database, for history revision
     *
     * @param int $id Id of the block
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        return $this->store($id);
    }

    /**
     * Remove the specified resource from database.
     *
     * @param int $id            Id of the block
     * @param int $translationId Id of the block translation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, $translationId)
    {
        $block = $this->getBlock($id);
        if (!empty($block)) {
            $translation = $this->repository->getBlockTranslationById($block, $translationId);
            if (!empty($translation)) {
                $this->repository->deleteTranslation($translation);
                return $this->respondWithSimpleSuccess(['success' => true]);
            }
        }
        return $this->respondNotFound();
    }

    /**
     * Gets Block entity by id
     *
     * @param int $id block id
     *
     * @return \Gzero\Entity\Block
     */
    protected function getBlock($id)
    {
        return $this->repository->getById($id);
    }
}

/*
|--------------------------------------------------------------------------
| START API DOCS
|--------------------------------------------------------------------------
*/
/**
 * @api                 {get} /admin/blocks/:id/translations 1. GET collection of translations
 * @apiVersion          0.1.0
 * @apiName             GetTranslationList
 * @apiGroup            Block Translations
 * @apiPermission       admin
 * @apiParam {Number} id The Block ID
 * @apiDescription      Get collection of translation for specified block entity
 * @apiUse              Meta
 * @apiUse              Params
 * @apiUse              BlockTranslationCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/blocks/1/translations
 */
/**
 * @api                 {get} /admin/blocks/:id/translations/:id 2. GET single entity
 * @apiVersion          0.1.0
 * @apiName             GetBlockTranslation
 * @apiGroup            Block Translations
 * @apiPermission       admin
 * @apiParam {Number} id The Block ID
 * @apiParam {Number} translationId The BlockTranslations ID
 * @apiDescription      Get the specified block translation from database
 * @apiUse              BlockTranslation
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/blocks/1/translations/1
 */
/**
 * @api                 {post} /admin/blocks/:id/translations 3. POST newly created entity
 * @apiVersion          0.1.0
 * @apiName             PostBlockTranslation
 * @apiGroup            Block Translations
 * @apiPermission       admin
 * @apiParam {Number} id The Block ID
 * @apiDescription      Stores newly created block translation in database
 * @apiUse              BlockTranslation
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/blocks/1/translations
 */
/**
 * @api                 {put} /admin/blocks/:id/translations 4. PUT newly created revision
 * @apiVersion          0.1.0
 * @apiName             PutBlockTranslation
 * @apiGroup            Block Translations
 * @apiPermission       admin
 * @apiParam {Number} id The Block ID
 * @apiDescription      Each translations update always creates new record in database, for history revision
 * @apiUse              BlockTranslation
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/blocks/1/translations
 */
/**
 * @api                 {delete} /admin/blocks/:id/translations/:id  5. DELETE the specified entity
 * @apiVersion          0.1.0
 * @apiName             DeleteBlockTranslation
 * @apiGroup            Block Translations
 * @apiPermission       admin
 * @apiParam {Number} id The Block ID
 * @apiParam {Number} translationId The BlockTranslations ID
 * @apiDescription      Deletes the specified block translation from database
 * @apiSuccess {Boolean} success Success flag
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/blocks/1/translations/1
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 * {"success":true}
 */

/**
 * @apiDefine           BlockTranslationCollection
 * @apiSuccess {Array[]} translations List of active translations (Array of Objects)
 * @apiSuccess {Number} data.id Translation id
 * @apiSuccess {String} data.lang Language code
 * @apiSuccess {String} data.title Title
 * @apiSuccess {String} data.body Body
 * @apiSuccess {Boolean} data.isActive Is active flag
 * @apiSuccess {Array} data.customFields Translation unique parameters (Defined as array of key / value parameters)
 * @apiSuccess {Date} data.createdAt Creation date of translation
 * @apiSuccess {Date} data.updatedAt Update date of translation
 *
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 *{
 *        "meta": {
 *        "total": 4,
 *        "perPage": 20,
 *        "currentPage": 1,
 *        "lastPage": 1,
 *        "link": "http://api.gzero.dev:8000/v1/admin/blocks/1/translations"
 *    },
 *    "params": {
 *        "page": 1,
 *        "perPage": 20,
 *        "filter": [],
 *        "orderBy": []
 *    },
 *    "data": [
 *        {BlockTranslations},
 *        ...
 *    ]
 *}
 */

/**
 * @apiDefine           BlockTranslation
 * @apiSuccess {Number} id Translation id
 * @apiSuccess {String} lang Language code
 * @apiSuccess {String} title Title
 * @apiSuccess {String} body Body
 * @apiSuccess {Boolean} isActive Is active flag
 * @apiSuccess {Array} customFields Translation unique parameters (Defined as array of key / value parameters)
 * @apiSuccess {Date} createdAt Creation date of translation
 * @apiSuccess {Date} updatedAt Update date of translation
 *
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 *{
 *   "id": 1,
 *   "lang": "en",
 *   "title": "Example block title",
 *   "body": "Example block body",
 *   "isActive": true,
 *   "customFields": {
 *       "fieldName": "fieldValue",
 *       "anotherFieldName": "anotherFieldValue",
 *       "lastFieldName": "lastFieldValue"
 *   },
 *   "createdAt": "2015-12-13 12:11:04",
 *   "updatedAt": "2015-12-13 12:11:04"
 *   },
 * }
 */

/*
|--------------------------------------------------------------------------
| END API DOCS
|--------------------------------------------------------------------------
*/
