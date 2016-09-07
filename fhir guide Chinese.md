# FHIR 手册

## FHIR Resource 示例 

```
FHIR/json examples
```

### Patient

[Patient json example](https://github.com/jiang1991/FHIR/tree/master/json%20examples/patient.json) Patient

### Observation Example

- [ekg example](https://github.com/jiang1991/FHIR/tree/master/json%20examples/ecg.json) 心电 FHIR json
- [blood pressure example](https://github.com/jiang1991/FHIR/tree/master/json%20examples/blood pressure.json) 血压 FHIR json
- [SpO2 Exmaple](https://github.com/jiang1991/FHIR/tree/master/json%20examples/SaO2.json) 血氧 FHIR json
- [temperature example](https://github.com/jiang1991/FHIR/tree/master/json%20examples/temperature.json) 体温 FHIR json
- [Respiratory rate example](https://github.com/jiang1991/FHIR/tree/master/json%20examples/Respiratory-rate.json) 呼吸率 FHIR json
- [O2 Sleep example](https://github.com/jiang1991/FHIR/tree/master/json%20examples/Sleep%20-%20o2.json)  O2 睡眠 FHIR json
- [Checkme Sleep example](https://github.com/jiang1991/FHIR/blob/master/json%20examples/Sleep%20-%20checkme.json) Checkme 睡眠 FHIR json
- [Daily Check example](https://github.com/jiang1991/FHIR/tree/master/json%20examples/Daily%20Check.json) Daily Check json

## 与云服务器交互

### 认证

Basic Auth

![Basic Auth](./imgs/fhir.basic auth.png)

### 登陆

```http
POST https://cloud.viatomtech.com/user/login

header:
Content-Type: application/x-www-form-urlencoded
```

Key: email, password

成功返回: (Status: 200 OK)

```json
{
  "user_id": 3,
  "name": "Jiang",
  "email": "408861086@qq.com"
}
```

错误返回: (Status: 401 Unauthorized)

```json
{
  "error": "Email or Password invalid!"
}
```



### Patient

#### 新增 Patient resource

```http
POST http://115.159.104.246/patient
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

示例返回：

**Location** 指明了获取此 patient resource 的 url 路径

```http
Cache-Control →no-cache
Connection →Keep-Alive
Content-Length →30
Content-Type →application/json+fhir
Date →Fri, 24 Jun 2016 07:09:59 GMT
Keep-Alive →timeout=5, max=100
Location →http://115.159.104.246/patient/5
Server →Apache/2.4.10 (Debian)

{
  "patientId": "5",
  "userId": "1"
}
```

#### 读取 a Patient

```http
GET http://115.159.104.246/patient/{id}
```

get 请求示例:

```http
Authorization: Basic d2FuZ2ppYW5nQHZpYXRvbXRlY2guY29tOlZpYXRvbTRF
Accept: application/xml+fhir
```

返回示例:

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
    "system": "http://www.viatomtech.com.cn:8080/fhir/public",
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

#### 新增 Observation resource

```http
POST http://115.159.104.246/observation
```

POST 示例:

```http
Authorization: Basic d2FuZ2ppYW5nQHZpYXRvbXRlY2guY29tOlZpYXRvbTRF
Accept: application/json+fhir
Content-Type: application/json+fhir

{
  "resourceType": "Observation",
  ...
}
```

#### 读取 a Observation

```http
GET http://115.159.104.246/observation/{id}
```

成功返回: (Status: 200 OK)

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

错误: (Status: 404 Not Found)

### 分享

分享一个 patient 到另一个 云账户

```http
POST http://115.159.104.246/shareto
```

POST 请求示例:

```json
{
  "patientId": "3",
  "toEmail": "408861086@qq.com"
}
```

读取所有分享到发送请求的用户的 patient

```http
GET http://115.159.104.246/shareto
```

示例返回: (这里只有一个被分享的 patient)

```json
[
  {
    "resourceType": "Patient",
    "user_id": "1",
    "identifier": {
      "system": "http://www.viatomtech.com.cn",
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

### 查询

#### 查询所有该用户上传的patient

```http
GET http://115.159.104.246/search/patient
```

示例返回：

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

