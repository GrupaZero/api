<?php

namespace Api;

class AdminFileCest {
    /**
     * @var string endpoint url
     */
    protected $url = 'http://api.localhost/v1/admin/files';

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
        $croppaDir       = config('croppa.url_prefix');
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
                'mimeType'     => $file->mime_type,
                'thumb'        => $croppaDir . 'images/example-729x459.png?token=0c18a40115c0a4158d2a0ede3d746a63',
                'isActive'     => (bool) $file->is_active,
                'createdBy'    => $user->id,
                'translations' => [
                    [
                        'langCode'    => $fileTranslation->lang_code,
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
                'message' => "Not found",
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
                'size'         => 5148,
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

    public function updateFile(FunctionalTester $I)
    {
        $I->wantTo('update file as admin user');
        $I->loginAsAdmin();
        $croppaDir       = config('croppa.url_prefix');
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
                'mimeType'     => $file->mime_type,
                'thumb'        => $croppaDir . 'images/example-729x459.png?token=0c18a40115c0a4158d2a0ede3d746a63',
                'isActive'     => false,
                'createdBy'    => $user->id,
                'translations' => [
                    [
                        'langCode'    => $fileTranslation->lang_code,
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
                'message' => "Not found",
            ]
        );
    }

    public function deleteFile(FunctionalTester $I)
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
                'message' => "Not found",
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
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'error' => [
                    'message' => 'Validation Error',
                    'errors'  => [
                        'type' => [
                            0 => 'The type field is required.',
                        ],
                    ],

                ]
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

    public function createFileTranslations(FunctionalTester $I)
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

    public function updateFileTranslations(FunctionalTester $I)
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

    public function deleteFileTranslations(FunctionalTester $I)
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
