define({ "api": [
  {
    "type": "delete",
    "url": "/admin/blocks",
    "title": "8. DELETE the specified entity",
    "version": "0.1.0",
    "name": "DeleteBlock",
    "group": "Block",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Delete the specified block from database</p> ",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "success",
            "description": "<p>Success flag</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\"success\":true}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/api/v1/admin/blocks",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/BlockController.php",
    "groupTitle": ""
  },
  {
    "type": "get",
    "url": "/admin/blocks/:id",
    "title": "5. GET single entity",
    "version": "0.1.0",
    "name": "GetBlock",
    "group": "Block",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Get the specified block from database</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/admin/blocks/123",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/BlockController.php",
    "groupTitle": "",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Block id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "type",
            "description": "<p>Block type</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "region",
            "description": "<p>Block region</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "filter",
            "description": "<p>Block visibility configuration in form of Tree node path for each content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "options",
            "description": "<p>Block unique parameters (Defined as array of key / value parameters)</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "theme",
            "description": "<p>Block theme</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "weight",
            "description": "<p>Block weight</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is block active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isCacheable",
            "description": "<p>Can block be cached flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "author",
            "description": "<p>Author of this Block</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "Translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"type\": \"basic\",\n  \"region\": \"header\",\n  \"filter\": {\n      \"+\": [\n         \"1/2/*\"\n      ],\n      \"-\": [\n         \"2\"\n      ]\n  },\n  \"options\": {\n      \"optionName\": \"optionValue\",\n      \"anotherOptionName\": \"anotherOptionValue\",\n      \"lastOptionName\": \"lastOptionValue\"\n  },\n  \"theme\": null,\n  \"weight\": 3,\n  \"isActive\": false,\n  \"isCacheable\": false,\n  \"createdAt\": \"2015-12-13 12:11:04\",\n  \"updatedAt\": \"2015-12-13 12:11:04\",\n  \"author\": {\n      \"id\": 1,\n      \"email\": \"admin@gzero.pl\",\n      \"firstName\": \"John\",\n      \"lastName\": \"Doe\"\n  },\n  \"translations\": [\n       {\n           \"id\": 1,\n           \"lang\": \"en\",\n           \"title\": \"Example block title\",\n           \"body\": \"Example block body\",\n           \"isActive\": true,\n           \"customFields\": {\n               \"fieldName\": \"fieldValue\",\n               \"anotherFieldName\": \"anotherFieldValue\",\n               \"lastFieldName\": \"lastFieldValue\"\n           },\n           \"createdAt\": \"2015-12-13 12:11:04\",\n           \"updatedAt\": \"2015-12-13 12:11:04\"\n      },\n      {\n          \"id\": 1,\n          \"lang\": \"pl\",\n          \"title\": \"Example block title\",\n          \"body\": \"Example block body\",\n          \"isActive\": true,\n             \"customFields\": {\n                 \"fieldName\": \"fieldValue\",\n                 \"anotherFieldName\": \"anotherFieldValue\",\n                 \"lastFieldName\": \"lastFieldValue\"\n          },\n          \"createdAt\": \"2015-12-13 12:11:04\",\n          \"updatedAt\": \"2015-12-13 12:11:04\"\n      },\n ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/admin/blocks",
    "title": "1. GET collection of entities",
    "version": "0.1.0",
    "name": "GetBlockList",
    "group": "Block",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Get root blocks</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/admin/blocks",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/BlockController.php",
    "groupTitle": "",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "meta",
            "description": "<p>Meta data for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.total",
            "description": "<p>Total number elements</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.perPage",
            "description": "<p>Number of elements per page</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.currentPage",
            "description": "<p>Current page number</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.lastPage",
            "description": "<p>Last page number</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "meta.link",
            "description": "<p>Link for this resource</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "params",
            "description": "<p>Params passed for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "params.page",
            "description": "<p>Page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "params.perPage",
            "description": "<p>Per page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "params.filter",
            "description": "<p>Array of filter params</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "params.orderBy",
            "description": "<p>Array of sort params</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "data",
            "description": "<p>Array of Blocks</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "data.id",
            "description": "<p>Block id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.type",
            "description": "<p>Block type</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.region",
            "description": "<p>Block region</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "data.filter",
            "description": "<p>Block visibility configuration in form of Tree node path for each content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "data.options",
            "description": "<p>Block unique parameters (Defined as array of key / value parameters)</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.theme",
            "description": "<p>Block theme</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "data.weight",
            "description": "<p>Block weight</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.isActive",
            "description": "<p>Is block active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.isCacheable",
            "description": "<p>Can block be cached flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "data.createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "data.updatedAt",
            "description": "<p>Update date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "data.author",
            "description": "<p>Author of this Block</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "data.Translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n       \"meta\": {\n       \"total\": 75,\n       \"perPage\": 20,\n       \"currentPage\": 1,\n       \"lastPage\": 4,\n       \"link\": \"http://api.gzero.dev:8000/v1/admin/blocks\"\n   },\n   \"params\": {\n       \"page\": 1,\n       \"perPage\": 20,\n       \"filter\": [],\n       \"orderBy\": []\n   },\n   \"data\": [\n       {Block},\n       ...\n   ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/admin/blocks",
    "title": "6. POST newly created entity",
    "version": "0.1.0",
    "name": "PostBlock",
    "group": "Block",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Store newly created block in database</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/api/v1/admin/blocks",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/BlockController.php",
    "groupTitle": "",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Block id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "type",
            "description": "<p>Block type</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "region",
            "description": "<p>Block region</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "filter",
            "description": "<p>Block visibility configuration in form of Tree node path for each content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "options",
            "description": "<p>Block unique parameters (Defined as array of key / value parameters)</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "theme",
            "description": "<p>Block theme</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "weight",
            "description": "<p>Block weight</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is block active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isCacheable",
            "description": "<p>Can block be cached flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "author",
            "description": "<p>Author of this Block</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "Translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"type\": \"basic\",\n  \"region\": \"header\",\n  \"filter\": {\n      \"+\": [\n         \"1/2/*\"\n      ],\n      \"-\": [\n         \"2\"\n      ]\n  },\n  \"options\": {\n      \"optionName\": \"optionValue\",\n      \"anotherOptionName\": \"anotherOptionValue\",\n      \"lastOptionName\": \"lastOptionValue\"\n  },\n  \"theme\": null,\n  \"weight\": 3,\n  \"isActive\": false,\n  \"isCacheable\": false,\n  \"createdAt\": \"2015-12-13 12:11:04\",\n  \"updatedAt\": \"2015-12-13 12:11:04\",\n  \"author\": {\n      \"id\": 1,\n      \"email\": \"admin@gzero.pl\",\n      \"firstName\": \"John\",\n      \"lastName\": \"Doe\"\n  },\n  \"translations\": [\n       {\n           \"id\": 1,\n           \"lang\": \"en\",\n           \"title\": \"Example block title\",\n           \"body\": \"Example block body\",\n           \"isActive\": true,\n           \"customFields\": {\n               \"fieldName\": \"fieldValue\",\n               \"anotherFieldName\": \"anotherFieldValue\",\n               \"lastFieldName\": \"lastFieldValue\"\n           },\n           \"createdAt\": \"2015-12-13 12:11:04\",\n           \"updatedAt\": \"2015-12-13 12:11:04\"\n      },\n      {\n          \"id\": 1,\n          \"lang\": \"pl\",\n          \"title\": \"Example block title\",\n          \"body\": \"Example block body\",\n          \"isActive\": true,\n             \"customFields\": {\n                 \"fieldName\": \"fieldValue\",\n                 \"anotherFieldName\": \"anotherFieldValue\",\n                 \"lastFieldName\": \"lastFieldValue\"\n          },\n          \"createdAt\": \"2015-12-13 12:11:04\",\n          \"updatedAt\": \"2015-12-13 12:11:04\"\n      },\n ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "/admin/blocks",
    "title": "7. PUT the specified entity",
    "version": "0.1.0",
    "name": "PutBlock",
    "group": "Block",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Update the specified block in database</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/api/v1/admin/blocks",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/BlockController.php",
    "groupTitle": "",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Block id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "type",
            "description": "<p>Block type</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "region",
            "description": "<p>Block region</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "filter",
            "description": "<p>Block visibility configuration in form of Tree node path for each content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "options",
            "description": "<p>Block unique parameters (Defined as array of key / value parameters)</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "theme",
            "description": "<p>Block theme</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "weight",
            "description": "<p>Block weight</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is block active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isCacheable",
            "description": "<p>Can block be cached flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "author",
            "description": "<p>Author of this Block</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "Translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"type\": \"basic\",\n  \"region\": \"header\",\n  \"filter\": {\n      \"+\": [\n         \"1/2/*\"\n      ],\n      \"-\": [\n         \"2\"\n      ]\n  },\n  \"options\": {\n      \"optionName\": \"optionValue\",\n      \"anotherOptionName\": \"anotherOptionValue\",\n      \"lastOptionName\": \"lastOptionValue\"\n  },\n  \"theme\": null,\n  \"weight\": 3,\n  \"isActive\": false,\n  \"isCacheable\": false,\n  \"createdAt\": \"2015-12-13 12:11:04\",\n  \"updatedAt\": \"2015-12-13 12:11:04\",\n  \"author\": {\n      \"id\": 1,\n      \"email\": \"admin@gzero.pl\",\n      \"firstName\": \"John\",\n      \"lastName\": \"Doe\"\n  },\n  \"translations\": [\n       {\n           \"id\": 1,\n           \"lang\": \"en\",\n           \"title\": \"Example block title\",\n           \"body\": \"Example block body\",\n           \"isActive\": true,\n           \"customFields\": {\n               \"fieldName\": \"fieldValue\",\n               \"anotherFieldName\": \"anotherFieldValue\",\n               \"lastFieldName\": \"lastFieldValue\"\n           },\n           \"createdAt\": \"2015-12-13 12:11:04\",\n           \"updatedAt\": \"2015-12-13 12:11:04\"\n      },\n      {\n          \"id\": 1,\n          \"lang\": \"pl\",\n          \"title\": \"Example block title\",\n          \"body\": \"Example block body\",\n          \"isActive\": true,\n             \"customFields\": {\n                 \"fieldName\": \"fieldValue\",\n                 \"anotherFieldName\": \"anotherFieldValue\",\n                 \"lastFieldName\": \"lastFieldValue\"\n          },\n          \"createdAt\": \"2015-12-13 12:11:04\",\n          \"updatedAt\": \"2015-12-13 12:11:04\"\n      },\n ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "/admin/blocks/:id/translations/:id",
    "title": "5. DELETE the specified entity",
    "version": "0.1.0",
    "name": "DeleteBlockTranslation",
    "group": "Block_Translations",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>The Block ID</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "translationId",
            "description": "<p>The BlockTranslations ID</p> "
          }
        ]
      }
    },
    "description": "<p>Deletes the specified block translation from database</p> ",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "success",
            "description": "<p>Success flag</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\"success\":true}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/admin/blocks/1/translations/1",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/BlockTranslationController.php",
    "groupTitle": "Block_Translations"
  },
  {
    "type": "get",
    "url": "/admin/blocks/:id/translations/:id",
    "title": "2. GET single entity",
    "version": "0.1.0",
    "name": "GetBlockTranslation",
    "group": "Block_Translations",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>The Block ID</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "translationId",
            "description": "<p>The BlockTranslations ID</p> "
          }
        ]
      }
    },
    "description": "<p>Get the specified block translation from database</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/admin/blocks/1/translations/1",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/BlockTranslationController.php",
    "groupTitle": "Block_Translations",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Translation id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "lang",
            "description": "<p>Language code</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "title",
            "description": "<p>Title</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "body",
            "description": "<p>Body</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "customFields",
            "description": "<p>Translation unique parameters (Defined as array of key / value parameters)</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date of translation</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date of translation</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"lang\": \"en\",\n  \"title\": \"Example block title\",\n  \"body\": \"Example block body\",\n  \"isActive\": true,\n  \"customFields\": {\n      \"fieldName\": \"fieldValue\",\n      \"anotherFieldName\": \"anotherFieldValue\",\n      \"lastFieldName\": \"lastFieldValue\"\n  },\n  \"createdAt\": \"2015-12-13 12:11:04\",\n  \"updatedAt\": \"2015-12-13 12:11:04\"\n  },\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/admin/blocks/:id/translations",
    "title": "1. GET collection of translations",
    "version": "0.1.0",
    "name": "GetTranslationList",
    "group": "Block_Translations",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>The Block ID</p> "
          }
        ]
      }
    },
    "description": "<p>Get collection of translation for specified block entity</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/admin/blocks/1/translations",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/BlockTranslationController.php",
    "groupTitle": "Block_Translations",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "meta",
            "description": "<p>Meta data for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.total",
            "description": "<p>Total number elements</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.perPage",
            "description": "<p>Number of elements per page</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.currentPage",
            "description": "<p>Current page number</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.lastPage",
            "description": "<p>Last page number</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "meta.link",
            "description": "<p>Link for this resource</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "params",
            "description": "<p>Params passed for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "params.page",
            "description": "<p>Page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "params.perPage",
            "description": "<p>Per page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "params.filter",
            "description": "<p>Array of filter params</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "params.orderBy",
            "description": "<p>Array of sort params</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "data.id",
            "description": "<p>Translation id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.lang",
            "description": "<p>Language code</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.title",
            "description": "<p>Title</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.body",
            "description": "<p>Body</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.isActive",
            "description": "<p>Is active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "data.customFields",
            "description": "<p>Translation unique parameters (Defined as array of key / value parameters)</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "data.createdAt",
            "description": "<p>Creation date of translation</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "data.updatedAt",
            "description": "<p>Update date of translation</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n       \"meta\": {\n       \"total\": 4,\n       \"perPage\": 20,\n       \"currentPage\": 1,\n       \"lastPage\": 1,\n       \"link\": \"http://api.gzero.dev:8000/v1/admin/blocks/1/translations\"\n   },\n   \"params\": {\n       \"page\": 1,\n       \"perPage\": 20,\n       \"filter\": [],\n       \"orderBy\": []\n   },\n   \"data\": [\n       {BlockTranslations},\n       ...\n   ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/admin/blocks/:id/translations",
    "title": "3. POST newly created entity",
    "version": "0.1.0",
    "name": "PostBlockTranslation",
    "group": "Block_Translations",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>The Block ID</p> "
          }
        ]
      }
    },
    "description": "<p>Stores newly created block translation in database</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/api/v1/admin/blocks/1/translations",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/BlockTranslationController.php",
    "groupTitle": "Block_Translations",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Translation id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "lang",
            "description": "<p>Language code</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "title",
            "description": "<p>Title</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "body",
            "description": "<p>Body</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "customFields",
            "description": "<p>Translation unique parameters (Defined as array of key / value parameters)</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date of translation</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date of translation</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"lang\": \"en\",\n  \"title\": \"Example block title\",\n  \"body\": \"Example block body\",\n  \"isActive\": true,\n  \"customFields\": {\n      \"fieldName\": \"fieldValue\",\n      \"anotherFieldName\": \"anotherFieldValue\",\n      \"lastFieldName\": \"lastFieldValue\"\n  },\n  \"createdAt\": \"2015-12-13 12:11:04\",\n  \"updatedAt\": \"2015-12-13 12:11:04\"\n  },\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "/admin/blocks/:id/translations",
    "title": "4. PUT newly created revision",
    "version": "0.1.0",
    "name": "PutBlockTranslation",
    "group": "Block_Translations",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>The Block ID</p> "
          }
        ]
      }
    },
    "description": "<p>Each translations update always creates new record in database, for history revision</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/api/v1/admin/blocks/1/translations",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/BlockTranslationController.php",
    "groupTitle": "Block_Translations",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Translation id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "lang",
            "description": "<p>Language code</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "title",
            "description": "<p>Title</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "body",
            "description": "<p>Body</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "customFields",
            "description": "<p>Translation unique parameters (Defined as array of key / value parameters)</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date of translation</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date of translation</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"lang\": \"en\",\n  \"title\": \"Example block title\",\n  \"body\": \"Example block body\",\n  \"isActive\": true,\n  \"customFields\": {\n      \"fieldName\": \"fieldValue\",\n      \"anotherFieldName\": \"anotherFieldValue\",\n      \"lastFieldName\": \"lastFieldValue\"\n  },\n  \"createdAt\": \"2015-12-13 12:11:04\",\n  \"updatedAt\": \"2015-12-13 12:11:04\"\n  },\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "/admin/contents",
    "title": "8. DELETE the specified entity",
    "version": "0.1.0",
    "name": "DeleteContent",
    "group": "Content",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Delete the specified content from database</p> ",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "success",
            "description": "<p>Success flag</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\"success\":true}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/api/v1/admin/contents",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/ContentController.php",
    "groupTitle": ""
  },
  {
    "type": "get",
    "url": "/admin/contents/:id",
    "title": "5. GET single entity",
    "version": "0.1.0",
    "name": "GetContent",
    "group": "Content",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Get the specified content from database</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/admin/contents/123",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/ContentController.php",
    "groupTitle": "",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Content id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "parentId",
            "description": "<p>Content parent id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "type",
            "description": "<p>Content type</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "theme",
            "description": "<p>Content theme</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "weight",
            "description": "<p>Content weight</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "rating",
            "description": "<p>Content rating</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "visits",
            "description": "<p>Content visit counter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is content active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isOnHome",
            "description": "<p>Home page flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isCommentAllowed",
            "description": "<p>Is comment allowed flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isPromoted",
            "description": "<p>Is promoted flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isSticky",
            "description": "<p>Is sticky flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "path",
            "description": "<p>Tree path for this node</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "publishedAt",
            "description": "<p>Date of publication</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "route",
            "description": "<p>Route for this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "author",
            "description": "<p>Author of this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"type\": \"category\",\n  \"weight\": 3,\n  \"theme\": null,\n  \"weight\": 0,\n  \"isActive\": false,\n  \"isOnHome\": false,\n  \"isCommentAllowed\": true,\n  \"isPromoted\": false,\n  \"isSticky\": true,\n  \"rating\": 1,\n  \"visits\": 1,\n  \"path\": [\n      1\n  ],\n  \"publishedAt\": \"2015-12-13 12:10:59\",\n  \"createdAt\": \"2015-12-13 12:10:59\",\n  \"updatedAt\": \"2015-12-13 12:10:59\",\n  \"route\": {\n      \"id\": 1,\n      \"createdAt\": \"2015-12-13 12:10:59\",\n      \"updatedAt\": \"2015-12-13 12:10:59\",\n      \"translations\": [\n          {\n              \"id\": 1,\n              \"lang\": \"en\",\n              \"url\": \"example-url\",\n              \"isActive\": 1,\n              \"createdAt\": \"2015-12-13 12:10:59\",\n              \"updatedAt\": \"2015-12-13 12:10:59\"\n          },\n          {\n              \"id\": 2,\n              \"lang\": \"pl\",\n              \"url\": \"example-url\",\n              \"isActive\": true,\n              \"createdAt\": \"2015-12-13 12:10:59\",\n              \"updatedAt\": \"2015-12-13 12:10:59\"\n          }\n      ]\n  },\n  \"author\": {\n      \"id\": 1,\n      \"email\": \"admin@gzero.pl\",\n      \"firstName\": \"John\",\n      \"lastName\": \"Doe\"\n  },\n  \"translations\": [\n      {\n          \"id\": 1,\n          \"lang\": \"en\",\n          \"title\": \"Example title\",\n          \"body\": \"Example body\",\n          \"isActive\": true,\n          \"createdAt\": \"2015-12-13 12:10:59\",\n          \"updatedAt\": \"2015-12-13 12:10:59\"\n      },\n      {\n          \"id\": 2,\n          \"lang\": \"pl\",\n          \"title\": \"title\",\n          \"body\": \"Example body\",\n          \"isActive\": true,\n          \"createdAt\": \"2015-12-13 12:10:59\",\n          \"updatedAt\": \"2015-12-13 12:10:59\"\n      }\n  ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/admin/contents/:id/children",
    "title": "4. GET collection of entities",
    "version": "0.1.0",
    "name": "GetContentChildrenList",
    "group": "Content",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>The Content ID</p> "
          }
        ]
      }
    },
    "description": "<p>Get children contents</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/admin/contents/1/children",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/ContentController.php",
    "groupTitle": "",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "meta",
            "description": "<p>Meta data for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.total",
            "description": "<p>Total number elements</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.perPage",
            "description": "<p>Number of elements per page</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.currentPage",
            "description": "<p>Current page number</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.lastPage",
            "description": "<p>Last page number</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "meta.link",
            "description": "<p>Link for this resource</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "params",
            "description": "<p>Params passed for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "params.page",
            "description": "<p>Page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "params.perPage",
            "description": "<p>Per page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "params.filter",
            "description": "<p>Array of filter params</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "params.orderBy",
            "description": "<p>Array of sort params</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "data",
            "description": "<p>Array of Contents</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "data.id",
            "description": "<p>Content id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "data.parentId",
            "description": "<p>Content parent id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.type",
            "description": "<p>Content type</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.theme",
            "description": "<p>Content theme</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "data.weight",
            "description": "<p>Content weight</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "data.rating",
            "description": "<p>Content rating</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "data.visits",
            "description": "<p>Content visit counter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.isActive",
            "description": "<p>Is content active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.isOnHome",
            "description": "<p>Home page flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.isCommentAllowed",
            "description": "<p>Is comment allowed flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.isPromoted",
            "description": "<p>Is promoted flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.isSticky",
            "description": "<p>Is sticky flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "data.path",
            "description": "<p>Tree path for this node</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "data.publishedAt",
            "description": "<p>Date of publication</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "data.createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "data.updatedAt",
            "description": "<p>Update date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "data.route",
            "description": "<p>Route for this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "data.author",
            "description": "<p>Author of this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "data.translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n       \"meta\": {\n       \"total\": 75,\n       \"perPage\": 20,\n       \"currentPage\": 1,\n       \"lastPage\": 4,\n       \"link\": \"http://api.gzero.dev:8000/v1/admin/contents\"\n   },\n   \"params\": {\n       \"page\": 1,\n       \"perPage\": 20,\n       \"filter\": [],\n       \"orderBy\": []\n   },\n   \"data\": [\n       {Content},\n       ...\n   ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/admin/contents/tree/:id",
    "title": "3. GET tree for single root entity",
    "version": "0.1.0",
    "name": "GetContentChildrenTree",
    "group": "Content",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>The Content ID</p> "
          }
        ]
      }
    },
    "description": "<p>Get content with children as tree</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/admin/contents/tree/1",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/ContentController.php",
    "groupTitle": "",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Content id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "parentId",
            "description": "<p>Content parent id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "type",
            "description": "<p>Content type</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "theme",
            "description": "<p>Content theme</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "weight",
            "description": "<p>Content weight</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "rating",
            "description": "<p>Content rating</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "visits",
            "description": "<p>Content visit counter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is content active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isOnHome",
            "description": "<p>Home page flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isCommentAllowed",
            "description": "<p>Is comment allowed flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isPromoted",
            "description": "<p>Is promoted flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isSticky",
            "description": "<p>Is sticky flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "path",
            "description": "<p>Tree path for this node</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "publishedAt",
            "description": "<p>Date of publication</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "route",
            "description": "<p>Route for this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "author",
            "description": "<p>Author of this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"type\": \"category\",\n  \"weight\": 3,\n  \"theme\": null,\n  \"weight\": 0,\n  \"isActive\": false,\n  \"isOnHome\": false,\n  \"isCommentAllowed\": true,\n  \"isPromoted\": false,\n  \"isSticky\": true,\n  \"rating\": 1,\n  \"visits\": 1,\n  \"path\": [\n      1\n  ],\n  \"publishedAt\": \"2015-12-13 12:10:59\",\n  \"createdAt\": \"2015-12-13 12:10:59\",\n  \"updatedAt\": \"2015-12-13 12:10:59\",\n  \"route\": {\n      \"id\": 1,\n      \"createdAt\": \"2015-12-13 12:10:59\",\n      \"updatedAt\": \"2015-12-13 12:10:59\",\n      \"translations\": [\n          {\n              \"id\": 1,\n              \"lang\": \"en\",\n              \"url\": \"example-url\",\n              \"isActive\": 1,\n              \"createdAt\": \"2015-12-13 12:10:59\",\n              \"updatedAt\": \"2015-12-13 12:10:59\"\n          },\n          {\n              \"id\": 2,\n              \"lang\": \"pl\",\n              \"url\": \"example-url\",\n              \"isActive\": true,\n              \"createdAt\": \"2015-12-13 12:10:59\",\n              \"updatedAt\": \"2015-12-13 12:10:59\"\n          }\n      ]\n  },\n  \"author\": {\n      \"id\": 1,\n      \"email\": \"admin@gzero.pl\",\n      \"firstName\": \"John\",\n      \"lastName\": \"Doe\"\n  },\n  \"translations\": [\n      {\n          \"id\": 1,\n          \"lang\": \"en\",\n          \"title\": \"Example title\",\n          \"body\": \"Example body\",\n          \"isActive\": true,\n          \"createdAt\": \"2015-12-13 12:10:59\",\n          \"updatedAt\": \"2015-12-13 12:10:59\"\n      },\n      {\n          \"id\": 2,\n          \"lang\": \"pl\",\n          \"title\": \"title\",\n          \"body\": \"Example body\",\n          \"isActive\": true,\n          \"createdAt\": \"2015-12-13 12:10:59\",\n          \"updatedAt\": \"2015-12-13 12:10:59\"\n      }\n  ]\n   \"children\": [\n       {Content},\n       ...\n   ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/admin/contents",
    "title": "1. GET collection of root entities",
    "version": "0.1.0",
    "name": "GetContentList",
    "group": "Content",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Get root contents</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/admin/contents",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/ContentController.php",
    "groupTitle": "",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "meta",
            "description": "<p>Meta data for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.total",
            "description": "<p>Total number elements</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.perPage",
            "description": "<p>Number of elements per page</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.currentPage",
            "description": "<p>Current page number</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.lastPage",
            "description": "<p>Last page number</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "meta.link",
            "description": "<p>Link for this resource</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "params",
            "description": "<p>Params passed for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "params.page",
            "description": "<p>Page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "params.perPage",
            "description": "<p>Per page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "params.filter",
            "description": "<p>Array of filter params</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "params.orderBy",
            "description": "<p>Array of sort params</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "data",
            "description": "<p>Array of Contents</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "data.id",
            "description": "<p>Content id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "data.parentId",
            "description": "<p>Content parent id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.type",
            "description": "<p>Content type</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.theme",
            "description": "<p>Content theme</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "data.weight",
            "description": "<p>Content weight</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "data.rating",
            "description": "<p>Content rating</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "data.visits",
            "description": "<p>Content visit counter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.isActive",
            "description": "<p>Is content active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.isOnHome",
            "description": "<p>Home page flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.isCommentAllowed",
            "description": "<p>Is comment allowed flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.isPromoted",
            "description": "<p>Is promoted flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.isSticky",
            "description": "<p>Is sticky flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "data.path",
            "description": "<p>Tree path for this node</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "data.publishedAt",
            "description": "<p>Date of publication</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "data.createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "data.updatedAt",
            "description": "<p>Update date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "data.route",
            "description": "<p>Route for this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "data.author",
            "description": "<p>Author of this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "data.translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n       \"meta\": {\n       \"total\": 75,\n       \"perPage\": 20,\n       \"currentPage\": 1,\n       \"lastPage\": 4,\n       \"link\": \"http://api.gzero.dev:8000/v1/admin/contents\"\n   },\n   \"params\": {\n       \"page\": 1,\n       \"perPage\": 20,\n       \"filter\": [],\n       \"orderBy\": []\n   },\n   \"data\": [\n       {Content},\n       ...\n   ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/admin/contents/tree",
    "title": "2. GET trees for all root entities",
    "version": "0.1.0",
    "name": "GetContentTree",
    "group": "Content",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Get all root contents with children as tree</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/admin/contents/tree",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/ContentController.php",
    "groupTitle": "",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Content id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "parentId",
            "description": "<p>Content parent id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "type",
            "description": "<p>Content type</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "theme",
            "description": "<p>Content theme</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "weight",
            "description": "<p>Content weight</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "rating",
            "description": "<p>Content rating</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "visits",
            "description": "<p>Content visit counter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is content active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isOnHome",
            "description": "<p>Home page flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isCommentAllowed",
            "description": "<p>Is comment allowed flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isPromoted",
            "description": "<p>Is promoted flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isSticky",
            "description": "<p>Is sticky flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "path",
            "description": "<p>Tree path for this node</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "publishedAt",
            "description": "<p>Date of publication</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "route",
            "description": "<p>Route for this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "author",
            "description": "<p>Author of this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"type\": \"category\",\n  \"weight\": 3,\n  \"theme\": null,\n  \"weight\": 0,\n  \"isActive\": false,\n  \"isOnHome\": false,\n  \"isCommentAllowed\": true,\n  \"isPromoted\": false,\n  \"isSticky\": true,\n  \"rating\": 1,\n  \"visits\": 1,\n  \"path\": [\n      1\n  ],\n  \"publishedAt\": \"2015-12-13 12:10:59\",\n  \"createdAt\": \"2015-12-13 12:10:59\",\n  \"updatedAt\": \"2015-12-13 12:10:59\",\n  \"route\": {\n      \"id\": 1,\n      \"createdAt\": \"2015-12-13 12:10:59\",\n      \"updatedAt\": \"2015-12-13 12:10:59\",\n      \"translations\": [\n          {\n              \"id\": 1,\n              \"lang\": \"en\",\n              \"url\": \"example-url\",\n              \"isActive\": 1,\n              \"createdAt\": \"2015-12-13 12:10:59\",\n              \"updatedAt\": \"2015-12-13 12:10:59\"\n          },\n          {\n              \"id\": 2,\n              \"lang\": \"pl\",\n              \"url\": \"example-url\",\n              \"isActive\": true,\n              \"createdAt\": \"2015-12-13 12:10:59\",\n              \"updatedAt\": \"2015-12-13 12:10:59\"\n          }\n      ]\n  },\n  \"author\": {\n      \"id\": 1,\n      \"email\": \"admin@gzero.pl\",\n      \"firstName\": \"John\",\n      \"lastName\": \"Doe\"\n  },\n  \"translations\": [\n      {\n          \"id\": 1,\n          \"lang\": \"en\",\n          \"title\": \"Example title\",\n          \"body\": \"Example body\",\n          \"isActive\": true,\n          \"createdAt\": \"2015-12-13 12:10:59\",\n          \"updatedAt\": \"2015-12-13 12:10:59\"\n      },\n      {\n          \"id\": 2,\n          \"lang\": \"pl\",\n          \"title\": \"title\",\n          \"body\": \"Example body\",\n          \"isActive\": true,\n          \"createdAt\": \"2015-12-13 12:10:59\",\n          \"updatedAt\": \"2015-12-13 12:10:59\"\n      }\n  ]\n   \"children\": [\n       {Content},\n       ...\n   ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/admin/contents",
    "title": "6. POST newly created entity",
    "version": "0.1.0",
    "name": "PostContent",
    "group": "Content",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Store newly created content in database</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/api/v1/admin/contents",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/ContentController.php",
    "groupTitle": "",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Content id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "parentId",
            "description": "<p>Content parent id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "type",
            "description": "<p>Content type</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "theme",
            "description": "<p>Content theme</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "weight",
            "description": "<p>Content weight</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "rating",
            "description": "<p>Content rating</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "visits",
            "description": "<p>Content visit counter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is content active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isOnHome",
            "description": "<p>Home page flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isCommentAllowed",
            "description": "<p>Is comment allowed flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isPromoted",
            "description": "<p>Is promoted flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isSticky",
            "description": "<p>Is sticky flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "path",
            "description": "<p>Tree path for this node</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "publishedAt",
            "description": "<p>Date of publication</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "route",
            "description": "<p>Route for this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "author",
            "description": "<p>Author of this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"type\": \"category\",\n  \"weight\": 3,\n  \"theme\": null,\n  \"weight\": 0,\n  \"isActive\": false,\n  \"isOnHome\": false,\n  \"isCommentAllowed\": true,\n  \"isPromoted\": false,\n  \"isSticky\": true,\n  \"rating\": 1,\n  \"visits\": 1,\n  \"path\": [\n      1\n  ],\n  \"publishedAt\": \"2015-12-13 12:10:59\",\n  \"createdAt\": \"2015-12-13 12:10:59\",\n  \"updatedAt\": \"2015-12-13 12:10:59\",\n  \"route\": {\n      \"id\": 1,\n      \"createdAt\": \"2015-12-13 12:10:59\",\n      \"updatedAt\": \"2015-12-13 12:10:59\",\n      \"translations\": [\n          {\n              \"id\": 1,\n              \"lang\": \"en\",\n              \"url\": \"example-url\",\n              \"isActive\": 1,\n              \"createdAt\": \"2015-12-13 12:10:59\",\n              \"updatedAt\": \"2015-12-13 12:10:59\"\n          },\n          {\n              \"id\": 2,\n              \"lang\": \"pl\",\n              \"url\": \"example-url\",\n              \"isActive\": true,\n              \"createdAt\": \"2015-12-13 12:10:59\",\n              \"updatedAt\": \"2015-12-13 12:10:59\"\n          }\n      ]\n  },\n  \"author\": {\n      \"id\": 1,\n      \"email\": \"admin@gzero.pl\",\n      \"firstName\": \"John\",\n      \"lastName\": \"Doe\"\n  },\n  \"translations\": [\n      {\n          \"id\": 1,\n          \"lang\": \"en\",\n          \"title\": \"Example title\",\n          \"body\": \"Example body\",\n          \"isActive\": true,\n          \"createdAt\": \"2015-12-13 12:10:59\",\n          \"updatedAt\": \"2015-12-13 12:10:59\"\n      },\n      {\n          \"id\": 2,\n          \"lang\": \"pl\",\n          \"title\": \"title\",\n          \"body\": \"Example body\",\n          \"isActive\": true,\n          \"createdAt\": \"2015-12-13 12:10:59\",\n          \"updatedAt\": \"2015-12-13 12:10:59\"\n      }\n  ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "/admin/contents",
    "title": "7. PUT the specified entity",
    "version": "0.1.0",
    "name": "PutContent",
    "group": "Content",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Update the specified content in database</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/api/v1/admin/contents",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/ContentController.php",
    "groupTitle": "",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Content id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "parentId",
            "description": "<p>Content parent id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "type",
            "description": "<p>Content type</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "theme",
            "description": "<p>Content theme</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "weight",
            "description": "<p>Content weight</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "rating",
            "description": "<p>Content rating</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "visits",
            "description": "<p>Content visit counter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is content active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isOnHome",
            "description": "<p>Home page flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isCommentAllowed",
            "description": "<p>Is comment allowed flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isPromoted",
            "description": "<p>Is promoted flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isSticky",
            "description": "<p>Is sticky flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "path",
            "description": "<p>Tree path for this node</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "publishedAt",
            "description": "<p>Date of publication</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "route",
            "description": "<p>Route for this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "author",
            "description": "<p>Author of this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"type\": \"category\",\n  \"weight\": 3,\n  \"theme\": null,\n  \"weight\": 0,\n  \"isActive\": false,\n  \"isOnHome\": false,\n  \"isCommentAllowed\": true,\n  \"isPromoted\": false,\n  \"isSticky\": true,\n  \"rating\": 1,\n  \"visits\": 1,\n  \"path\": [\n      1\n  ],\n  \"publishedAt\": \"2015-12-13 12:10:59\",\n  \"createdAt\": \"2015-12-13 12:10:59\",\n  \"updatedAt\": \"2015-12-13 12:10:59\",\n  \"route\": {\n      \"id\": 1,\n      \"createdAt\": \"2015-12-13 12:10:59\",\n      \"updatedAt\": \"2015-12-13 12:10:59\",\n      \"translations\": [\n          {\n              \"id\": 1,\n              \"lang\": \"en\",\n              \"url\": \"example-url\",\n              \"isActive\": 1,\n              \"createdAt\": \"2015-12-13 12:10:59\",\n              \"updatedAt\": \"2015-12-13 12:10:59\"\n          },\n          {\n              \"id\": 2,\n              \"lang\": \"pl\",\n              \"url\": \"example-url\",\n              \"isActive\": true,\n              \"createdAt\": \"2015-12-13 12:10:59\",\n              \"updatedAt\": \"2015-12-13 12:10:59\"\n          }\n      ]\n  },\n  \"author\": {\n      \"id\": 1,\n      \"email\": \"admin@gzero.pl\",\n      \"firstName\": \"John\",\n      \"lastName\": \"Doe\"\n  },\n  \"translations\": [\n      {\n          \"id\": 1,\n          \"lang\": \"en\",\n          \"title\": \"Example title\",\n          \"body\": \"Example body\",\n          \"isActive\": true,\n          \"createdAt\": \"2015-12-13 12:10:59\",\n          \"updatedAt\": \"2015-12-13 12:10:59\"\n      },\n      {\n          \"id\": 2,\n          \"lang\": \"pl\",\n          \"title\": \"title\",\n          \"body\": \"Example body\",\n          \"isActive\": true,\n          \"createdAt\": \"2015-12-13 12:10:59\",\n          \"updatedAt\": \"2015-12-13 12:10:59\"\n      }\n  ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/admin/contents/:id/route",
    "title": "1. POST newly created route",
    "version": "0.1.0",
    "name": "PostRoute",
    "group": "Content_Route",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>The Content ID</p> "
          }
        ]
      }
    },
    "description": "<p>Stores newly created route for specified content entity in database.</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/api/v1/admin/contents/1/route",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/RouteController.php",
    "groupTitle": "Content_Route",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Route id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date of route</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date of route</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array</p> ",
            "optional": false,
            "field": "translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"createdAt\": \"2015-12-13 12:11:04\",\n  \"updatedAt\": \"2015-12-13 12:11:04\",\n  \"translations\": [\n     {\n         \"id\": 45,\n         \"lang\": \"en\",\n         \"url\": \"about-us\",\n         \"isActive\": 1,\n         \"createdAt\": \"2015-12-13 12:11:04\",\n         \"updatedAt\": \"2015-12-13 12:11:04\"\n     },\n     {\n         \"id\": 46,\n         \"lang\": \"pl\",\n         \"url\": \"o-nas\",\n         \"isActive\": 1,\n         \"createdAt\": \"2015-12-13 12:11:04\",\n         \"updatedAt\": \"2015-12-13 12:11:04\"\n     }\n  ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "/admin/contents/:id/translations/:id",
    "title": "5. DELETE the specified entity",
    "version": "0.1.0",
    "name": "DeleteContentTranslation",
    "group": "Content_Translations",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>The Content ID</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "translationId",
            "description": "<p>The ContentTranslations ID</p> "
          }
        ]
      }
    },
    "description": "<p>Deletes the specified content translation from database</p> ",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "success",
            "description": "<p>Success flag</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\"success\":true}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/admin/contents/1/translations/1",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/ContentTranslationController.php",
    "groupTitle": "Content_Translations"
  },
  {
    "type": "get",
    "url": "/admin/contents/:id/translations/:id",
    "title": "2. GET single entity",
    "version": "0.1.0",
    "name": "GetContentTranslation",
    "group": "Content_Translations",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>The Content ID</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "translationId",
            "description": "<p>The ContentTranslations ID</p> "
          }
        ]
      }
    },
    "description": "<p>Get the specified content translation from database</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/admin/contents/1/translations/1",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/ContentTranslationController.php",
    "groupTitle": "Content_Translations",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Translation id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "lang",
            "description": "<p>Language code</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "title",
            "description": "<p>Title</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "body",
            "description": "<p>Body</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date of translation</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date of translation</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"lang\": \"en\",\n  \"title\": \"Example title\",\n  \"body\": \"Example body\",\n  \"isActive\": true,\n  \"createdAt\": \"2015-12-13 12:10:59\",\n  \"updatedAt\": \"2015-12-13 12:10:59\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/admin/contents/:id/translations",
    "title": "1. GET collection of translations",
    "version": "0.1.0",
    "name": "GetTranslationList",
    "group": "Content_Translations",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>The Content ID</p> "
          }
        ]
      }
    },
    "description": "<p>Get collection of translation for specified content entity</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/admin/contents/1/translations",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/ContentTranslationController.php",
    "groupTitle": "Content_Translations",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "meta",
            "description": "<p>Meta data for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.total",
            "description": "<p>Total number elements</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.perPage",
            "description": "<p>Number of elements per page</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.currentPage",
            "description": "<p>Current page number</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "meta.lastPage",
            "description": "<p>Last page number</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "meta.link",
            "description": "<p>Link for this resource</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "params",
            "description": "<p>Params passed for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "params.page",
            "description": "<p>Page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Integer</p> ",
            "optional": false,
            "field": "params.perPage",
            "description": "<p>Per page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "params.filter",
            "description": "<p>Array of filter params</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "params.orderBy",
            "description": "<p>Array of sort params</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "data.id",
            "description": "<p>Translation id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.lang",
            "description": "<p>Language code</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.title",
            "description": "<p>Title</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.body",
            "description": "<p>Body</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.isActive",
            "description": "<p>Is active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "data.createdAt",
            "description": "<p>Creation date of translation</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "data.updatedAt",
            "description": "<p>Update date of translation</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n       \"meta\": {\n       \"total\": 4,\n       \"perPage\": 20,\n       \"currentPage\": 1,\n       \"lastPage\": 1,\n       \"link\": \"http://api.gzero.dev:8000/v1/admin/contents/1/translations\"\n   },\n   \"params\": {\n       \"page\": 1,\n       \"perPage\": 20,\n       \"filter\": [],\n       \"orderBy\": []\n   },\n   \"data\": [\n       {ContentTranslations},\n       ...\n   ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/admin/contents/:id/translations",
    "title": "3. POST newly created entity",
    "version": "0.1.0",
    "name": "PostContentTranslation",
    "group": "Content_Translations",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>The Content ID</p> "
          }
        ]
      }
    },
    "description": "<p>Stores newly created content translation in database</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/api/v1/admin/contents/1/translations",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/ContentTranslationController.php",
    "groupTitle": "Content_Translations",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Translation id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "lang",
            "description": "<p>Language code</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "title",
            "description": "<p>Title</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "body",
            "description": "<p>Body</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date of translation</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date of translation</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"lang\": \"en\",\n  \"title\": \"Example title\",\n  \"body\": \"Example body\",\n  \"isActive\": true,\n  \"createdAt\": \"2015-12-13 12:10:59\",\n  \"updatedAt\": \"2015-12-13 12:10:59\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "/admin/contents/:id/translations",
    "title": "4. PUT newly created revision",
    "version": "0.1.0",
    "name": "PutContentTranslation",
    "group": "Content_Translations",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>The Content ID</p> "
          }
        ]
      }
    },
    "description": "<p>Each translations update always creates new record in database, for history revision</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/api/v1/admin/contents/1/translations",
        "type": "json"
      }
    ],
    "filename": "src/Gzero/Api/Controller/Admin/ContentTranslationController.php",
    "groupTitle": "Content_Translations",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Translation id</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "lang",
            "description": "<p>Language code</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "title",
            "description": "<p>Title</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "body",
            "description": "<p>Body</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date of translation</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Date</p> ",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date of translation</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"lang\": \"en\",\n  \"title\": \"Example title\",\n  \"body\": \"Example body\",\n  \"isActive\": true,\n  \"createdAt\": \"2015-12-13 12:10:59\",\n  \"updatedAt\": \"2015-12-13 12:10:59\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/langs/:code",
    "title": "2. GET single entity",
    "version": "0.1.0",
    "name": "GetLang",
    "group": "Language",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Get a single language by passing lang code</p> ",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "code",
            "description": "<p>Lang unique code</p> "
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/langs/en",
        "type": "json"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\": \"en\",\n  \"i18n\": \"en_US\",\n  \"isEnabled\": false,\n  \"isDefault\": true\n}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "code",
            "description": "<p>Lang code</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "i18n",
            "description": "<p>Lang i18n code</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "is_enabled",
            "description": "<p>Flag if language is enabled</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "is_default",
            "description": "<p>Flag if language is default</p> "
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/LangController.php",
    "groupTitle": "Language"
  },
  {
    "type": "get",
    "url": "/langs",
    "title": "1. GET collection of entities",
    "version": "0.1.0",
    "name": "GetLangList",
    "group": "Language",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Get all languages</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/langs",
        "type": "json"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": [\n       {\n         \"code\": \"en\",\n         \"i18n\": \"en_US\",\n         \"isEnabled\": false,\n         \"isDefault\": true\n       },\n       {\n         \"code\": \"pl\",\n         \"i18n\": \"pl_PL\",\n         \"isEnabled\": false,\n         \"isDefault\": false\n       }\n  ]\n}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "data",
            "description": "<p>Array of Languages</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.code",
            "description": "<p>Lang code</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.i18n",
            "description": "<p>Lang i18n code</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.is_enabled",
            "description": "<p>Flag if language is enabled</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Boolean</p> ",
            "optional": false,
            "field": "data.is_default",
            "description": "<p>Flag if language is default</p> "
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/LangController.php",
    "groupTitle": "Language"
  },
  {
    "type": "get",
    "url": "/options",
    "title": "1. GET collection of categories",
    "version": "0.1.0",
    "name": "GetOptionCategories",
    "group": "Options",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Get all option categories</p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/options",
        "type": "json"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": [\n       {\n         \"key\": \"general\"\n       },\n       {\n         \"key\": \"seo\"\n       }\n  ]\n}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Array[]</p> ",
            "optional": false,
            "field": "data",
            "description": "<p>Array of all options categories</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "data.key",
            "description": "<p>option key</p> "
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/OptionController.php",
    "groupTitle": "Options"
  },
  {
    "type": "get",
    "url": "/options/:category",
    "title": "2. GET category options",
    "version": "0.1.0",
    "name": "GetOptions",
    "group": "Options",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Get all options within the given category</p> ",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "key",
            "description": "<p>category unique key</p> "
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/options/general",
        "type": "json"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"defaultPageSize\": {\n    \"en\": 5,\n    \"pl\": 5\n  },\n  \"siteDesc\": {\n    \"en\": \"Content management system.\",\n    \"pl\": \"Content management system.\"\n  }\n  \"siteName\": {\n    \"en\": \"G-ZERO CMS\",\n    \"pl\": \"G-ZERO CMS\"\n  },\n}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>obj</p> ",
            "optional": false,
            "field": "data",
            "description": "<p>obj of all options in category</p> "
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/OptionController.php",
    "groupTitle": "Options"
  },
  {
    "type": "put",
    "url": "/options/:category",
    "title": "3. PUT category options",
    "version": "0.1.0",
    "name": "UpdateOptions",
    "group": "Options",
    "permission": [
      {
        "name": "admin",
        "title": "Admin access rights needed.",
        "description": "<p>These permissions is needed for access to all admin api methods</p> "
      }
    ],
    "description": "<p>Update selected option within the given category</p> ",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "key",
            "description": "<p>option unique key</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "value",
            "description": "<p>option value</p> "
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://api.example.com/v1/options/general",
        "type": "json"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"defaultPageSize\": {\n    \"en\": 5,\n    \"pl\": 5\n  },\n  \"siteDesc\": {\n    \"en\": \"Content management system.\",\n    \"pl\": \"Content management system.\"\n  }\n  \"siteName\": {\n    \"en\": \"G-ZERO CMS\",\n    \"pl\": \"G-ZERO CMS\"\n  },\n}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>obj</p> ",
            "optional": false,
            "field": "data",
            "description": "<p>obj of all options in category</p> "
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/OptionController.php",
    "groupTitle": "Options"
  }
] });