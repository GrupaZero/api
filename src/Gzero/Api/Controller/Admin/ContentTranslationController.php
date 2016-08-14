<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\ContentTranslationTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Api\Validator\ContentTranslationValidator;
use Gzero\Entity\Content;
use Gzero\Repository\ContentRepository;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class ContentTranslationController
 *
 * @package    Gzero\Admin\Controllers\Resource
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class ContentTranslationController extends ApiController {

    /**
     * @var ContentRepository
     */
    protected $repository;

    /**
     * @var ContentTranslationValidator
     */
    protected $validator;

    /**
     * ContentTranslationController constructor
     *
     * @param UrlParamsProcessor          $processor Url processor
     * @param ContentRepository           $content   Content repository
     * @param ContentTranslationValidator $validator Content validator
     */
    public function __construct(UrlParamsProcessor $processor, ContentRepository $content, ContentTranslationValidator $validator)
    {
        parent::__construct($processor);
        $this->validator  = $validator->setData(\Input::all());
        $this->repository = $content;
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
        $this->authorize('readList', Content::class);
        $input   = $this->validator->validate('list');
        $params  = $this->processor->process($input)->getProcessedFields();
        $content = $this->repository->getById($id);
        if (!empty($content)) {
            $results = $this->repository->getTranslations(
                $content,
                $params['filter'],
                $params['orderBy'],
                $params['page'],
                $params['perPage']
            );
            return $this->respondWithSuccess($results, new ContentTranslationTransformer);
        } else {
            return $this->respondNotFound();
        }
    }

    /**
     * Display a specified resource.
     *
     * @param int $id            Id of the content
     * @param int $translationId Id of the content translation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, $translationId)
    {
        $content = $this->getContent($id);
        if (!empty($content)) {
            $this->authorize('read', $content);
            $translation = $this->repository->getContentTranslationById($content, $translationId);
            if (!empty($translation)) {
                return $this->respondWithSuccess($translation, new ContentTranslationTransformer);
            }
        }
        return $this->respondNotFound();
    }

    /**
     * Stores newly created translation for specified content entity in database.
     *
     * @param int $id Id of the content
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id)
    {
        $content = $this->getContent($id);
        if (!empty($content)) {
            $this->authorize('create', $content);
            $this->authorize('update', $content);
            $input       = $this->validator->validate('create');
            $translation = $this->repository->createTranslation($content, $input);
            return $this->respondWithSuccess($translation, new ContentTranslationTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Each translations update always creates new record in database, for history revision
     *
     * @param int $id Id of the content
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
     * @param int $id            Id of the content
     * @param int $translationId Id of the content translation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, $translationId)
    {
        $content = $this->getContent($id);
        if (!empty($content)) {
            $this->authorize('delete', $content);
            $translation = $this->repository->getContentTranslationById($content, $translationId);
            if (!empty($translation)) {
                $this->repository->deleteTranslation($translation);
                return $this->respondWithSimpleSuccess(['success' => true]);
            }
        }
        return $this->respondNotFound();
    }

    /**
     * Gets Content entity by id
     *
     * @param int $id content id
     *
     * @return \Gzero\Entity\Content
     */
    protected function getContent($id)
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
 * @api                 {get} /admin/contents/:id/translations 1. GET collection of translations
 * @apiVersion          0.1.0
 * @apiName             GetTranslationList
 * @apiGroup            Content Translations
 * @apiPermission       admin
 * @apiParam {Number} id The Content ID
 * @apiDescription      Get collection of translation for specified content entity
 * @apiUse              Meta
 * @apiUse              Params
 * @apiUse              ContentTranslationCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/contents/1/translations
 */
/**
 * @api                 {get} /admin/contents/:id/translations/:id 2. GET single entity
 * @apiVersion          0.1.0
 * @apiName             GetContentTranslation
 * @apiGroup            Content Translations
 * @apiPermission       admin
 * @apiParam {Number} id The Content ID
 * @apiParam {Number} translationId The ContentTranslations ID
 * @apiDescription      Get the specified content translation from database
 * @apiUse              ContentTranslation
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/contents/1/translations/1
 */
/**
 * @api                 {post} /admin/contents/:id/translations 3. POST newly created entity
 * @apiVersion          0.1.0
 * @apiName             PostContentTranslation
 * @apiGroup            Content Translations
 * @apiPermission       admin
 * @apiParam {Number} id The Content ID
 * @apiDescription      Stores newly created content translation in database
 * @apiUse              ContentTranslation
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/contents/1/translations
 */
/**
 * @api                 {put} /admin/contents/:id/translations 4. PUT newly created revision
 * @apiVersion          0.1.0
 * @apiName             PutContentTranslation
 * @apiGroup            Content Translations
 * @apiPermission       admin
 * @apiParam {Number} id The Content ID
 * @apiDescription      Each translations update always creates new record in database, for history revision
 * @apiUse              ContentTranslation
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/contents/1/translations
 */
/**
 * @api                 {delete} /admin/contents/:id/translations/:id  5. DELETE the specified entity
 * @apiVersion          0.1.0
 * @apiName             DeleteContentTranslation
 * @apiGroup            Content Translations
 * @apiPermission       admin
 * @apiParam {Number} id The Content ID
 * @apiParam {Number} translationId The ContentTranslations ID
 * @apiDescription      Deletes the specified content translation from database
 * @apiSuccess {Boolean} success Success flag
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/contents/1/translations/1
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 * {"success":true}
 */

/**
 * @apiDefine           ContentTranslationCollection
 * @apiSuccess {Array[]} translations List of active translations (Array of Objects)
 * @apiSuccess {Number} data.id Translation id
 * @apiSuccess {String} data.lang Language code
 * @apiSuccess {String} data.title Title
 * @apiSuccess {String} data.body Body
 * @apiSuccess {Boolean} data.isActive Is active flag
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
 *        "link": "http://api.gzero.dev:8000/v1/admin/contents/1/translations"
 *    },
 *    "params": {
 *        "page": 1,
 *        "perPage": 20,
 *        "filter": [],
 *        "orderBy": []
 *    },
 *    "data": [
 *        {ContentTranslations},
 *        ...
 *    ]
 *}
 */

/**
 * @apiDefine           ContentTranslation
 * @apiSuccess {Number} id Translation id
 * @apiSuccess {String} lang Language code
 * @apiSuccess {String} title Title
 * @apiSuccess {String} body Body
 * @apiSuccess {Boolean} isActive Is active flag
 * @apiSuccess {Date} createdAt Creation date of translation
 * @apiSuccess {Date} updatedAt Update date of translation
 *
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 *{
 *   "id": 1,
 *   "lang": "en",
 *   "title": "Example title",
 *   "body": "Example body",
 *   "isActive": true,
 *   "createdAt": "2015-12-13 12:10:59",
 *   "updatedAt": "2015-12-13 12:10:59"
 * }
 */

/*
|--------------------------------------------------------------------------
| END API DOCS
|--------------------------------------------------------------------------
*/
