# FHIR Guide

## FHIR Resource Examples

```
FHIR/json examples
```

### Patient

[Patient json example](https://github.com/jiang1991/FHIR/tree/master/json%20examples/patient.json) Patient

### Observation Example

- [ekg example](https://github.com/jiang1991/FHIR/tree/master/json%20examples/ecg.json) ECG FHIR Data
- [blood pressure example](https://github.com/jiang1991/FHIR/tree/master/json%20examples/blood pressure.json) blood pressure FHIR data
- [SpO2 Exmaple](https://github.com/jiang1991/FHIR/tree/master/json%20examples/SaO2.json) SpO2 FHIR data
- [temperature example](https://github.com/jiang1991/FHIR/tree/master/json%20examples/temperature.json) body temperature FHIR data
- [Respiratory rate example](https://github.com/jiang1991/FHIR/tree/master/json%20examples/Respiratory-rate.json) Respiratory rate FHIR data
- [O2 Sleep example](https://github.com/jiang1991/FHIR/tree/master/json%20examples/Sleep%20-%20o2.json)  O2 Sleep FHIR json
- [Checkme Sleep example](https://github.com/jiang1991/FHIR/blob/master/json%20examples/Sleep%20-%20checkme.json) Checkme Sleep FHIR json
- [Daily Check example](https://github.com/jiang1991/FHIR/tree/master/json%20examples/Daily%20Check.json) Daily Check json

## Interact with Cloud

### Auth

Basic Auth

![Basic Auth](./imgs/fhir.basic auth.png)

### Login

```http
POST https://cloud.viatomtech.com/user/login

header:
Content-Type: application/x-www-form-urlencoded
```

Key: email, password

Success Response: (Status: 200 OK)

```json
{
  "user_id": 3,
  "name": "Jiang",
  "email": "408861086@qq.com"
}
```

Error Response: (Status: 401 Unauthorized)

```json
{
  "error": "Email or Password invalid!"
}
```



### Patient

#### Create a new Patient resource

```http
POST https://cloud.viatomtech.com/patient
```

post example:

```http
Authorization: Basic d2FuZ2ppYW5nQHZpYXRvbXRlY2guY29tOlZpYXRvbTRF
Accept: application/json+fhir
Content-Type: application/json+fhir

{
  "resourceType": "Patient",
  ...
}
```

Response example：

**Location** in http header represent the URL to get this Patient resource

```http
Cache-Control →no-cache
Connection →Keep-Alive
Content-Length →30
Content-Type →application/json+fhir
Date →Fri, 24 Jun 2016 07:09:59 GMT
Keep-Alive →timeout=5, max=100
Location →https://cloud.viatomtech.com/patient/5
Server →Apache/2.4.10 (Debian)

{
  "patientId": "5",
  "userId": "1"
}
```

#### **Read** a Patient

```http
GET https://cloud.viatomtech.com/patient/{id}
```

get example:

```http
Authorization: Basic d2FuZ2ppYW5nQHZpYXRvbXRlY2guY29tOlZpYXRvbTRF
Accept: application/xml+fhir
```

Response example:

```http
Cache-Control →no-cache
Connection →Keep-Alive
Content-Length →296
Content-Type →application/json+fhir
Date →Fri, 24 Jun 2016 07:34:20 GMT
Keep-Alive →timeout=5, max=100
Server →Apache/2.4.10 (Debian)

{
  "resourceType": "Patient",
  "userId": "1",
  "identifier": {
    "system": "https://cloud.viatomtech.com",
    "value": "CS0010404",
    "medicalId": "420381199108136273"
  },
  "active": "1",
  "name": "Wang Jiang -3",
  "gender": "male",
  "birthDate": "1991-11-14",
  "height": "179cm",
  "weight": "56kg",
  "stepSize": "50cm"
}
```

### Observation Resource

#### Create a new Observation resource

```http
POST https://cloud.viatomtech.com/observation
```

POST Examples:

```http
Authorization: Basic d2FuZ2ppYW5nQHZpYXRvbXRlY2guY29tOlZpYXRvbTRF
Accept: application/json+fhir
Content-Type: application/json+fhir

{
  "resourceType": "Observation",
  ...
}
```

#### Read a Observation

```http
GET https://cloud.viatomtech.com/observation/{id}
```

Success Response: (Status: 200 OK)

```http
Cache-Control →no-cache
Connection →Keep-Alive
Content-Length →985
Content-Type →application/json+fhir
Date →Tue, 09 Aug 2016 04:06:18 GMT
Keep-Alive →timeout=5, max=100
Server →Apache/2.4.10 (Debian)


{
  "ResourceType": "Observation",
  "id": "blood-pressure",
  "...": "..."
}
```

Error Response: (Status: 404 Not Found)

### Share

**Create a new share with another user**

```http
POST https://cloud.viatomtech.com/shareto
```

POST keys:

```json
{
  "patientId": "3",
  "toEmail": "408861086@qq.com"
}
```

Response:

```json
{  
  "status": "ok"
}
```

**Destroy a share**

```http
DELETE https://cloud.viatomtech.com/shareto
```

DELETE json example:

```json
{
  "patientId": "3",
  "toEmail": "408861086@qq.com"
}
```

Response:

```json
{
  "status": "ok"
}
```



**Read all patient shared to current user**

```http
GET https://cloud.viatomtech.com/shareto
```

Response examples: (only 1 patient user shared)

```json
[
  {
    "resourceType": "Patient",
    "user_id": "1",
    "identifier": {
      "system": "https://cloud.viatomtech.com",
      "value": "CS0010403",
      "medicalId": "420381199108136272"
    },
    "active": "1",
    "name": "Du Fu",
    "gender": "female",
    "birthDate": "1991-11-14",
    "height": "179cm",
    "weight": "56kg",
    "stepSize": "50cm"
  }
]
```

### Search

#### search all the patient uploaded by this user

```http
GET https://cloud.viatomtech.com/search/patient
```

response example：

```json
[
  {
    "patient_id": 1,
    "medical_id": "420381199108136270",
    "name": "Wang Jiang"
  },
  {
    "patient_id": 2,
    "medical_id": "420381199108136271",
    "name": "Wang Zhihuan"
  },
  {
    "patient_id": 3,
    "medical_id": "420381199108136272",
    "name": "Du Fu"
  },
  {
    "patient_id": 6,
    "medical_id": "420381199108136000",
    "name": "Li Bai"
  },
  {
    "patient_id": 11,
    "medical_id": "0",
    "name": "Guest"
  },
  {
    "patient_id": 15,
    "medical_id": "1",
    "name": "Wang Jiang"
  }
]
```
