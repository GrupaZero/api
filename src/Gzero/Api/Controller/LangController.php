<?php namespace Gzero\Api\Controller;

use Gzero\Repository\LangRepository;
use Gzero\Core\EntitySerializer;
use Illuminate\Support\Collection;
use JMS\Serializer\Serializer;

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
     * @var EntitySerializer
     */
    protected $serializer;

    /**
     * ContentController constructor
     *
     * @param LangRepository $lang       Content repo
     * @param Serializer     $serializer Entity serializer
     */
    public function __construct(LangRepository $lang, Serializer $serializer)
    {
        $this->langRepo   = $lang;
        $this->serializer = $serializer;
    }

    /**
     * Display a listing of the resource.
     *
     * @api        {get} /langs Get list
     * @apiVersion 0.1.0
     * @apiName    GetLangList
     * @apiGroup   Lang
     * @apiExample Example usage:
     * curl -i http://api.example.com/v1/langs
     * @apiSuccess {Array} data List of langs (Array of Objects)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $langs = $this->langRepo->getAll();
        return $this->respondWithSuccess(
            [
                'total' => count($langs),
                'data'  => $langs->getValues()
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $code Lang code
     *
     * @api                 {get} /langs/:code Get single
     * @apiVersion          0.1.0
     * @apiName             GetLang
     * @apiGroup            Lang
     * @apiDescription      Using this function, you can get a single lang
     * @apiExample          Example usage:
     * curl -i http://api.example.com/v1/langs/en
     * @apiParam {String} code Lang unique code.
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
                'data' => $lang
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
