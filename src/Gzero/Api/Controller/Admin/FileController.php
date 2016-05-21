<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\FileTransformer;
use Gzero\Api\Validator\FileValidator;
use Gzero\Repository\FileRepository;
use Gzero\Repository\RepositoryException;
use Gzero\Api\UrlParamsProcessor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

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
     */
    public function __construct(UrlParamsProcessor $processor, FileRepository $file, FileValidator $validator)
    {
        parent::__construct($processor);
        $this->validator = $validator->setData(\Input::all());
        $this->fileRepo  = $file;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
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
        if (empty($file)) {
            return $this->respondNotFound();
        } else {
            return $this->respondWithSuccess($file, new FileTransformer);
        }
    }

    /**
     * Stores newly created file in database.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $input = $this->validator->validate('create');
        if (Input::hasFile('file')) {
            $uploadedFile = Input::file('file');
            if ($uploadedFile->isValid()) {
                try {
                    $file = $this->fileRepo->create($input, $uploadedFile, auth()->user());
                    return $this->respondWithSuccess($file, new FileTransformer);
                } catch (RepositoryException $e) {
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
            $file->delete();
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
 * @api                 {get} /files 1. GET collection of categories
 * @apiVersion          0.1.0
 * @apiName             GetFileCategories
 * @apiGroup            Files
 * @apiPermission       admin
 * @apiDescription      Get all file categories
 * @apiUse              FileCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/files
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
 * @api                 {get} /files/:category 2. GET category files
 * @apiVersion          0.1.0
 * @apiName             GetFiles
 * @apiGroup            Files
 * @apiPermission       admin
 * @apiDescription      Get all files within the given category
 * @apiParam {String}   key category unique key
 * @apiUse              File
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/files/general
 * @apiSuccessExample   Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "defaultPageSize": {
 *         "en": 5,
 *         "pl": 5
 *       },
 *       "siteDesc": {
 *         "en": "File management system.",
 *         "pl": "File management system."
 *       }
 *       "siteName": {
 *         "en": "G-ZERO CMS",
 *         "pl": "G-ZERO CMS"
 *       },
 *     }
 *
 */

/**
 * @api                 {put} /files/:category 3. PUT category files
 * @apiVersion          0.1.0
 * @apiName             UpdateFiles
 * @apiGroup            Files
 * @apiPermission       admin
 * @apiDescription      Update selected file within the given category
 * @apiParam {String}   key file unique key
 * @apiParam {String}   value file value
 * @apiUse              File
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/files/general
 * @apiSuccessExample   Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "defaultPageSize": {
 *         "en": 5,
 *         "pl": 5
 *       },
 *       "siteDesc": {
 *         "en": "File management system.",
 *         "pl": "File management system."
 *       }
 *       "siteName": {
 *         "en": "G-ZERO CMS",
 *         "pl": "G-ZERO CMS"
 *       },
 *     }
 *
 */

/**
 * @apiDefine File
 * @apiSuccess {obj} data obj of all files in category
 */

/**
 * @apiDefine FileCollection
 * @apiSuccess {Array[]} data Array of all files categories
 * @apiSuccess {String} data.key file key
 */

/*
|--------------------------------------------------------------------------
| END API DOCS
|--------------------------------------------------------------------------
*/
