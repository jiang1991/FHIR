# Observation

```json
{
  "resourceType": "Observation",
  "id": "blood-pressure",
  "meta": {
    "lastUpdated": "2016-05-31 16:28:30"
  },
  "text": {
    "status": "generated",
    "div": "<div>...</div>"
  },
}
```

```json
"identifier": [
    {
      "system": "urn:ietf:rfc:3986",
      "value": "urn:uuid:187e0c12-8dd2-67e2-99b2-bf273c878281"
    }
  ],
```

*"system" 固定，Value可以算，使用"urn:guid"*

```php
public function create_guid(){　$charid = strtoupper(md5(uniqid(mt_rand(), true)));　$hyphen = chr(45);// "-"　$uuid = substr($charid, 6, 2).substr($charid, 4, 2).substr($charid, 2, 2).substr($charid, 0, 2).$hyphen　.substr($charid, 10, 2).substr($charid, 8, 2).$hyphen　.substr($charid,14, 2).substr($charid,12, 2).$hyphen　.substr($charid,16, 4).$hyphen　.substr($charid,20,12);　return $uuid;　}
```

```json
"status": "final",
```

*结束即为 final http://hl7-fhir.github.io/valueset-observation-status.html#expansion*

```json
"category": {
    "coding": [
      {
        "system": "http://hl7.org/fhir/observation-category",
        "code": "vital-signs",
        "display": "Vital Signs"
      }
    ]
  },
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "55284-4",
        "display": "Blood pressure systolic & diastolic"
      }
    ]
  },
```

*http://hl7-fhir.github.io/valueset-observation-category.html 血压为生命体征的派生*

```json
"subject": {
    "reference": "Patient/example"
  },
```

*Who and/or what this is about 哪位*

```json
"effectiveDateTime": "2016-05-31",
```

*effectiveDateTime or effectivePeriod*

```json
"performer": [
    {
      "reference": "Practitioner/example"
    }
  ],
```

*负责人 or 医生*

```json
"interpretation": {
    "coding": [
      {
        "system": "http://hl7.org/fhir/v2/0078",
        "code": "L",
        "display": "low"
      }
    ],
    "text": "Below low normal"
  },
```

*high or low, "text" can be filled with some words*

```json
"component": [
    {
      "code": {
        "coding": [
          {
            "system": "http://loinc.org",
            "code": "8480-6",
            "display": "Systolic blood pressure"
          },
          {
            "system": "http://snomed.info/sct",
            "code": "271649006",
            "display": "Systolic blood pressure"
          },
          {
            "system": "http://acme.org/devices/clinical-codes",
            "code": "bp-s",
            "display": "Systolic Blood pressure"
          }
        ]
      },
      "valueQuantity": {
        "value": 107,
        "unit": "mmHg",
        "system": "http://unitsofmeasure.org",
        "code": "mm[Hg]"
      }
    },
    {
      "code": {
        "coding": [
          {
            "system": "http://loinc.org",
            "code": "8462-4",
            "display": "Diastolic blood pressure"
          }
        ]
      },
      "valueQuantity": {
        "value": 60,
        "unit": "mmHg",
        "system": "http://unitsofmeasure.org",
        "code": "mm[Hg]"
      }
    }
  ]
```

