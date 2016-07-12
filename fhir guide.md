# FHIR Guide

## 资源框架

```
FHIR/json examples
```

### Patient

[Patient json example](./json examples/patient.json) 病人

### Observation Example

- [ecg example](./json examples/ecg.json) 心电
- [blood pressure example](./json examples/blood pressure.json) 血压
- TODO: 血氧
- [temperature example](./json examples/temperature.json) 体温
- [Respiratory rate example](./json examples/Respiratory-rate.json) 呼吸率

## 交互

### 认证

Basic Auth

![Basic Auth](./imgs/fhir.basic auth.png)

### Patient

#### 新增一个病人信息

```http
POST http://api.viatomtech.com.cn/patient
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

Location header 属性表示访问该资源的URL

```http
Cache-Control →no-cache
Connection →Keep-Alive
Content-Length →30
Content-Type →application/json+fhir
Date →Fri, 24 Jun 2016 07:09:59 GMT
Keep-Alive →timeout=5, max=100
Location →http://api.viatomtech.com.cn/patient/5
Server →Apache/2.4.10 (Debian)

{
  "patientId": "5",
  "userId": "1"
}
```

#### 读取一个病人信息

```http
GET http://api.viatomtech.com.cn/patient/{id}
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

#### Search

***TODO:***

#### Update

***TODO:***

### Observation Resource

#### 新增一个Observation 信息

```http
POST http://api.viatomtech.com.cn/observation
```

#### 读取一个Observation

```http
GET http://api.viatomech.com.cn/observation/{id}
```

### 分享

新增一个分享

```http
POST http://api.viatomtech.com.cn/shareto
```

被分享的patient & 分享到一个账号

```json
{
  "patientId": "3",
  "toEmail": "408861086@qq.com"
}
```

### 查询

```http
GET http://api.viatomtech.com.cn/search
```

这里会返回此 user 所有上传的记录 和 分享给他的记录