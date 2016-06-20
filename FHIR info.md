# FHIR Server

## 交互

- Create = POST https://example.com/path/{resourceType}
- Read = GET https://example.com/path/{resourceType}/{id}
- Update = PUT https://example.com/path/{resourceType}/{id}
- Delete = DELETE https://example.com/path/{resourceType}/{id}
- Search = GET https://example.com/path/{resourceType}?search parameters…
- History = ~~GET https://example.com/path/{resourceType}/{id}/_history~~
- Transaction = ~~POST https://example.com/path/(POST a tranasction bundle to the system)~~
- Operation = ~~GET https://example.com/path/{resourceType}/{id}/${opname}~~


