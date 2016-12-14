<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\FileTranslationTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Api\Validator\FileTranslationValidator;
use Gzero\Entity\File;
use Gzero\Repository\FileRepository;
use Illuminate\Http\Request;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class FileTranslationController
 *
 * @package    Gzero\Admin\Controllers\Resource
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class FileTranslationController extends ApiController {

    /**
     * @var FileRepository
     */
    protected $repository;

    /**
     * @var FileTranslationValidator
     */
    protected $validator;

    /**
     * FileTranslationController constructor
     *
     * @param UrlParamsProcessor       $processor Url processor
     * @param FileRepository           $file      File repository
     * @param FileTranslationValidator $validator File validator
     * @param Request                  $request   Request object
     */
    public function __construct(
        UrlParamsProcessor $processor,
        FileRepository $file,
        FileTranslationValidator $validator,
        Request $request
    ) {
        parent::__construct($processor);
        $this->validator  = $validator->setData($request->all());
        $this->repository = $file;
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
        $this->authorize('readList', File::class);
        $input  = $this->validator->validate('list');
        $params = $this->processor->process($input)->getProcessedFields();
        $file   = $this->repository->getById($id);
        if (!empty($file)) {
            $results = $this->repository->getTranslations(
                $file,
                $params['filter'],
                $params['orderBy'],
                $params['page'],
                $params['perPage']
            );
            return $this->respondWithSuccess($results, new FileTranslationTransformer);
        } else {
            return $this->respondNotFound();
        }
    }

    /**
     * Display a specified resource.
     *
     * @param int $id            Id of the file
     * @param int $translationId Id of the file translation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, $translationId)
    {
        $file = $this->getFile($id);
        if (!empty($file)) {
            $this->authorize('read', $file);
            $translation = $this->repository->getFileTranslationById($file, $translationId);
            if (!empty($translation)) {
                return $this->respondWithSuccess($translation, new FileTranslationTransformer);
            }
        }
        return $this->respondNotFound();
    }

    /**
     * Stores newly created translation for specified file entity in database.
     *
     * @param int $id Id of the file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id)
    {
        $file = $this->getFile($id);
        if (!empty($file)) {
            $this->authorize('create', $file);
            $this->authorize('update', $file);
            $input       = $this->validator->validate('create');
            $translation = $this->repository->createTranslation($file, $input);
            return $this->respondWithSuccess($translation, new FileTranslationTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Each translations update always creates new record in database
     *
     * @param int $id Id of the file
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
     * @param int $id            Id of the file
     * @param int $translationId Id of the file translation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, $translationId)
    {
        $file = $this->getFile($id);
        if (!empty($file)) {
            $this->authorize('delete', $file);
            $translation = $this->repository->getFileTranslationById($file, $translationId);
            if (!empty($translation)) {
                $this->repository->deleteTranslation($translation);
                return $this->respondWithSimpleSuccess(['success' => true]);
            }
        }
        return $this->respondNotFound();
    }

    /**
     * Gets File entity by id
     *
     * @param int $id file id
     *
     * @return \Gzero\Entity\File
     */
    protected function getFile($id)
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
 * @api                 {get} /admin/files/:id/translations 1. GET collection of translations
 * @apiVersion          0.1.0
 * @apiName             GetTranslationList
 * @apiGroup            File Translations
 * @apiPermission       admin
 * @apiParam {Number} id The File ID
 * @apiDescription      Get collection of translation for specified file entity
 * @apiUse              Meta
 * @apiUse              Params
 * @apiUse              FileTranslationCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/files/1/translations
 */
/**
 * @api                 {get} /admin/files/:id/translations/:id 2. GET single entity
 * @apiVersion          0.1.0
 * @apiName             GetFileTranslation
 * @apiGroup            File Translations
 * @apiPermission       admin
 * @apiParam {Number} id The File ID
 * @apiParam {Number} translationId The FileTranslations ID
 * @apiDescription      Get the specified file translation from database
 * @apiUse              FileTranslation
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/files/1/translations/1
 */
/**
 * @api                 {post} /admin/files/:id/translations 3. POST newly created entity
 * @apiVersion          0.1.0
 * @apiName             PostFileTranslation
 * @apiGroup            File Translations
 * @apiPermission       admin
 * @apiParam {Number} id The File ID
 * @apiDescription      Stores newly created file translation in database
 * @apiUse              FileTranslation
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/files/1/translations
 */
/**
 * @api                 {put} /admin/files/:id/translations 4. PUT newly created revision
 * @apiVersion          0.1.0
 * @apiName             PutFileTranslation
 * @apiGroup            File Translations
 * @apiPermission       admin
 * @apiParam {Number} id The File ID
 * @apiDescription      Each translations update always creates new record in database, for history revision
 * @apiUse              FileTranslation
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/files/1/translations
 */
/**
 * @api                 {delete} /admin/files/:id/translations/:id  5. DELETE the specified entity
 * @apiVersion          0.1.0
 * @apiName             DeleteFileTranslation
 * @apiGroup            File Translations
 * @apiPermission       admin
 * @apiParam {Number} id The File ID
 * @apiParam {Number} translationId The FileTranslations ID
 * @apiDescription      Deletes the specified file translation from database
 * @apiSuccess {Boolean} success Success flag
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/files/1/translations/1
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 * {"success":true}
 */

/**
 * @apiDefine           FileTranslationCollection
 * @apiSuccess {Array[]} translations List of active translations (Array of Objects)
 * @apiSuccess {Number} data.id Translation id
 * @apiSuccess {String} data.lang Language code
 * @apiSuccess {String} data.title Title
 * @apiSuccess {String} data.description Description
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
 *        "link": "http://api.gzero.dev:8000/v1/admin/files/1/translations"
 *    },
 *    "params": {
 *        "page": 1,
 *        "perPage": 20,
 *        "filter": [],
 *        "orderBy": []
 *    },
 *    "data": [
 *        {FileTranslations},
 *        ...
 *    ]
 *}
 */

/**
 * @apiDefine           FileTranslation
 * @apiSuccess {Number} id Translation id
 * @apiSuccess {String} lang Language code
 * @apiSuccess {String} title Title
 * @apiSuccess {String} description Description
 * @apiSuccess {Date} createdAt Creation date of translation
 * @apiSuccess {Date} updatedAt Update date of translation
 *
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 *{
 *   "id": 1,
 *   "lang": "en",
 *   "title": "Example file title",
 *   "description": "Example file description",
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
