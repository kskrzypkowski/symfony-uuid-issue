## How to reproduce issue
1. Go to `/api`
2. Click POST: /api/samples
3. Send JSON without `name` value, eg:
```json
{
  "isActive": true,
  "comment": "string"
}
```
4. Get huge lag and crash profiler

## Same path in controller
1. go to `/sample-controller`
2. See beautyfull error without deserializer issue
