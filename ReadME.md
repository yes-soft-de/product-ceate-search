# Product-create-search
Create, Update and delete with Mysql.

Send to Kafka

Search using ElasticSearch


## How to use:
1. Clone.

2. Composer update.

3. start the fallowing applications:
   1. Elastic Search
   2. XAMPP MySQL (What we tested upon)
   3. Kafka Zookeeper
   4. Kafka Server
   5. Logstash, For Completeness Sake =) 
   
4. Edit .env file for MySQL user name and password and DB name.

5. If this is your first time running the backend

	```
    php bin/console doctrine:database:create
 php bin/console make:migration
    php bin/console doctrine:migrations:migrate
   ```
	
8. Create table.

9. Use PostMan to see the result.

## API Endpoints 



### Create Painting API:

This API is used to create Paintings in the cloud

##### Route:

```
http://localhost:8000/painting/create
```

##### Request 

```json
{
	"name": string,
	"image_url": string,
	"description": string,
	"size": string,
	"medium": string,
	"category": string
}
```

##### Response

```
{
    "status_code": HTTP_STATUS_CODE,
    "msg": String
}
```

### Update Painting API:

This API is used to update existing paintings

##### Route:

```
http://localhost:8000/painting/update
```

##### Request:

```json
{
	"id": int,
	"name": string,
	"image_url": url,
	"description": string,
	"size": string,
	"medium": string,
	"category": string
}
```

##### Response:

```
{
    "status_code": HTTP_STATUS_CODE,
    "msg": String
}
```

### Delete Painting API:

##### Route:

```
http://localhost:8000/painting/delete
```

##### Request:

```json
{
    "id": int
}
```

##### Response:

```json
{
    "status_code": HTTP_STATUS_CODE,
    "msg": String
}
```



### Search Painting API:

##### Route:

```
http://localhost:8000/painting/search
```

##### Request:

```json
{
    "query": string
}
```

##### Response:

```json
{
    "status_code": HTTP_STATUS_CODE,
    "data": <painting_array>
}
```

##### Note On `Painting Array`:

it has the fallowing format:

```json
{
	"status": string,
	"imageUrl": url,
	"size": string,
	"message": string,
	"@version": string,
	"id": int,
	"name": string,
	"description": string,
	"category": string,
	"medium": string,
	"@timestamp": Date String Time Stamp
}
```

