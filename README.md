# FHIR

## Developer Introduction

### POST

#### Authorization

Bearer Token

[FHIR Security](http://hl7-fhir.github.io/security.html)

#### POST Content

```http
POST {some base path}/Patient HTTP/1.1
Authorization: Bearer 37CC0B0E-C15B-4578-9AC1-D83DCED2B2F9
Accept: application/json+fhir
Content-Type: application/json+fhir
Content-Length: 1198
 
{
  "resourceType": "Patient",
  ...
}
```

#### POST Path

http://api.viatomtech.com/fhir/{resourceType}

### Response

#### Create Response

```http
HTTP/1.1 201 Created
Content-Length: 161
Content-Type: application/json+fhir
Date: Mon, 18 Aug 2014 01:43:30 GMT
ETag: "1"
Location: http://example.com/Patient/347
 
{
  "resourceType": "OperationOutcome",
  "text": {
    "status": "generated",
    "div": "<div xmlns=\"http://www.w3.org/1999/xhtml\">The operation was successful</div>"
  }
}
```

#### Error response

```http
HTTP/1.1 422 Unprocessable Entity
Content-Length: 161
Content-Type: application/json+fhir
Date: Mon, 18 Aug 2014 01:43:30 GMT
 
{
  "resourceType": "OperationOutcome",
  "text": {
    "status": "generated",
    "div": "<div xmlns=\"http://www.w3.org/1999/xhtml\">MRN conflict
   - the MRN 123456 is already assigned to a different patient</div>"
  },
}
```

### Read Request

```http
GET https://example.com/path/{resourceType}/{id}
```

example:

```http
GET /Patient/347?_format=xml HTTP/1.1
Host: example.com
Accept: application/xml+fhir
Cache-Control: no-cache
```

### Read Response

```http
HTTP/1.1 200 OK
Content-Length: 729
Content-Type: application/xml+fhir
Last-Modified: Sun, 17 Aug 2014 15:43:30 GMT
ETag: "1"
 
<?xml version="1.0" encoding="UTF-8"?>
<Patient xmlns="http://hl7.org/fhir">
  <id value="347"/>
  <meta>
    <versionId value="1"/>
    <lastUpdated value="2014-08-17T15:43:30Z"/>
  </meta>
  <!-- content as shown above for patient -->  
</Patient>
```



### Search Request

```http
GET https://example.com/path/{resourceType}?criteria
```

example:

```http
https://example.com/base/MedicationOrder?patient=347
```

#### Search Response

```http
HTTP/1.1 200 OK
Content-Length: 14523
Content-Type: application/xml+fhir
Last-Modified: Sun, 17 Aug 2014 15:49:30 GMT
 
{
  "resourceType": "Bundle",
...
}
```



### Update Request

```http
PUT https://example.com/path/{resourceType}/{id}
```

#### Update Response

### Base Resource Content

```json
{
  "resourceType" : "X",
  "id" : "12",
  "meta" : {
    "versionId" : "12",
    "lastUpdated" : "2014-08-18T15:43:30Z",
    "profile" : ["http://example-consortium.org/fhir/profile/patient"],
    "security" : [{
      "system" : "http://hl7.org/fhir/v3/ActCode",
      "code" : "EMP"
    }],
    "tag" : [{
      "system" : "http://example.com/codes/workflow",
      "code" : "needs-review"
    }]
  },
  "implicitRules" : "http://example-consortium.org/fhir/ehr-plugins",
  "language" : "X"
}
```



