<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Entity\File;
use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\FileTransformer;
use Gzero\Api\Validator\FileValidator;
use Gzero\Repository\FileRepository;
use Gzero\Repository\RepositoryValidationException;
use Gzero\Api\UrlParamsProcessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class FileController
 *
 * @package    Gzero\Admin\Controllers\Resource
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class FileController extends ApiController {

    /**
     * @var FileRepository
     */
    protected $fileRepo;

    /**
     * @var FileValidator
     */
    protected $validator;

    /**
     * FileController constructor.
     *
     * @param UrlParamsProcessor $processor Url processor
     * @param FileRepository     $file      File repository
     * @param FileValidator      $validator File validator
     * @param Request            $request   Request object
     */
    public function __construct(
        UrlParamsProcessor $processor,
        FileRepository $file,
        FileValidator $validator,
        Request $request
    ) {
        parent::__construct($processor);
        $this->validator = $validator->setData($request->all());
        $this->fileRepo  = $file;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $this->authorize('readList', File::class);
        $input   = $this->validator->validate('list');
        $params  = $this->processor->process($input)->getProcessedFields();
        $results = $this->fileRepo->getFiles(
            $params['filter'],
            $params['orderBy'],
            $params['page'],
            $params['perPage']
        );
        return $this->respondWithSuccess($results, new FileTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id file id
     *
     * @return Response
     */
    public function show($id)
    {
        $file = $this->fileRepo->getById($id);
        if (!empty($file)) {
            $this->authorize('read', $file);
            return $this->respondWithSuccess($file, new FileTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Stores newly created file in database.
     *
     * @param Request $request Request object
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', File::class);
        $input = $this->validator->validate('create');
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            if ($uploadedFile->isValid()) {
                try {
                    $file = $this->fileRepo->create($input, $uploadedFile, auth()->user());
                    return $this->respondWithSuccess($file, new FileTransformer);
                } catch (RepositoryValidationException $e) {
                    return $this->respondWithError($e->getMessage());
                }
            }
        }
        return $this->respondWithError('The file could not be uploaded - invalid or missing file');
    }

    /**
     * Remove the specified file from database.
     *
     * @param int $id Id of the file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $file = $this->fileRepo->getById($id);

        if (!empty($file)) {
            $this->authorize('delete', $file);
            $this->fileRepo->delete($file);
            return $this->respondWithSimpleSuccess(['success' => true]);
        }
        return $this->respondNotFound();
    }

    /**
     * Updates the specified resource in the database.
     *
     * @param int $id File id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $file = $this->fileRepo->getById($id);
        if (!empty($file)) {
            $this->authorize('update', $file);
            $input = $this->validator->validate('update');
            $file  = $this->fileRepo->update($file, $input, Auth::user());
            return $this->respondWithSuccess($file, new FileTransformer);
        }
        return $this->respondNotFound();
    }

}

/*
|--------------------------------------------------------------------------
| START API DOCS
|--------------------------------------------------------------------------
*/

/**
 * @api                 {get} /admin/files 1. GET collection of entities
 * @apiVersion          0.1.0
 * @apiName             GetFileList
 * @apiGroup            File
 * @apiPermission       admin
 * @apiDescription      Get root files
 * @apiUse              Meta
 * @apiUse              Params
 * @apiUse              FileCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/files
 */

/**
 * @api                 {get} /admin/files/:id 2. GET single entity
 * @apiVersion          0.1.0
 * @apiName             GetFile
 * @apiGroup            File
 * @apiPermission       admin
 * @apiDescription      Get the specified file from database
 * @apiUse              File
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/files/123
 */
/**
 * @api                 {post} /admin/files 3. POST newly created entity
 * @apiVersion          0.1.0
 * @apiName             PostFile
 * @apiGroup            File
 * @apiPermission       admin
 * @apiDescription      Store newly created file in database
 * @apiUse              File
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/files
 */
/**
 * @api                 {put} /admin/files 4. PUT the specified entity
 * @apiVersion          0.1.0
 * @apiName             PutFile
 * @apiGroup            File
 * @apiPermission       admin
 * @apiDescription      Update the specified file in database
 * @apiUse              File
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/files
 */
/**
 * @api                 {delete} /admin/files 5. DELETE the specified entity
 * @apiVersion          0.1.0
 * @apiName             DeleteFile
 * @apiGroup            File
 * @apiPermission       admin
 * @apiDescription      Delete the specified file from database
 * @apiSuccess {Boolean} success Success flag
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/files
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 * {"success":true}
 */

/**
 * @apiDefine           File
 * @apiSuccess {Number} id File id
 * @apiSuccess {String} type File type
 * @apiSuccess {String} extension File extension
 * @apiSuccess {number} size File size
 * @apiSuccess {String} mimeType File mimeType
 * @apiSuccess {Array} info File unique parameters (Defined as array of key / value parameters)
 * @apiSuccess {String} url File url
 * @apiSuccess {Boolean} isActive Is file active flag
 * @apiSuccess {number} data.createdBy  User id of this File author
 * @apiSuccess {Date} createdAt Creation date
 * @apiSuccess {Date} updatedAt Update date
 * @apiSuccess {Array} Translations List of active translations (Array of Objects)
 *
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 *       {
 *           "id": 61,
 *           "type": "image",
 *           "name": "test",
 *           "extension": "jpg",
 *           "size": 1239876,
 *           "mimeType": "image/jpeg",
 *           "info": null,
 *           "url": "http://api.dev.gzero.pl:8000/uploads/images/test.jpg",
 *           "isActive": true,
 *           "createdBy": 1,
 *           "createdAt": "2016-05-27 17:37:01",
 *           "updatedAt": "2016-05-27 17:37:01",
 *           "translations": [
 *               {
 *                   "id": 64,
 *                   "langCode": "en",
 *                   "title": "test image",
 *                   "description": "",
 *                   "createdAt": "2016-05-27 17:37:01",
 *                   "updatedAt": "2016-05-27 17:37:01"
 *               }
 *           ]
 *       }
 *   ]
 *}
 */

/**
 * @apiDefine           FileCollection
 * @apiSuccess {Array[]} data Array of Files
 * @apiSuccess {Number} data.id File id
 * @apiSuccess {String} data.type File type
 * @apiSuccess {String} data.extension File extension
 * @apiSuccess {String} data.size File size
 * @apiSuccess {String} data.mimeType File mimeType
 * @apiSuccess {Array} data.info File unique parameters (Defined as array of key / value parameters)
 * @apiSuccess {String} data.url File url
 * @apiSuccess {Boolean} data.isActive Is file active flag
 * @apiSuccess {number} data.createdBy  User id of this File author
 * @apiSuccess {Date} data.createdAt Creation date
 * @apiSuccess {Date} data.updatedAt Update date
 * @apiSuccess {Array} data.Translations List of active translations (Array of Objects)
 *
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 *{
 *        "meta": {
 *        "total": 75,
 *        "perPage": 20,
 *        "currentPage": 1,
 *        "lastPage": 4,
 *        "link": "http://api.gzero.dev:8000/v1/admin/files"
 *    },
 *    "params": {
 *        "page": 1,
 *        "perPage": 20,
 *        "filter": [],
 *        "orderBy": []
 *    },
 *    "data": [
 *        {File},
 *        ...
 *    ]
 *}
 */

/*
|--------------------------------------------------------------------------
| END API DOCS
|--------------------------------------------------------------------------
*/
