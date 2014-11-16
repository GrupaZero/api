<?php namespace Gzero\Api\Controller;

use Gzero\Repository\LangRepository;
use Gzero\Core\EntitySerializer;
use Illuminate\Support\Collection;

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
     * @api                 {get} /langs Read collection of languages
     * @apiVersion          0.1.0
     * @apiName             GetLangList
     * @apiGroup            Language
     * @apiDescription      Read all languages
     * @apiSuccess {Integer} count Number of all langs
     * @apiSuccess {Array} data Collection of langs (Array of Objects)
     * @apiExample          Example usage:
     * curl -i http://api.example.com/v1/langs
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $langs = $this->langRepo->getAll();
        return $this->respondWithSuccess(
            [
                'total' => $langs->count(),
                'data'  => $langs
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $code Lang code
     *
     * @api                 {get} /langs/:code Read single language
     * @apiVersion          0.1.0
     * @apiName             GetLang
     * @apiGroup            Language
     * @apiDescription      Read a single language by passing lang code
     * @apiParam {String} code Lang unique code
     * @apiSuccessStructure Lang
     * @apiExample          Example usage:
     * curl -i http://api.example.com/v1/langs/en
     *
     * @return Response
     */
    public function show($code)
    {
        $lang = $this->langRepo->getByCode($code);
        if (empty($lang)) {
            return $this->respondNotFound();
        }
        return $this->respondWithSuccess($lang);
    }

}

/**
 * @apiDefineSuccessStructure Lang
 * @apiSuccess {String} code Lang code
 * @apiSuccess {String} i18n Lang i18n code
 * @apiSuccess {Boolean} is_enabled Flag if language is enabled
 * @apiSuccess {Boolean} is_default Flag if language is default
 */
