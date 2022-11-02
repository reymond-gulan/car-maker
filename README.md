# API Endpoints:
 ##  Manufacturers
### Fetch manufacturers data:

URL: `/api/manufacturers`
Type: `GET`
Parameters: `none`

### Get specific manufacturer's data:
URL: `/api/manufacturers/{manufacturer_id}`
Type: `GET`

### Update manufacturer's data:

URL: `/api/manufacturers/update/{manufacturer_id}`
Type: `PUT`
Parameters: `JSON`
```
{
	"manufacturer":"string",
	"type":"string",
	"color":"html HEX code (eg. #000000)"
}
```
  
### Save manufacturer data:

URL: `/api/manufacturers/save`
Type: `POST`
Parameters: `JSON`
```
{
	"manufacturer":"string",
	"type":"string",
	"color":"html HEX code (eg. #000000)"
}
```

### Delete manufacturer data:

URL: `/api/manufacturers/{manufacturer_id}`
Type: `DELETE`
Parameters: `JSON`
```
{
	"manufacturer_id":"integer"
}
```
  ---
## Cars

### Fetch cars data:

URL: `/api/cars`
Type: `GET`
Parameters: `none`

### Get specific car's data:
URL: `/api/cars/{car_id}`
Type: `GET`

### Update car's data:

URL: `/api/cars/update/{car_id}`
Type: `PUT`
Parameters: `JSON`
```
{
	"manufacturer":"string",
	"type":"string",
	"color":"html HEX code (eg. #000000)"
}
```

### Save car data:

URL: `/api/cars/save`
Type: `POST`
Parameters: `JSON`

```
{
"manufacturer_id":"integer", //must be existing id from records
"car_name":"string"
}
```

### Delete car data:

URL: `/api/cars/{car_id}`
Type: `DELETE`
Parameters: `JSON`
```
{
	"car_id":"integer" //must be existing id from records
}
```