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
     * @api                 {get} /admin/contents/:id/translations Read collection of all translations
     * @apiVersion          0.1.0
     * @apiName             GetContentTranslationsList
     * @apiGroup            Content
     * @apiDescription      Read all content translations
     * @apiSuccess {Integer} count Number of all content translations
     * @apiSuccess {Array} data Collection of content translations (Array of Objects)
     * @apiExample          Example usage:
     * curl -i http://api.example.com/v1/admin/contents/1/translations
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
