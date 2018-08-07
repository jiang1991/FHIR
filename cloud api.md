## Checkme Cloud API

> Guide
>
> To obtain observation detail(measurements) information from checkme cloud, please do as follows:
>
> 1. Query all patients use your Checkme account email and password.
> 2. Read the information of one patient with **patient_id** and query all observations.
> 3. Read the observation detail with **observation_id**.
> 4. Analyze observation json file.



### Create a user for your company

for now, we only support "company = RAHAH"

```http
POST http://cloud.viatomtech.com/user/signup
```

**response:**

```json
{
    "status": "ok",
    "user_id": 605,
    "name": "jiang",
    "company": "RAHAH"
}
```



### Get notification from Viatom cloud

Viatom will send you a notification when the company belongs to your company. The example are show as belows.

- new patient

  ```json
  {
      "user_id": 605,
      "company": "RAHAH",
      "type": "patient",
      "patient": 1156
  }
  ```

- new observation

  ```json
  {
      "user_id": 605,
      "company": "RAHAH",
      "type": "observation",
      "patient": 1156,
      "observation_id": 111109,
      "resource_type": "daily check"
  }
  ```

  ​

### Query all patients

```http
GET https://cloud.viatomtech.com/search/patient
```

***Auth: Basic Auth***

Response example:

```json
[
  {
    "patient_id": 1,
    "medical_id": "420381199108136270",
    "name": "Wang Jiang"
  },
  {
    "patient_id": 81,
    "medical_id": "114071010122",
    "name": "jiang"
  }
]
```

### Read patient info with patient_id

```http
GET https://cloud.viatomtech.com/patient/{patient_id}
```

***Auth: Basic Auth***

Response example:

```json
{
  "resourceType": "Patient",
  "user_id": 1,
  "identifier": {
    "system": "https://cloud.viatomtech.com/fhir",
    "value": "01",
    "medicalId": "420381199108136270"
  },
  "name": "Wang Jiang",
  "gender": "male",
  "birthDate": "1991-11-14",
  "height": "180cm",
  "weight": "56kg",
  "stepSize": "50cm"
}
```

### Query all observations with patient_id 

```http
GET https://cloud.viatomtech.com/search/{patient_id}/observation
```

***Auth: Basic Auth***

Response example:

```json
[
  {
    "patient_id": "81",
    "observation_id": 615,
    "resorce_id": "Relax me",
    "device_sn": "1407101012"
  },
  {
    "patient_id": "81",
    "observation_id": 616,
    "resorce_id": "daily check",
    "device_sn": "1407101012"
  },
  {
    "patient_id": "81",
    "observation_id": 617,
    "resorce_id": "daily check",
    "device_sn": "1407101012"
  },
  {
    "patient_id": "81",
    "observation_id": 618,
    "resorce_id": "daily check",
    "device_sn": "1407101012"
  }
]
```

### Read observation detail with observation_id

```http
GET https://cloud.viatomtech.com/observation/{observation_id}
```

***Auth: Basic Auth***

```json
{
  "ResourceType": "Observation",
  "id": "daily check",
  "identifier": {
    "system": "http://api.viatomtech.com.cn/fhir",
    "value": "1611100471161110047120170109220641"
  },
  "category": {
    "coding": {
      "system": "http://hl7.org/fhir/observation-category",
      "code": "procedure",
      "display": "Procedure"
    }
  },
  "code": {
    "coding": {
      "system": "http://115.159.104.246/fhir",
      "code": "160401",
      "display": "Daily_Check"
    }
  },
  "effectiveDateTime": "2017-01-09 22:06:41",
  "interpretation": {
    "coding": {
      "system": "http://hl7.org/fhir/v2/0078",
      "code": "N",
      "display": "Normal"
    },
    "text": "Szabályos EKG ritmus, Normal Blood Oxygen"
  },
  "device": {
    "sn": "1611100471",
    "display": "Checkme Pro CE"
  },
  "component": [
    {
      "code": {
        "coding": {
          "system": "http://loinc.org",
          "code": "8867-4",
          "display": "Heart rate"
        }
      },
      "valueQuantity": {
        "value": "63",
        "unit": "/min",
        "system": "http://unitsofmeasure.org",
        "code": "/min"
      }
    },
    {
      "code": {
        "coding": {
          "system": "http://loinc.org",
          "code": "8633-0",
          "display": "QRS duration"
        }
      },
      "valueQuantity": {
        "value": "87",
        "unit": "ms",
        "system": "http://unitsofmeasure.org",
        "code": "ms"
      }
    },
    {
      "code": {
        "coding": {
          "system": "http://loinc.org",
          "code": "76053-8",
          "display": "ST Segment.lead I"
        }
      },
      "valueQuantity": {
        "value": "--",
        "unit": "mV",
        "system": "http://unitsofmeasure.org",
        "code": "mV"
      }
    },
    {
      "code": {
        "coding": {
          "system": "http://loinc.org",
          "code": "8634-8",
          "display": "Q-T interval"
        }
      },
      "valueQuantity": {
        "value": "357",
        "unit": "ms",
        "system": "http://unitsofmeasure.org",
        "code": "s"
      }
    },
    {
      "code": {
        "coding": {
          "system": "http://loinc.org",
          "code": "8636-3",
          "display": "Q-T interval corrected"
        }
      },
      "valueQuantity": {
        "value": "365",
        "unit": "ms",
        "system": "http://unitsofmeasure.org",
        "code": "s"
      }
    },
    {
      "code": {
        "coding": {
          "system": "http://loinc.org",
          "code": "76126-2",
          "display": "Premature ventricular contractions [#]"
        }
      },
      "valueQuantity": {
        "value": "0",
        "unit": "beats",
        "system": "http://unitsofmeasure.org",
        "code": "beats"
      }
    },
    {
      "code": {
        "coding": {
          "system": "http://loinc.org",
          "code": "8480-6",
          "display": "Systolic blood pressure"
        }
      },
      "valueQuantity": {
        "value": "115",
        "unit": "mmHg",
        "system": "http://unitsofmeasure.org",
        "code": "mm[Hg]"
      }
    },
    {
      "code": {
        "coding": {
          "system": "http://loinc.org",
          "code": "8462-4",
          "display": "Diastolic blood pressure"
        }
      },
      "valueQuantity": {
        "value": "--",
        "unit": "mmHg",
        "system": "http://unitsofmeasure.org",
        "code": "mm[Hg]"
      }
    },
    {
      "code": {
        "coding": {
          "system": "http://loinc.org",
          "code": "20564-1",
          "display": "Oxygen saturation in Blood"
        }
      },
      "valueQuantity": {
        "value": "99",
        "unit": "%",
        "system": "http://unitsofmeasure.org",
        "code": "%"
      }
    },
    {
      "code": {
        "coding": {
          "system": "http://loinc.org",
          "code": "61006-3",
          "display": "Perfusion index Tissue by Pulse oximetry"
        }
      },
      "valueQuantity": {
        "value": "0.5",
        "unit": "",
        "system": "http://unitsofmeasure.org",
        "code": "%"
      }
    },
    {
      "code": {
        "coding": {
          "system": "urn:oid:2.16.840.1.113883.6.24",
          "code": "131329",
          "display": "MDC_ECG_ELEC_POTL_I"
        }
      },
      "valueString": "f2ffefffeffff0fff1fff0ffecffe7ffe2ffdeffd9ffd6ffd4..."
    }
  ]
}
```

### Analyze observation json file

| Key                              | --                                       |
| -------------------------------- | ---------------------------------------- |
| "id"                             | observation (measurement) type           |
| "identifier->value"              | a unique value to identify an observation |
| "effectiveDateTime"              | observation record time                  |
| "subject->reference"             | patient_id                               |
| "interpretation->text"           | description of the observation           |
| "device->sn" \ "device->display" | device information                       |
| "component"                      | detail measurement of an observation     |

in the `component` part, every measurement goes like this

```json
... 
{
   "code": {
      "coding": {
        "system": "http://loinc.org",
        "code": "20564-1",
        "display": "Oxygen saturation in Blood"
      }
    },
    "valueQuantity": {
       "value": "99",
       "unit": "%",
       "system": "http://unitsofmeasure.org",
       "code": "%"
     }
 },
...
```

`code->coding->display` refer to measurement type.

`valueQuantity->vlue` and `valueQuantity->unit` refer to the value of this measurement.



if value of  `code->coding->display`  is `"MDC_ECG_ELEC_POTL_I"` , then the measurement is ECG waveform original data.

**Parse ECG valueString**

ECG string example:

```json
"20000a00fafff7fff8ffedffd1ffb7ffb2ffb7ffadff91ff79ff76ff84ff87ff76ff6aff70ff7eff82ff78ff6fff74ff7eff81ff78ff72ff77ff7fff84ff7fff..."
```

1. Split the string into signed 16 bit for every 4 character, then reverse first 2 character and last character, then we get each stored ECG data. e.g.: the string are as above, the stored sampling ECG data is `[0020, 000a, fffa, fff7, ...]`.
2. The ECG data is `n(hex)`, if `n(dec)` is large than `32767(dec)`, then `n(dec) =  n(dec) - 65536`. and reduced to the actual voltage `X(n)(mV)` signal formula is `X(n) = (n*4033)/(32767*12*8)`.
3. ECG sampling rate is 500 Hz, 16 bit. When storing data, we adopt the TP compression algorithm, and the stored data sampling rate is 250 Hz. To revert to the original data, only need to average two adjacent data inserted between the two data. e.g.: the data is `[n1, n2, n3, n4, ...]`, the original data is `[n1, (n1+n2)/2 ,n2, (n2+n3)/2, n3, (n3+n4)/2, n4, …]`.

so the actual voltage of the ECG string example is `[0.041, 0.027, 0.013, 0.0035, -0.006, -0.0035, -0.001, ...]`.