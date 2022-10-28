# API Endpoints:
 ##  Manufacturers
### Fetch manufacturers data:

URL: `/api/manufacturers`

Parameters: `none`

  

### Save manufacturer data:

URL: `/api/manufacturers/save`

Parameters: `JSON Format`
```
Sample:

{
	"manufacturer":"string",
	"type":"string",
	"color":"html HEX code (eg. #000000)"
}
```

### Delete manufacturer data:

URL: `/api/manufacturers/{manufacturer_id}`

Parameters: `JSON`
```
Sample:

{
	"manufacturer_id":"integer"
}
```
  ---
## Cars

### Fetch cars data:

URL: `/api/cars`

Parameters: `none`

  

### Save car data:

URL: `/api/cars/save`

Parameters: `JSON Format`

```
Sample:

{
"manufacturer_id":"integer", //must be existing id from records
"car_name":"string"
}
```

### Delete car data:

URL: `/api/cars/{car_id}`

Parameters: `JSON`
```
Sample:

{
	"car_id":"integer" //must be existing id from records
}
```