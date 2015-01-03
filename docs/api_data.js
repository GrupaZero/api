define({ "api": [
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
            "type": "Boolean",
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
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Content id</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "rating",
            "description": "<p>Content rating</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "visits",
            "description": "<p>Content visit counter</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "path",
            "description": "<p>Tree path for this node</p> "
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "route",
            "description": "<p>Route for this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "author",
            "description": "<p>Author of this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isOnHome",
            "description": "<p>Home page flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isCommentAllowed",
            "description": "<p>Is comment allowed flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isPromoted",
            "description": "<p>Is promoted flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isSticky",
            "description": "<p>Is sticky flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is content active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "publishedAt",
            "description": "<p>Date of publication</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"type\": \"category\",\n  \"weight\": 3,\n  \"isActive\": false,\n  \"path\": [\n      1\n  ],\n  \"createdAt\": \"2014-12-23T13:28:23+0000\",\n  \"updatedAt\": \"2014-12-23T13:28:23+0000\",\n  \"route\": {\n      \"id\": 1,\n      \"createdAt\": \"2014-12-23T13:28:23+0000\",\n      \"updatedAt\": \"2014-12-23T13:28:23+0000\",\n      \"translations\": [\n          {\n              \"id\": 1,\n              \"lang\": \"en\",\n              \"url\": \"example-url\",\n              \"isActive\": 1,\n              \"createdAt\": \"2014-12-23T13:28:23+0000\",\n              \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n          },\n          {\n              \"id\": 2,\n              \"lang\": \"pl\",\n              \"url\": \"non\",\n              \"isActive\": 1,\n              \"createdAt\": \"2014-12-23T13:28:23+0000\",\n              \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n          }\n      ]\n  },\n  \"author\": {\n      \"id\": 1,\n      \"email\": \"a@a.pl\",\n      \"firstName\": \"John\",\n      \"lastName\": \"Doe\"\n  },\n  \"translations\": [\n      {\n          \"id\": 1,\n          \"lang\": \"en\",\n          \"title\": \"Example title\",\n          \"body\": \"Example body\",\n          \"isActive\": 1,\n          \"createdAt\": \"2014-12-23T13:28:23+0000\",\n          \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n      },\n      {\n          \"id\": 2,\n          \"lang\": \"pl\",\n          \"title\": \"title\",\n          \"body\": \"Example body\",\n          \"isActive\": 1,\n          \"createdAt\": \"2014-12-23T13:28:23+0000\",\n          \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n      }\n  ]\n}",
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
            "type": "Number",
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
            "type": "Object[]",
            "optional": false,
            "field": "meta",
            "description": "<p>Meta data for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "meta.total",
            "description": "<p>Total number elements</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "meta.perPage",
            "description": "<p>Number of elements per page</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "meta.currentPage",
            "description": "<p>Current page number</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "meta.lastPage",
            "description": "<p>Last page number</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "meta.link",
            "description": "<p>Link for this resource</p> "
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "params",
            "description": "<p>Params passed for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "params.page",
            "description": "<p>Page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "params.perPage",
            "description": "<p>Per page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "Array[]",
            "optional": false,
            "field": "params.filter",
            "description": "<p>Array of filter params</p> "
          },
          {
            "group": "Success 200",
            "type": "Array[]",
            "optional": false,
            "field": "params.orderBy",
            "description": "<p>Array of sort params</p> "
          },
          {
            "group": "Success 200",
            "type": "Array[]",
            "optional": false,
            "field": "data",
            "description": "<p>Array of Contents</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "data.id",
            "description": "<p>Content id</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "data.rating",
            "description": "<p>Content rating</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "data.visits",
            "description": "<p>Content visit counter</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data.path",
            "description": "<p>Tree path for this node</p> "
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data.route",
            "description": "<p>Route for this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data.author",
            "description": "<p>Author of this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data.translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "data.isOnHome",
            "description": "<p>Home page flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "data.isCommentAllowed",
            "description": "<p>Is comment allowed flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "data.isPromoted",
            "description": "<p>Is promoted flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "data.isSticky",
            "description": "<p>Is sticky flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "data.isActive",
            "description": "<p>Is content active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "data.publishedAt",
            "description": "<p>Date of publication</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "data.createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "data.updatedAt",
            "description": "<p>Update date</p> "
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
            "type": "Number",
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
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Content id</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "rating",
            "description": "<p>Content rating</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "visits",
            "description": "<p>Content visit counter</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "path",
            "description": "<p>Tree path for this node</p> "
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "route",
            "description": "<p>Route for this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "author",
            "description": "<p>Author of this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "children",
            "description": "<p>List of children (Array of Objects)</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isOnHome",
            "description": "<p>Home page flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isCommentAllowed",
            "description": "<p>Is comment allowed flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isPromoted",
            "description": "<p>Is promoted flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isSticky",
            "description": "<p>Is sticky flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is content active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "publishedAt",
            "description": "<p>Date of publication</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"type\": \"category\",\n  \"weight\": 3,\n  \"isActive\": false,\n  \"path\": [\n      1\n  ],\n  \"createdAt\": \"2014-12-23T13:28:23+0000\",\n  \"updatedAt\": \"2014-12-23T13:28:23+0000\",\n  \"route\": {\n      \"id\": 1,\n      \"createdAt\": \"2014-12-23T13:28:23+0000\",\n      \"updatedAt\": \"2014-12-23T13:28:23+0000\",\n      \"translations\": [\n          {\n              \"id\": 1,\n              \"lang\": \"en\",\n              \"url\": \"example-url\",\n              \"isActive\": 1,\n              \"createdAt\": \"2014-12-23T13:28:23+0000\",\n              \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n          },\n          {\n              \"id\": 2,\n              \"lang\": \"pl\",\n              \"url\": \"non\",\n              \"isActive\": 1,\n              \"createdAt\": \"2014-12-23T13:28:23+0000\",\n              \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n          }\n      ]\n  },\n  \"author\": {\n      \"id\": 1,\n      \"email\": \"a@a.pl\",\n      \"firstName\": \"John\",\n      \"lastName\": \"Doe\"\n  },\n  \"translations\": [\n      {\n          \"id\": 1,\n          \"lang\": \"en\",\n          \"title\": \"Example title\",\n          \"body\": \"Example body\",\n          \"isActive\": 1,\n          \"createdAt\": \"2014-12-23T13:28:23+0000\",\n          \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n      },\n      {\n          \"id\": 2,\n          \"lang\": \"pl\",\n          \"title\": \"title\",\n          \"body\": \"Example body\",\n          \"isActive\": 1,\n          \"createdAt\": \"2014-12-23T13:28:23+0000\",\n          \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n      }\n  ]\n   \"children\": [\n       {Content},\n       ...\n   ]\n}",
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
            "type": "Object[]",
            "optional": false,
            "field": "meta",
            "description": "<p>Meta data for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "meta.total",
            "description": "<p>Total number elements</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "meta.perPage",
            "description": "<p>Number of elements per page</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "meta.currentPage",
            "description": "<p>Current page number</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "meta.lastPage",
            "description": "<p>Last page number</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "meta.link",
            "description": "<p>Link for this resource</p> "
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "params",
            "description": "<p>Params passed for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "params.page",
            "description": "<p>Page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "params.perPage",
            "description": "<p>Per page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "Array[]",
            "optional": false,
            "field": "params.filter",
            "description": "<p>Array of filter params</p> "
          },
          {
            "group": "Success 200",
            "type": "Array[]",
            "optional": false,
            "field": "params.orderBy",
            "description": "<p>Array of sort params</p> "
          },
          {
            "group": "Success 200",
            "type": "Array[]",
            "optional": false,
            "field": "data",
            "description": "<p>Array of Contents</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "data.id",
            "description": "<p>Content id</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "data.rating",
            "description": "<p>Content rating</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "data.visits",
            "description": "<p>Content visit counter</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data.path",
            "description": "<p>Tree path for this node</p> "
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data.route",
            "description": "<p>Route for this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data.author",
            "description": "<p>Author of this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "data.translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "data.isOnHome",
            "description": "<p>Home page flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "data.isCommentAllowed",
            "description": "<p>Is comment allowed flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "data.isPromoted",
            "description": "<p>Is promoted flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "data.isSticky",
            "description": "<p>Is sticky flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "data.isActive",
            "description": "<p>Is content active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "data.publishedAt",
            "description": "<p>Date of publication</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "data.createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "data.updatedAt",
            "description": "<p>Update date</p> "
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
    "url": "/admin/contents/:id/translations/:id",
    "title": "8. GET single translation entity",
    "version": "0.1.0",
    "name": "GetContentTranslation",
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
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>The Content ID</p> "
          },
          {
            "group": "Parameter",
            "type": "Number",
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
    "groupTitle": "",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ContentTranslation id</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>Language code</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>Title</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "body",
            "description": "<p>Body</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date of translation</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date of translation</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"lang\": \"en\",\n  \"title\": \"Example title\",\n  \"body\": \"Example body\",\n  \"isActive\": 1,\n  \"createdAt\": \"2014-12-24T10:57:39+0000\",\n  \"updatedAt\": \"2014-12-24T10:57:39+0000\"\n}",
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
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Content id</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "rating",
            "description": "<p>Content rating</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "visits",
            "description": "<p>Content visit counter</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "path",
            "description": "<p>Tree path for this node</p> "
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "route",
            "description": "<p>Route for this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "author",
            "description": "<p>Author of this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "children",
            "description": "<p>List of children (Array of Objects)</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isOnHome",
            "description": "<p>Home page flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isCommentAllowed",
            "description": "<p>Is comment allowed flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isPromoted",
            "description": "<p>Is promoted flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isSticky",
            "description": "<p>Is sticky flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is content active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "publishedAt",
            "description": "<p>Date of publication</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"type\": \"category\",\n  \"weight\": 3,\n  \"isActive\": false,\n  \"path\": [\n      1\n  ],\n  \"createdAt\": \"2014-12-23T13:28:23+0000\",\n  \"updatedAt\": \"2014-12-23T13:28:23+0000\",\n  \"route\": {\n      \"id\": 1,\n      \"createdAt\": \"2014-12-23T13:28:23+0000\",\n      \"updatedAt\": \"2014-12-23T13:28:23+0000\",\n      \"translations\": [\n          {\n              \"id\": 1,\n              \"lang\": \"en\",\n              \"url\": \"example-url\",\n              \"isActive\": 1,\n              \"createdAt\": \"2014-12-23T13:28:23+0000\",\n              \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n          },\n          {\n              \"id\": 2,\n              \"lang\": \"pl\",\n              \"url\": \"non\",\n              \"isActive\": 1,\n              \"createdAt\": \"2014-12-23T13:28:23+0000\",\n              \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n          }\n      ]\n  },\n  \"author\": {\n      \"id\": 1,\n      \"email\": \"a@a.pl\",\n      \"firstName\": \"John\",\n      \"lastName\": \"Doe\"\n  },\n  \"translations\": [\n      {\n          \"id\": 1,\n          \"lang\": \"en\",\n          \"title\": \"Example title\",\n          \"body\": \"Example body\",\n          \"isActive\": 1,\n          \"createdAt\": \"2014-12-23T13:28:23+0000\",\n          \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n      },\n      {\n          \"id\": 2,\n          \"lang\": \"pl\",\n          \"title\": \"title\",\n          \"body\": \"Example body\",\n          \"isActive\": 1,\n          \"createdAt\": \"2014-12-23T13:28:23+0000\",\n          \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n      }\n  ]\n   \"children\": [\n       {Content},\n       ...\n   ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/admin/contents/:id/translations",
    "title": "7. GET collection of translations",
    "version": "0.1.0",
    "name": "GetTranslationList",
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
            "type": "Number",
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
    "groupTitle": "",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "meta",
            "description": "<p>Meta data for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "meta.total",
            "description": "<p>Total number elements</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "meta.perPage",
            "description": "<p>Number of elements per page</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "meta.currentPage",
            "description": "<p>Current page number</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "meta.lastPage",
            "description": "<p>Last page number</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "meta.link",
            "description": "<p>Link for this resource</p> "
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "params",
            "description": "<p>Params passed for current request</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "params.page",
            "description": "<p>Page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "params.perPage",
            "description": "<p>Per page parameter</p> "
          },
          {
            "group": "Success 200",
            "type": "Array[]",
            "optional": false,
            "field": "params.filter",
            "description": "<p>Array of filter params</p> "
          },
          {
            "group": "Success 200",
            "type": "Array[]",
            "optional": false,
            "field": "params.orderBy",
            "description": "<p>Array of sort params</p> "
          },
          {
            "group": "Success 200",
            "type": "Array[]",
            "optional": false,
            "field": "translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>Language code</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>Title</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "body",
            "description": "<p>Body</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date of translation</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "updatedAt",
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
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Content id</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "rating",
            "description": "<p>Content rating</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "visits",
            "description": "<p>Content visit counter</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "path",
            "description": "<p>Tree path for this node</p> "
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "route",
            "description": "<p>Route for this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "author",
            "description": "<p>Author of this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isOnHome",
            "description": "<p>Home page flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isCommentAllowed",
            "description": "<p>Is comment allowed flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isPromoted",
            "description": "<p>Is promoted flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isSticky",
            "description": "<p>Is sticky flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is content active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "publishedAt",
            "description": "<p>Date of publication</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"type\": \"category\",\n  \"weight\": 3,\n  \"isActive\": false,\n  \"path\": [\n      1\n  ],\n  \"createdAt\": \"2014-12-23T13:28:23+0000\",\n  \"updatedAt\": \"2014-12-23T13:28:23+0000\",\n  \"route\": {\n      \"id\": 1,\n      \"createdAt\": \"2014-12-23T13:28:23+0000\",\n      \"updatedAt\": \"2014-12-23T13:28:23+0000\",\n      \"translations\": [\n          {\n              \"id\": 1,\n              \"lang\": \"en\",\n              \"url\": \"example-url\",\n              \"isActive\": 1,\n              \"createdAt\": \"2014-12-23T13:28:23+0000\",\n              \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n          },\n          {\n              \"id\": 2,\n              \"lang\": \"pl\",\n              \"url\": \"non\",\n              \"isActive\": 1,\n              \"createdAt\": \"2014-12-23T13:28:23+0000\",\n              \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n          }\n      ]\n  },\n  \"author\": {\n      \"id\": 1,\n      \"email\": \"a@a.pl\",\n      \"firstName\": \"John\",\n      \"lastName\": \"Doe\"\n  },\n  \"translations\": [\n      {\n          \"id\": 1,\n          \"lang\": \"en\",\n          \"title\": \"Example title\",\n          \"body\": \"Example body\",\n          \"isActive\": 1,\n          \"createdAt\": \"2014-12-23T13:28:23+0000\",\n          \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n      },\n      {\n          \"id\": 2,\n          \"lang\": \"pl\",\n          \"title\": \"title\",\n          \"body\": \"Example body\",\n          \"isActive\": 1,\n          \"createdAt\": \"2014-12-23T13:28:23+0000\",\n          \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n      }\n  ]\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/admin/contents/:id/translations",
    "title": "9. POST newly created translation",
    "version": "0.1.0",
    "name": "PostContentTranslation",
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
            "type": "Number",
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
    "groupTitle": "",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ContentTranslation id</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>Language code</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>Title</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "body",
            "description": "<p>Body</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date of translation</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date of translation</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"lang\": \"en\",\n  \"title\": \"Example title\",\n  \"body\": \"Example body\",\n  \"isActive\": 1,\n  \"createdAt\": \"2014-12-24T10:57:39+0000\",\n  \"updatedAt\": \"2014-12-24T10:57:39+0000\"\n}",
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
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Content id</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "rating",
            "description": "<p>Content rating</p> "
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "visits",
            "description": "<p>Content visit counter</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "path",
            "description": "<p>Tree path for this node</p> "
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "route",
            "description": "<p>Route for this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "author",
            "description": "<p>Author of this Content</p> "
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "translations",
            "description": "<p>List of active translations (Array of Objects)</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isOnHome",
            "description": "<p>Home page flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isCommentAllowed",
            "description": "<p>Is comment allowed flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isPromoted",
            "description": "<p>Is promoted flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isSticky",
            "description": "<p>Is sticky flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "isActive",
            "description": "<p>Is content active flag</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "publishedAt",
            "description": "<p>Date of publication</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "createdAt",
            "description": "<p>Creation date</p> "
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "updatedAt",
            "description": "<p>Update date</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"id\": 1,\n  \"type\": \"category\",\n  \"weight\": 3,\n  \"isActive\": false,\n  \"path\": [\n      1\n  ],\n  \"createdAt\": \"2014-12-23T13:28:23+0000\",\n  \"updatedAt\": \"2014-12-23T13:28:23+0000\",\n  \"route\": {\n      \"id\": 1,\n      \"createdAt\": \"2014-12-23T13:28:23+0000\",\n      \"updatedAt\": \"2014-12-23T13:28:23+0000\",\n      \"translations\": [\n          {\n              \"id\": 1,\n              \"lang\": \"en\",\n              \"url\": \"example-url\",\n              \"isActive\": 1,\n              \"createdAt\": \"2014-12-23T13:28:23+0000\",\n              \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n          },\n          {\n              \"id\": 2,\n              \"lang\": \"pl\",\n              \"url\": \"non\",\n              \"isActive\": 1,\n              \"createdAt\": \"2014-12-23T13:28:23+0000\",\n              \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n          }\n      ]\n  },\n  \"author\": {\n      \"id\": 1,\n      \"email\": \"a@a.pl\",\n      \"firstName\": \"John\",\n      \"lastName\": \"Doe\"\n  },\n  \"translations\": [\n      {\n          \"id\": 1,\n          \"lang\": \"en\",\n          \"title\": \"Example title\",\n          \"body\": \"Example body\",\n          \"isActive\": 1,\n          \"createdAt\": \"2014-12-23T13:28:23+0000\",\n          \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n      },\n      {\n          \"id\": 2,\n          \"lang\": \"pl\",\n          \"title\": \"title\",\n          \"body\": \"Example body\",\n          \"isActive\": 1,\n          \"createdAt\": \"2014-12-23T13:28:23+0000\",\n          \"updatedAt\": \"2014-12-23T13:28:23+0000\"\n      }\n  ]\n}",
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
            "type": "String",
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
            "type": "String",
            "optional": false,
            "field": "code",
            "description": "<p>Lang code</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "i18n",
            "description": "<p>Lang i18n code</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "is_enabled",
            "description": "<p>Flag if language is enabled</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
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
            "type": "Array[]",
            "optional": false,
            "field": "data",
            "description": "<p>Array of Languages</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.code",
            "description": "<p>Lang code</p> "
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.i18n",
            "description": "<p>Lang i18n code</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "data.is_enabled",
            "description": "<p>Flag if language is enabled</p> "
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "data.is_default",
            "description": "<p>Flag if language is default</p> "
          }
        ]
      }
    },
    "filename": "src/Gzero/Api/Controller/Admin/LangController.php",
    "groupTitle": "Language"
  }
] });