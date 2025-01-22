# Health Check Endpoint

This endpoint returns the current status of the application to confirm it's running and responsive.

It conforms to
the [IETF's healthcheck draft RFC](https://datatracker.ietf.org/doc/html/draft-inadarei-api-health-check-06).

---

## Health Check Response Format

Health Check Response Format uses the JSON format and has the media type `application/health+json`.

Its content consists of a single mandatory root field (`status`) and several optional fields:

### status

`status` (required): Indicates whether the service status is acceptable or not. Possible values:

- `pass`: healthy
- `fail`: unhealthy
- `warn`: healthy, with some concerns

The value of the status field is tightly related with the HTTP response code returned by the health endpoint.

- For `pass` status, HTTP response code will be **200 OK**.
- For `fail` status, HTTP response code will be **503 Service Unavailable**.
- In case of the `warn` status, HTTP response code will be **200 OK**, and additional information will be provided in
  the response.

## Example

```
GET /health HTTP/1.1
Accept: application/health+json

HTTP/1.1 200 OK
Content-Type: application/health+json
Cache-Control: max-age=3600

{
    "status": "pass",
    "checks": {
        "postgresql:responseTime": {
            "componentType": "datastore",
            "observedValue": 24,
            "observedUnit": "ms",
            "status": "pass",
            "time": "2025-01-22T12:50:45+00:00"
        }
    }
}
```
