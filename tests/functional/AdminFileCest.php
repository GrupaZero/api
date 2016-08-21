<?php
namespace api;

use Illuminate\Support\Facades\Storage;

class AdminFileCest {
    /**
     * @var string endpoint url
     */
    protected $url = 'http://api.localhost/v1/admin/files';

    public function _before(FunctionalTester $I)
    {
        $I->logout();
    }

    public function _after(FunctionalTester $I)
    {
        $dirName = config('gzero.upload.directory');
        if ($dirName) {
            Storage::deleteDirectory($dirName);
        }
    }

    /*
     |--------------------------------------------------------------------------
     | START File list tests
     |--------------------------------------------------------------------------
     */

    public function getFiles(FunctionalTester $I)
    {
        $I->wantTo('get list of files as admin user');
        $I->loginAsAdmin();
        $user        = $I->haveUser();
        $filesNumber = 4;
        for ($i = 0; $i < $filesNumber; $i++) {
            $I->haveFile(false, $user);
        }
        $I->sendGET($this->url);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'meta'   => [
                    'total'       => $filesNumber,
                    'perPage'     => 20,
                    'currentPage' => 1,
                    'lastPage'    => 1,
                    'link'        => $this->url,
                ],
                'params' => [
                    'page'    => 1,
                    'perPage' => 20,
                    'filter'  => [],
                ],
            ]
        );
    }

    public function getSingleFile(FunctionalTester $I)
    {
        $I->wantTo('get single file as admin user');
        $I->loginAsAdmin();
        $user            = $I->haveUser();
        $file            = $I->haveFile(false, $user);
        $fileTranslation = $file->translations()->first();
        $I->sendGet(
            $this->url . '/' . $file->id
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'type'         => $file->type,
                'info'         => $file->info,
                'name'         => $file->name,
                'extension'    => $file->extension,
                'size'         => $file->size,
                'mimeType'     => $file->mimeType,
                'url'          => $file->getUrl(),
                'isActive'     => (bool) $file->isActive,
                'createdBy'    => $user->id,
                'translations' => [
                    [
                        'langCode'    => $fileTranslation->langCode,
                        'title'       => $fileTranslation->title,
                        'description' => $fileTranslation->description,
                    ]
                ]
            ]
        );
    }

    public function checksIfFileExistsWhenGetting(FunctionalTester $I)
    {
        $I->wantTo('checks for file when getting file as admin user');
        $I->loginAsAdmin();
        $I->sendPUT($this->url . '/1');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 404,
                'message' => "Not found!",
            ]
        );
    }

    /*
     |--------------------------------------------------------------------------
     | END File list tests
     |--------------------------------------------------------------------------
     */

    /*
     |--------------------------------------------------------------------------
     | START File tests
     |--------------------------------------------------------------------------
     */

    public function createFile(FunctionalTester $I)
    {
        $uploadedFile = $I->getExampleFile();
        $I->wantTo('create file as admin user');
        $I->loginAsAdmin();
        $I->sendPOST(
            $this->url,
            [
                'type'         => 'image',
                'info'         => ['option' => 'value'],
                'isActive'     => 1,
                'translations' => [
                    'langCode'    => 'en',
                    'title'       => 'Example file title',
                    'description' => 'Example file description',
                ]
            ],
            ['file' => $uploadedFile]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'type'         => 'image',
                'info'         => ['option' => 'value'],
                'name'         => 'example',
                'extension'    => 'png',
                'size'         => '5148',
                'mimeType'     => 'image/png',
                'isActive'     => true,
                'createdBy'    => 1, // admin user id
                'translations' =>
                    [
                        0 =>
                            [
                                'langCode'    => 'en',
                                'title'       => 'Example file title',
                                'description' => 'Example file description',
                            ],
                    ],
            ]

        );
    }

    public function createFileWithoutTranslations(FunctionalTester $I)
    {
        $uploadedFile = $I->getExampleFile();
        $I->wantTo('create file without translations as admin user');
        $I->loginAsAdmin();
        $I->sendPOST(
            $this->url,
            [
                'type'     => 'image',
                'info'     => ['option' => 'value'],
                'isActive' => 1
            ],
            ['file' => $uploadedFile]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'type'      => 'image',
                'info'      => ['option' => 'value'],
                'name'      => 'example',
                'extension' => 'png',
                'size'      => '5148',
                'mimeType'  => 'image/png',
                'isActive'  => true,
                'createdBy' => 1, // admin user id
            ]

        );
    }

    public function UpdateFile(FunctionalTester $I)
    {
        $I->wantTo('update file as admin user');
        $I->loginAsAdmin();
        $user            = $I->haveUser();
        $file            = $I->haveFile(false, $user);
        $fileTranslation = $file->translations()->first();
        $I->sendPUT(
            $this->url . '/' . $file->id,
            [
                'info'     => ['option' => 'new value'],
                'isActive' => false,
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'type'         => $file->type,
                'info'         => ['option' => 'new value'],
                'name'         => $file->name,
                'extension'    => $file->extension,
                'size'         => $file->size,
                'mimeType'     => $file->mimeType,
                'url'          => $file->getUrl(),
                'isActive'     => false,
                'createdBy'    => $user->id,
                'translations' => [
                    [
                        'langCode'    => $fileTranslation->langCode,
                        'title'       => $fileTranslation->title,
                        'description' => $fileTranslation->description,
                    ]
                ]
            ]
        );
    }

    public function checksIfFileExistsWhenUpdating(FunctionalTester $I)
    {
        $I->wantTo('checks for file when updating file as admin user');
        $I->loginAsAdmin();
        $I->sendPUT($this->url . '/1');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 404,
                'message' => "Not found!",
            ]
        );
    }

    public function DeleteFile(FunctionalTester $I)
    {
        $I->wantTo('delete file as admin user');
        $I->loginAsAdmin();
        $user = $I->haveUser();
        $file = $I->haveFile(false, $user);
        $I->sendDelete($this->url . '/' . $file->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'success' => true,
            ]
        );
    }

    public function checksIfFileExistsWhenDeleting(FunctionalTester $I)
    {
        $I->wantTo('check for file when delete file as admin user');
        $I->loginAsAdmin();
        $I->sendDelete($this->url . '/1');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 404,
                'message' => "Not found!",
            ]
        );
    }

    public function checksTypeWhenCreatingFile(FunctionalTester $I)
    {
        $I->wantTo('check for type when creating file as admin user');
        $I->loginAsAdmin();
        $I->sendPOST(
            $this->url,
            [
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Example file title',
                    'body'     => 'Example file body'
                ]
            ]
        );
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 400,
                'message' => 'Validation Error',
                'errors'  =>
                    [
                        'type' =>
                            [
                                0 => 'The type field is required.',
                            ],
                    ],

            ]
        );
    }

    /*
     |--------------------------------------------------------------------------
     | END File tests
     |--------------------------------------------------------------------------
     */

    /*
     |--------------------------------------------------------------------------
     | START File translations tests
     |--------------------------------------------------------------------------
     */

    public function CreateFileTranslations(FunctionalTester $I)
    {
        $I->wantTo('create file translations as admin user');
        $I->loginAsAdmin();
        $user = $I->haveUser();
        $file = $I->haveFile(false, $user);
        $I->sendPost(
            $this->url . '/' . $file->id . '/translations',
            [
                'langCode'    => 'en',
                'title'       => 'New file title',
                'description' => 'New file description',
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [

                'langCode'    => 'en',
                'title'       => 'New file title',
                'description' => 'New file description',
            ]
        );
    }

    public function UpdateFileTranslations(FunctionalTester $I)
    {
        $I->wantTo('update file translations as admin user');
        $I->loginAsAdmin();
        $user = $I->haveUser();
        $file = $I->haveFile(false, $user);
        $I->sendPUT(
            $this->url . '/' . $file->id . '/translations/en',
            [
                'langCode'    => 'en',
                'title'       => 'Modified file title',
                'description' => 'Modified file description',
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [

                'langCode'    => 'en',
                'title'       => 'Modified file title',
                'description' => 'Modified file description',
            ]
        );
    }

    public function DeleteFileTranslations(FunctionalTester $I)
    {
        $I->wantTo('delete file translations as admin user');
        $I->loginAsAdmin();
        $user            = $I->haveUser();
        $file            = $I->haveFile(false, $user);
        $fileTranslation = $file->translations()->first();
        $I->sendDELETE(
            $this->url . '/' . $file->id . '/translations/' . $fileTranslation->id
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'success' => true,
            ]
        );
    }

    /*
     |--------------------------------------------------------------------------
     | END File translations tests
     |--------------------------------------------------------------------------
     */
}
