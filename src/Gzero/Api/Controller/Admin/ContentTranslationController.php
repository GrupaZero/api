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
}

/*
|--------------------------------------------------------------------------
| START API DOCS
|--------------------------------------------------------------------------
*/

/**
 * @apiDefine ContentTranslationCollection
 * @apiSuccess {Array[]} translations List of active translations (Array of Objects)
 * @apiSuccess {Number} translations.langCode Language code
 * @apiSuccess {String} translations.title Title
 * @apiSuccess {String} translations.body Body
 * @apiSuccess {Boolean} translations.isActive Is active flag
 * @apiSuccess {Date} translations.createdAt Creation date of translation
 * @apiSuccess {Date} translations.updatedAt Update date of translation
 */

/*
|--------------------------------------------------------------------------
| END API DOCS
|--------------------------------------------------------------------------
*/
