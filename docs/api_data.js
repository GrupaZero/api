define({ api: [
  {
    "type": "get",
    "url": "/blocks/:id",
    "title": "Get single block",
    "version": "0.1.0",
    "name": "GetBlock",
    "group": "Block",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Content unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object[]",
            "field": "translations",
            "optional": false,
            "description": "<p>List of translations (Array of Objects).</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/BlockController.php"
  },
  {
    "type": "get",
    "url": "/blocks/:id",
    "title": "Get single block",
    "version": "0.1.0",
    "name": "GetBlock",
    "group": "Block",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Block unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object[]",
            "field": "rendered",
            "optional": false,
            "description": "<p>view in HTML.</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/BlockController.php"
  },
  {
    "type": "get",
    "url": "/bocks",
    "title": "Get blocks list",
    "version": "0.1.0",
    "name": "GetBlockList",
    "group": "Block",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/api/v1/blocks\n"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "field": "data",
            "optional": false,
            "description": "<p>List of blocks (Array of Objects)</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/BlockController.php"
  },
  {
    "type": "get",
    "url": "/bocks",
    "title": "Get blocks list",
    "version": "0.1.0",
    "name": "GetBlockList",
    "group": "Block",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/api/v1/contents\n"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "field": "data",
            "optional": false,
            "description": "<p>List of blocks (Array of Objects)</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "total",
            "optional": false,
            "description": "<p>Total count of all elements</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/BlockController.php"
  },
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Content id</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "rating",
            "optional": false,
            "description": "<p>Content rating</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "visits",
            "optional": false,
            "description": "<p>Content visit counter</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "field": "translations",
            "optional": false,
            "description": "<p>List of translations (Array of Objects)</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "translations.lang_id",
            "optional": false,
            "description": "<p>Language id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.url",
            "optional": false,
            "description": "<p>Translation url</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.title",
            "optional": false,
            "description": "<p>Title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.body",
            "optional": false,
            "description": "<p>Body</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.seo_title",
            "optional": false,
            "description": "<p>SEO title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.seo_description",
            "optional": false,
            "description": "<p>SEO description</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "translations.is_active",
            "optional": false,
            "description": "<p>Is translation active</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "translations.created_at",
            "optional": false,
            "description": "<p>Creation date of translation</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "translations.updated_at",
            "optional": false,
            "description": "<p>Update date of translation</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_on_home",
            "optional": false,
            "description": "<p>Home page flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_comment_allowed",
            "optional": false,
            "description": "<p>Is comment allowed flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_promoted",
            "optional": false,
            "description": "<p>Is promoted flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_sticky",
            "optional": false,
            "description": "<p>Is sticky flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_active",
            "optional": false,
            "description": "<p>Is content active flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "published_at",
            "optional": false,
            "description": "<p>Date of publication</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "created_at",
            "optional": false,
            "description": "<p>Creation date</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "updated_at",
            "optional": false,
            "description": "<p>Update date</p>"
          }
        ]
      }
    },
    "group": "ContentController.php",
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "src/Gzero/Api/Controller/ContentController.php"
  },
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Content id</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "rating",
            "optional": false,
            "description": "<p>Content rating</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "visits",
            "optional": false,
            "description": "<p>Content visit counter</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "field": "translations",
            "optional": false,
            "description": "<p>List of translations (Array of Objects)</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "translations.lang_id",
            "optional": false,
            "description": "<p>Language id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.url",
            "optional": false,
            "description": "<p>Translation url</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.title",
            "optional": false,
            "description": "<p>Title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.body",
            "optional": false,
            "description": "<p>Body</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.seo_title",
            "optional": false,
            "description": "<p>SEO title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.seo_description",
            "optional": false,
            "description": "<p>SEO description</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "translations.is_active",
            "optional": false,
            "description": "<p>Is translation active</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "translations.created_at",
            "optional": false,
            "description": "<p>Creation date of translation</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "translations.updated_at",
            "optional": false,
            "description": "<p>Update date of translation</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_on_home",
            "optional": false,
            "description": "<p>Home page flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_comment_allowed",
            "optional": false,
            "description": "<p>Is comment allowed flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_promoted",
            "optional": false,
            "description": "<p>Is promoted flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_sticky",
            "optional": false,
            "description": "<p>Is sticky flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_active",
            "optional": false,
            "description": "<p>Is content active flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "published_at",
            "optional": false,
            "description": "<p>Date of publication</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "created_at",
            "optional": false,
            "description": "<p>Creation date</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "updated_at",
            "optional": false,
            "description": "<p>Update date</p>"
          }
        ]
      }
    },
    "group": "ContentController.php",
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "src/Gzero/Api/Controller/Admin/ContentController.php"
  },
  {
    "type": "get",
    "url": "/contents/:id",
    "title": "Get single content",
    "version": "0.1.0",
    "name": "GetContent",
    "group": "Content",
    "description": "<p>Using this function, you can get a single content</p>",
    "examples": [
      {
        "title": "         Example usage:",
        "content": "curl -i http://localhost/api/v1/contents/123\n"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Content unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Content id</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "rating",
            "optional": false,
            "description": "<p>Content rating</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "visits",
            "optional": false,
            "description": "<p>Content visit counter</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "field": "translations",
            "optional": false,
            "description": "<p>List of translations (Array of Objects)</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "translations.lang_id",
            "optional": false,
            "description": "<p>Language id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.url",
            "optional": false,
            "description": "<p>Translation url</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.title",
            "optional": false,
            "description": "<p>Title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.body",
            "optional": false,
            "description": "<p>Body</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.seo_title",
            "optional": false,
            "description": "<p>SEO title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.seo_description",
            "optional": false,
            "description": "<p>SEO description</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "translations.is_active",
            "optional": false,
            "description": "<p>Is translation active</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "translations.created_at",
            "optional": false,
            "description": "<p>Creation date of translation</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "translations.updated_at",
            "optional": false,
            "description": "<p>Update date of translation</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_on_home",
            "optional": false,
            "description": "<p>Home page flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_comment_allowed",
            "optional": false,
            "description": "<p>Is comment allowed flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_promoted",
            "optional": false,
            "description": "<p>Is promoted flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_sticky",
            "optional": false,
            "description": "<p>Is sticky flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_active",
            "optional": false,
            "description": "<p>Is content active flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "published_at",
            "optional": false,
            "description": "<p>Date of publication</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "created_at",
            "optional": false,
            "description": "<p>Creation date</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "updated_at",
            "optional": false,
            "description": "<p>Update date</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/ContentController.php"
  },
  {
    "type": "get",
    "url": "/contents/:id",
    "title": "Get single content",
    "version": "0.1.0",
    "name": "GetContent",
    "group": "Content",
    "description": "<p>Using this function, you can get a single content</p>",
    "examples": [
      {
        "title": "         Example usage:",
        "content": "curl -i http://localhost/api/v1/contents/123\n"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Content unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Content id</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "rating",
            "optional": false,
            "description": "<p>Content rating</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "visits",
            "optional": false,
            "description": "<p>Content visit counter</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "field": "translations",
            "optional": false,
            "description": "<p>List of translations (Array of Objects)</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "translations.lang_id",
            "optional": false,
            "description": "<p>Language id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.url",
            "optional": false,
            "description": "<p>Translation url</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.title",
            "optional": false,
            "description": "<p>Title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.body",
            "optional": false,
            "description": "<p>Body</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.seo_title",
            "optional": false,
            "description": "<p>SEO title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.seo_description",
            "optional": false,
            "description": "<p>SEO description</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "translations.is_active",
            "optional": false,
            "description": "<p>Is translation active</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "translations.created_at",
            "optional": false,
            "description": "<p>Creation date of translation</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "translations.updated_at",
            "optional": false,
            "description": "<p>Update date of translation</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_on_home",
            "optional": false,
            "description": "<p>Home page flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_comment_allowed",
            "optional": false,
            "description": "<p>Is comment allowed flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_promoted",
            "optional": false,
            "description": "<p>Is promoted flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_sticky",
            "optional": false,
            "description": "<p>Is sticky flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_active",
            "optional": false,
            "description": "<p>Is content active flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "published_at",
            "optional": false,
            "description": "<p>Date of publication</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "created_at",
            "optional": false,
            "description": "<p>Creation date</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "updated_at",
            "optional": false,
            "description": "<p>Update date</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/ContentTranslationController.php"
  },
  {
    "type": "get",
    "url": "/contents/:id",
    "title": "Get single content",
    "version": "0.1.0",
    "name": "GetContent",
    "group": "Content",
    "description": "<p>Using this function, you can get a single content</p>",
    "examples": [
      {
        "title": "         Example usage:",
        "content": "curl -i http://localhost/api/v1/contents/123\n"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Content unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Content id</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "rating",
            "optional": false,
            "description": "<p>Content rating</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "visits",
            "optional": false,
            "description": "<p>Content visit counter</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "field": "translations",
            "optional": false,
            "description": "<p>List of translations (Array of Objects)</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "translations.lang_id",
            "optional": false,
            "description": "<p>Language id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.url",
            "optional": false,
            "description": "<p>Translation url</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.title",
            "optional": false,
            "description": "<p>Title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.body",
            "optional": false,
            "description": "<p>Body</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.seo_title",
            "optional": false,
            "description": "<p>SEO title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.seo_description",
            "optional": false,
            "description": "<p>SEO description</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "translations.is_active",
            "optional": false,
            "description": "<p>Is translation active</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "translations.created_at",
            "optional": false,
            "description": "<p>Creation date of translation</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "translations.updated_at",
            "optional": false,
            "description": "<p>Update date of translation</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_on_home",
            "optional": false,
            "description": "<p>Home page flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_comment_allowed",
            "optional": false,
            "description": "<p>Is comment allowed flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_promoted",
            "optional": false,
            "description": "<p>Is promoted flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_sticky",
            "optional": false,
            "description": "<p>Is sticky flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_active",
            "optional": false,
            "description": "<p>Is content active flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "published_at",
            "optional": false,
            "description": "<p>Date of publication</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "created_at",
            "optional": false,
            "description": "<p>Creation date</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "updated_at",
            "optional": false,
            "description": "<p>Update date</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/ContentController.php"
  },
  {
    "type": "get",
    "url": "/contents/:id/children",
    "title": "Get content list of children",
    "version": "0.1.0",
    "name": "GetContentChildrenList",
    "group": "Content",
    "description": "<p>Because the contents are stored using a tree structure. We have to pull out a list for the specific node</p>",
    "examples": [
      {
        "title": "    Example usage:",
        "content": "curl -i http://localhost/api/v1/contents/1/children\n"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Content unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "field": "data",
            "optional": false,
            "description": "<p>List of contents (Array of Objects)</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "total",
            "optional": false,
            "description": "<p>Total count of all elements</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/ContentTranslationController.php"
  },
  {
    "type": "get",
    "url": "/contents/:id/children",
    "title": "Get content list of children",
    "version": "0.1.0",
    "name": "GetContentChildrenList",
    "group": "Content",
    "description": "<p>Because the contents are stored using a tree structure. We have to pull out a list for the specific node</p>",
    "examples": [
      {
        "title": "    Example usage:",
        "content": "curl -i http://localhost/api/v1/contents/1/children\n"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Content unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "field": "data",
            "optional": false,
            "description": "<p>List of contents (Array of Objects)</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "total",
            "optional": false,
            "description": "<p>Total count of all elements</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/ContentController.php"
  },
  {
    "type": "get",
    "url": "/contents/:id/children",
    "title": "Get content list of children",
    "version": "0.1.0",
    "name": "GetContentChildrenList",
    "group": "Content",
    "description": "<p>Because the contents are stored using a tree structure. We have to pull out a list for the specific node</p>",
    "examples": [
      {
        "title": "    Example usage:",
        "content": "curl -i http://localhost/api/v1/contents/1/children\n"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Content unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "field": "data",
            "optional": false,
            "description": "<p>List of contents (Array of Objects)</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "total",
            "optional": false,
            "description": "<p>Total count of all elements</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/ContentController.php"
  },
  {
    "type": "get",
    "url": "/contents",
    "title": "Get content list",
    "version": "0.1.0",
    "name": "GetContentList",
    "group": "Content",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/api/v1/contents\n"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "field": "data",
            "optional": false,
            "description": "<p>List of contents (Array of Objects)</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/ContentController.php"
  },
  {
    "type": "get",
    "url": "/contents",
    "title": "Get content list",
    "version": "0.1.0",
    "name": "GetContentList",
    "group": "Content",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/api/v1/contents\n"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "field": "data",
            "optional": false,
            "description": "<p>List of contents (Array of Objects)</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/ContentTranslationController.php"
  },
  {
    "type": "get",
    "url": "/contents",
    "title": "Get content list",
    "version": "0.1.0",
    "name": "GetContentList",
    "group": "Content",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/api/v1/contents\n"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "field": "data",
            "optional": false,
            "description": "<p>List of contents (Array of Objects)</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/ContentController.php"
  },
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Content id</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "rating",
            "optional": false,
            "description": "<p>Content rating</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "visits",
            "optional": false,
            "description": "<p>Content visit counter</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "field": "translations",
            "optional": false,
            "description": "<p>List of translations (Array of Objects)</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "translations.lang_id",
            "optional": false,
            "description": "<p>Language id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.url",
            "optional": false,
            "description": "<p>Translation url</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.title",
            "optional": false,
            "description": "<p>Title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.body",
            "optional": false,
            "description": "<p>Body</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.seo_title",
            "optional": false,
            "description": "<p>SEO title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "translations.seo_description",
            "optional": false,
            "description": "<p>SEO description</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "translations.is_active",
            "optional": false,
            "description": "<p>Is translation active</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "translations.created_at",
            "optional": false,
            "description": "<p>Creation date of translation</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "translations.updated_at",
            "optional": false,
            "description": "<p>Update date of translation</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_on_home",
            "optional": false,
            "description": "<p>Home page flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_comment_allowed",
            "optional": false,
            "description": "<p>Is comment allowed flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_promoted",
            "optional": false,
            "description": "<p>Is promoted flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_sticky",
            "optional": false,
            "description": "<p>Is sticky flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "is_active",
            "optional": false,
            "description": "<p>Is content active flag</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "published_at",
            "optional": false,
            "description": "<p>Date of publication</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "created_at",
            "optional": false,
            "description": "<p>Creation date</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "field": "updated_at",
            "optional": false,
            "description": "<p>Update date</p>"
          }
        ]
      }
    },
    "group": "ContentTranslationController.php",
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "src/Gzero/Api/Controller/Admin/ContentTranslationController.php"
  },
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "field": "code",
            "optional": false,
            "description": "<p>Lang code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "i18n",
            "optional": false,
            "description": "<p>Lang i18n code</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "isEnabled",
            "optional": false,
            "description": "<p>Flag if language is enabled</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "isDefault",
            "optional": false,
            "description": "<p>Flag if language is default</p>"
          }
        ]
      }
    },
    "group": "LangController.php",
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "src/Gzero/Api/Controller/LangController.php"
  },
  {
    "type": "get",
    "url": "/langs/:id",
    "title": "Get single lang",
    "version": "0.1.0",
    "name": "GetLang",
    "group": "Lang",
    "description": "<p>Using this function, you can get a single lang</p>",
    "examples": [
      {
        "title": "         Example usage:",
        "content": "curl -i http://localhost/api/v1/langs/123\n"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Lang unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "field": "code",
            "optional": false,
            "description": "<p>Lang code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "i18n",
            "optional": false,
            "description": "<p>Lang i18n code</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "isEnabled",
            "optional": false,
            "description": "<p>Flag if language is enabled</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "field": "isDefault",
            "optional": false,
            "description": "<p>Flag if language is default</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/LangController.php"
  },
  {
    "type": "get",
    "url": "/langs",
    "title": "Get list",
    "version": "0.1.0",
    "name": "GetLangList",
    "group": "Lang",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/api/v1/langs\n"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "field": "data",
            "optional": false,
            "description": "<p>List of langs (Array of Objects)</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/LangController.php"
  },
  {
    "type": "get",
    "url": "/contents/:id/uploads",
    "title": "Get uploads by content",
    "version": "0.1.0",
    "name": "GetContentUploadList",
    "group": "Upload",
    "description": "<p>Getting uploads for specific content</p>",
    "examples": [
      {
        "title": "    Example usage:",
        "content": "curl -i http://localhost/api/v1/contents/1/uploads\n"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "field": "id",
            "optional": false,
            "description": "<p>Content unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "field": "data",
            "optional": false,
            "description": "<p>List of uploads (Array of Objects)</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "field": "total",
            "optional": false,
            "description": "<p>Total count of all elements</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/UploadController.php"
  },
  {
    "type": "get",
    "url": "/uploads",
    "title": "Get upload list",
    "version": "0.1.0",
    "name": "GetUploadList",
    "group": "Upload",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost/api/v1/uploads\n"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "field": "data",
            "optional": false,
            "description": "<p>List of uploads (Array of Objects)</p>"
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/UploadController.php"
  }
] });