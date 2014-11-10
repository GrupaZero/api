<?php namespace Gzero\Api\Controller;

use Gzero\Repository\LangRepository;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Core\EntitySerializer;

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

    protected $processor;

    protected $langRepo;

    protected $entitySerializer;

    /**
     * ContentController constructor
     *
     * @param LangRepository     $lang             Content repo
     * @param UrlParamsProcessor $processor        Url processor
     * @param EntitySerializer   $entitySerializer Entity serializer
     */
    public function __construct(LangRepository $lang, UrlParamsProcessor $processor, EntitySerializer $entitySerializer)
    {
        $this->langRepo         = $lang;
        $this->processor        = $processor;
        $this->entitySerializer = $entitySerializer;
    }

    /**
     * Display a listing of the resource.
     *
     * @api        {get} /langs Get list
     * @apiVersion 0.1.0
     * @apiName    GetLangList
     * @apiGroup   Lang
     * @apiExample Example usage:
     * curl -i http://localhost/api/v1/langs
     * @apiSuccess {Array} data List of langs (Array of Objects)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // $page    = $this->processor->getPage();
        $orderBy = $this->processor->getOrderByParams();
        //if ($id) { // content/n/children
        //    $content = $this->langRepo->getById($id);
        //    if (!empty($content)) {
        //        return
        //            $this->respondWithSuccess(
        //                [
        //                    'data' => $this->langRepo->getChildren($content, [], $orderBy),
        //                    // 'total' => $this->contentRepo->getLastTotal()
        //                ]
        //            );
        //    } else {
        //        return $this->respondNotFound();
        //    }
        //}

        return $this->respondWithSuccess(
            [
                'data' => $this->langRepo->getRootContents($orderBy),
                // 'total' => $this->contentRepo->getLastTotal()
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $code Lang code
     *
     * @api                 {get} /langs/:id Get single lang
     * @apiVersion          0.1.0
     * @apiName             GetLang
     * @apiGroup            Lang
     * @apiDescription      Using this function, you can get a single lang
     * @apiExample          Example usage:
     * curl -i http://localhost/api/v1/langs/123
     * @apiParam {Number} id Lang unique ID.
     * @apiSuccessStructure Lang
     *
     * @return Response
     */
    public function show($code)
    {
        $lang = $this->langRepo->getByCode($code);
        if (empty($lang)) {
            return $this->respondNotFound();
        }

        return $this->respondWithSuccess(
            [
                'data' => $this->entitySerializer->toArray($lang)
            ]
        );
    }

}

/**
 * @apiDefineSuccessStructure Lang
 * @apiSuccess {String} code Lang code
 * @apiSuccess {String} i18n Lang i18n code
 * @apiSuccess {Boolean} isEnabled Flag if language is enabled
 * @apiSuccess {Boolean} isDefault Flag if language is default
 */
