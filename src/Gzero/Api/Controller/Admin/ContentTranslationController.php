<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\ContentTranslationTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Api\Validator\ContentTranslationValidator;
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
     * @var ContentValidator
     */
    protected $validator;

    /**
     * ContentController constructor
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
            $input       = $this->validator->validate('create');
            $translation = $this->repository->createTranslation($content, $input);
            return $this->respondWithSuccess($translation, new ContentTranslationTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Gets Content entity by id
     *
     * @param $id
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
 * @api                 {get} /admin/contents/:id/translations 7. GET collection of translations
 * @apiVersion          0.1.0
 * @apiName             GetTranslationList
 * @apiGroup            Content
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
 * @api                 {get} /admin/contents/:id/translations/:id 8. GET single translation entity
 * @apiVersion          0.1.0
 * @apiName             GetContentTranslation
 * @apiGroup            Content
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
 * @api                 {post} /admin/contents/:id/translations 9. POST newly created translation
 * @apiVersion          0.1.0
 * @apiName             PostContentTranslation
 * @apiGroup            Content
 * @apiPermission       admin
 * @apiParam {Number} id The Content ID
 * @apiDescription      Stores newly created content translation in database
 * @apiUse              ContentTranslation
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/contents/1/translations
 */

/**
 * @apiDefine           ContentTranslationCollection
 * @apiSuccess {Array[]} translations List of active translations (Array of Objects)
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
 * @apiSuccess {Number} id ContentTranslation id
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
 *   "isActive": 1,
 *   "createdAt": "2014-12-24T10:57:39+0000",
 *   "updatedAt": "2014-12-24T10:57:39+0000"
 * }
 */

/*
|--------------------------------------------------------------------------
| END API DOCS
|--------------------------------------------------------------------------
*/
