<?php

namespace Api;

class AdminFileCest {
    /**
     * @var string base url
     */
    protected $url = 'http://api.localhost/v1/admin/';

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
        $I->sendGET($this->url . 'files');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'meta'   => [
                    'total'       => $filesNumber,
                    'perPage'     => 20,
                    'currentPage' => 1,
                    'lastPage'    => 1,
                    'link'        => $this->url . 'files',
                ],
                'params' => [
                    'page'    => 1,
                    'perPage' => 20,
                    'filter'  => [],
                ],
            ]
        );
    }

    public function getFilesUsingSearch(FunctionalTester $I)
    {
        $I->wantTo('get list of files as admin user using query param');
        $I->loginAsAdmin();
        $I->haveFile(['name' => 'test file name', 'is_active' => true]);
        $I->haveFile(['name' => 'test2 file name', 'is_active' => false]);
        $I->sendGET($this->url . 'files', ['q' => 'file n']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'meta' => [
                    'total'       => 2,
                    'currentPage' => 1,
                    'lastPage'    => 1,
                    'link'        => $this->url . 'files',
                ]
            ]
        );

        // With filter
        $I->sendGET($this->url . 'files', ['q' => 'file n', 'is_active' => 1]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'meta' => [
                    'total'       => 1,
                    'currentPage' => 1,
                    'lastPage'    => 1,
                    'link'        => $this->url . 'files',
                ]
            ]
        );

        // Not found test
        $I->sendGET($this->url . 'files', ['q' => 'fsdsdsd']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'meta' => [
                    'total'       => 0,
                    'currentPage' => 1,
                    'lastPage'    => 0,
                    'link'        => $this->url . 'files',
                ]
            ]
        );
    }

    public function getContentFiles(FunctionalTester $I)
    {
        $I->wantTo('get list of content files as admin user');
        $I->loginAsAdmin();
        $user      = $I->haveUser();
        $content   = $I->haveContent();
        $otherFile = $I->haveFile(false, $user);
        $fileIds   = [];
        for ($i = 0; $i < 4; $i++) {
            $fileIds[] = $I->haveFile(false, $user)->id;
        }
        $content->files()->sync($fileIds);

        $I->sendGET($this->url . 'contents/' . $content->id . '/files');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'meta'   => [
                    'total'       => count($fileIds),
                    'perPage'     => 20,
                    'currentPage' => 1,
                    'lastPage'    => 1,
                    'link'        => $this->url . 'contents/' . $content->id . '/files',
                ],
                'params' => [
                    'page'    => 1,
                    'perPage' => 20,
                    'filter'  => [],
                ],
                'data'   => [
                    [
                        'id'        => $fileIds[0],
                        'type'      => 'image',
                        'createdBy' => $user->id,
                        'isActive'  => true,
                        'weight'    => 0
                    ],
                    [
                        'id'        => $fileIds[1],
                        'type'      => 'image',
                        'createdBy' => $user->id,
                        'isActive'  => true,
                        'weight'    => 0
                    ],
                    [
                        'id'        => $fileIds[2],
                        'type'      => 'image',
                        'createdBy' => $user->id,
                        'isActive'  => true,
                        'weight'    => 0
                    ],
                    [
                        'id'        => $fileIds[3],
                        'type'      => 'image',
                        'createdBy' => $user->id,
                        'isActive'  => true,
                        'weight'    => 0
                    ],
                ]
            ]
        );
    }

    public function getBlockFiles(FunctionalTester $I)
    {
        $I->wantTo('get list of block files as admin user');
        $I->loginAsAdmin();
        $user      = $I->haveUser();
        $block     = $I->haveBlock();
        $otherFile = $I->haveFile(false, $user);
        $fileIds   = [];
        for ($i = 0; $i < 4; $i++) {
            $fileIds[] = $I->haveFile(false, $user)->id;
        }
        $block->files()->sync($fileIds);
        $I->sendGET($this->url . 'blocks/' . $block->id . '/files');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'meta'   => [
                    'total'       => count($fileIds),
                    'perPage'     => 20,
                    'currentPage' => 1,
                    'lastPage'    => 1,
                    'link'        => $this->url . 'blocks/' . $block->id . '/files',
                ],
                'params' => [
                    'page'    => 1,
                    'perPage' => 20,
                    'filter'  => [],
                ],
                'data'   => [
                    [
                        'id'        => $fileIds[0],
                        'type'      => 'image',
                        'createdBy' => $user->id,
                        'isActive'  => true,
                        'weight'    => 0
                    ],
                    [
                        'id'        => $fileIds[1],
                        'type'      => 'image',
                        'createdBy' => $user->id,
                        'isActive'  => true,
                        'weight'    => 0
                    ],
                    [
                        'id'        => $fileIds[2],
                        'type'      => 'image',
                        'createdBy' => $user->id,
                        'isActive'  => true,
                        'weight'    => 0
                    ],
                    [
                        'id'        => $fileIds[3],
                        'type'      => 'image',
                        'createdBy' => $user->id,
                        'isActive'  => true,
                        'weight'    => 0
                    ],
                ]
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
            $this->url . 'files/' . $file->id
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
        $tWidth    = config('gzero.image.thumb.width');
        $tHeight   = config('gzero.image.thumb.height');
        $thumbPath = $I->grabDataFromResponseByJsonPath('thumb')[0];
        $I->assertRegExp('/images\/example-' . $tWidth . 'x' . $tHeight . '\.png\?token=.+$/', $thumbPath);
    }

    public function checksIfFileExistsWhenGetting(FunctionalTester $I)
    {
        $I->wantTo('checks for file when getting file as admin user');
        $I->loginAsAdmin();
        $I->sendPUT($this->url . 'files/1');
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
            $this->url . 'files',
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
            $this->url . 'files',
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
        $user            = $I->haveUser();
        $file            = $I->haveFile(false, $user);
        $fileTranslation = $file->translations()->first();
        $I->sendPUT(
            $this->url . 'files/' . $file->id,
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
        $tWidth    = config('gzero.image.thumb.width');
        $tHeight   = config('gzero.image.thumb.height');
        $thumbPath = $I->grabDataFromResponseByJsonPath('thumb')[0];
        $I->assertRegExp('/images\/example-' . $tWidth . 'x' . $tHeight . '\.png\?token=.+$/', $thumbPath);
    }

    public function checksIfFileExistsWhenUpdating(FunctionalTester $I)
    {
        $I->wantTo('checks for file when updating file as admin user');
        $I->loginAsAdmin();
        $I->sendPUT($this->url . 'files/1');
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
        $I->sendDelete($this->url . 'files/' . $file->id);
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
        $I->sendDelete($this->url . 'files/1');
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
            $this->url . 'files',
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

    public function syncFilesWithContent(FunctionalTester $I)
    {
        $I->wantTo('sync file with content as admin user');
        $I->loginAsAdmin();
        $content = $I->haveContent();
        $file1   = $I->haveFile();
        $file2   = $I->haveFile();
        $I->sendPUT(
            $this->url . 'contents/' . $content->id . '/files/sync',
            [
                'data' => [
                    ['id' => $file1->id],
                    ['id' => $file2->id, 'weight' => 1337]
                ]
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'attached' => [$file1->id, $file2->id],
                'detached' => [],
                'updated'  => []
            ]
        );

        // Check if we'll get correct files
        $I->sendGET($this->url . 'contents/' . $content->id . '/files');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                [
                    'id'     => $file1->id,
                    'weight' => 0
                ],
                [
                    'id'     => $file2->id,
                    'weight' => 1337
                ],
            ]
        );

        // Updating weight & detaching
        $I->sendPUT(
            $this->url . 'contents/' . $content->id . '/files/sync',
            [
                'data' => [
                    ['id' => $file1->id, 'weight' => 13, 'unexpected_property' => 321]
                ]
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'attached' => [],
                'detached' => [1 => $file2->id], // @TODO Why key starts from 1?
                'updated'  => [$file1->id]
            ]
        );

        // Check if we'll get correct files
        $I->sendGET($this->url . 'contents/' . $content->id . '/files');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'id'     => $file1->id,
                'weight' => 13
            ]
        );
        $I->dontSeeResponseContainsJson(
            [
                'id'     => $file2->id,
                'weight' => 1337
            ]
        );
    }

    public function detachAllFilesFromContent(FunctionalTester $I)
    {
        $I->wantTo('detach all files from content as admin user');
        $I->loginAsAdmin();

        // Setup
        $content = $I->haveContent();
        $file1   = $I->haveFile();
        $file2   = $I->haveFile();
        $I->sendPUT(
            $this->url . 'contents/' . $content->id . '/files/sync',
            [
                'data' => [
                    ['id' => $file1->id],
                    ['id' => $file2->id, 'weight' => 1337]
                ]
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'attached' => [$file1->id, $file2->id],
                'detached' => [],
                'updated'  => []
            ]
        );

        // Test
        $I->sendPUT(
            $this->url . 'contents/' . $content->id . '/files/sync',
            [
                'data' => []
            ]
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'attached' => [],
                'detached' => [$file1->id, $file2->id],
                'updated'  => []
            ]
        );
    }

    public function fileSyncShouldAllowOnlyArray(FunctionalTester $I)
    {
        $I->wantTo('check if only array is allowed in files sync endpoints');
        $I->loginAsAdmin();

        // Setup
        $content = $I->haveContent();
        $block   = $I->haveBlock();

        // Test
        $I->sendPUT(
            $this->url . 'contents/' . $content->id . '/files/sync',
            [
                'data' => 'test'
            ]
        );
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'error' => [
                    'message' => 'Validation Error',
                    'errors'  => ['data' => ['The data must be an array.']]
                ],
            ]
        );

        $I->sendPUT(
            $this->url . 'blocks/' . $block->id . '/files/sync',
            [
                'data' => 'test'
            ]
        );
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'error' => [
                    'message' => 'Validation Error',
                    'errors'  => ['data' => ['The data must be an array.']]
                ],
            ]
        );
    }

    public function shouldDisplayUsefulErrorWhenDataIsMissing(FunctionalTester $I)
    {
        $I->wantTo('see useful error when data param is missing in sync request');
        $I->loginAsAdmin();

        // Setup
        $content = $I->haveContent();
        $block   = $I->haveBlock();

        // Test
        $I->sendPUT(
            $this->url . 'contents/' . $content->id . '/files/sync',
            []
        );
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'error' => [
                    'message' => 'Validation Error',
                    'errors'  => ['data' => ['The data field must be present.']]
                ],
            ]
        );

        $I->sendPUT(
            $this->url . 'blocks/' . $block->id . '/files/sync',
            []
        );
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'error' => [
                    'message' => 'Validation Error',
                    'errors'  => ['data' => ['The data field must be present.']]
                ],
            ]
        );
    }

    public function syncFilesWithBlock(FunctionalTester $I)
    {
        $I->wantTo('sync file with block as admin user');
        $I->loginAsAdmin();
        $block = $I->haveBlock();
        $file1 = $I->haveFile();
        $file2 = $I->haveFile();
        $I->sendPUT(
            $this->url . 'blocks/' . $block->id . '/files/sync',
            [
                'data' => [
                    ['id' => $file1->id],
                    ['id' => $file2->id, 'weight' => 1337]
                ]
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'attached' => [$file1->id, $file2->id],
                'detached' => [],
                'updated'  => []
            ]
        );

        // Check if we'll get correct files
        $I->sendGET($this->url . 'blocks/' . $block->id . '/files');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                [
                    'id'     => $file1->id,
                    'weight' => 0
                ],
                [
                    'id'     => $file2->id,
                    'weight' => 1337
                ],
            ]
        );

        // Updating weight & detaching
        $I->sendPUT(
            $this->url . 'blocks/' . $block->id . '/files/sync',
            [
                'data' => [
                    ['id' => $file1->id, 'weight' => 13, 'unexpected_property' => 321]
                ]
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'attached' => [],
                'detached' => [1 => $file2->id], // @TODO Why key starts from 1?
                'updated'  => [$file1->id]
            ]
        );

        // Check if we'll get correct files
        $I->sendGET($this->url . 'blocks/' . $block->id . '/files');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'id'     => $file1->id,
                'weight' => 13
            ]
        );
        $I->dontSeeResponseContainsJson(
            [
                'id'     => $file2->id,
                'weight' => 1337
            ]
        );
    }

    public function detachAllFilesFromBlock(FunctionalTester $I)
    {
        $I->wantTo('detach all files from block as admin user');
        $I->loginAsAdmin();

        // Setup
        $block = $I->haveBlock();
        $file1 = $I->haveFile();
        $file2 = $I->haveFile();
        $I->sendPUT(
            $this->url . 'blocks/' . $block->id . '/files/sync',
            [
                'data' => [
                    ['id' => $file1->id],
                    ['id' => $file2->id, 'weight' => 1337]
                ]
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'attached' => [$file1->id, $file2->id],
                'detached' => [],
                'updated'  => []
            ]
        );

        // Test
        $I->sendPUT(
            $this->url . 'blocks/' . $block->id . '/files/sync',
            [
                'data' => []
            ]
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'attached' => [],
                'detached' => [$file1->id, $file2->id],
                'updated'  => []
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
            $this->url . 'files/' . $file->id . '/translations',
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
            $this->url . 'files/' . $file->id . '/translations/en',
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
            $this->url . 'files/' . $file->id . '/translations/' . $fileTranslation->id
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
