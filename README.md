
# Notification Gateway
A simple application to handle multi driver notification gateways

# How to Start
1. First, you should create the .env file:
```
 cp .env.example .env 
 ``` 
2. Then run the application via `docker-compose`
```  
docker-compose up -d  
```  
3. Install the packages using composer:
```  
docker-compose exec app rm -rf vendor composer.lock  
docker-compose exec app composer install  
```  
4. Generate the  `app:key` and run the migrations and seeders as well:
```  
docker-compose exec app php artisan key:generate  
docker-compose exec app php artisan migrate --seed  
```
5. Finally, to listen to the queue:
```
sudo docker-compose exec app php artisan queue:work --verbose --tries=3 --timeout=60
```
It is ready and served on port `8000`
```  
http://localhost:8000  
```
### SMS Config
For Ghasedak panel you should config these in .env
```
NOTIFICATION_DRIVER="ghasedak"
GHASEDAK_API_KEY=""
GHASEDAK_SENDER=""
```
For Kavenegar panel you should config these in .env
```
NOTIFICATION_DRIVER="kavenegar"
KAVENEGAR_SENDER=""
KAVENEGAR_API_KEY=""
```

## API Reference


#### Login
To get the bearer token you need to login with username and password
```http  
 POST /api/auth/login
 ```  
| Parameter | Type     | Description                |  
| :-------- | :------- | :------------------------- |  
| `username` | `string` | **Required**. (example:"test") |  
| `password` | `string` | **Required**. (example:123456)  |  

**success response:**
```json
{
	"status": 200,
	"results": {
		"token": "1|wYcqf2y5Wd3fV81jfEEFaxl5uzmIherNDzbfLM5e"
	}
}
```

#### Register
Register new user
```http  
 POST /api/auth/register
 ```  
| Parameter | Type     | Description                |  
| :-------- | :------- | :------------------------- |  
| `username` | `string` | **Required** |  
| `password` | `string` | **Required**  |  
| `password_confirmation` | `string` | **Required**  |  
| `email` | `string` | **Required**  |  
| `name` | `string` | **Required**  |  
| `mobile` | `string` | **Required**  | 
**success response:**
```json
{
	"status": 200,
	"results": {
		"message": "User Created Successfully",
		"token": "1|wYcqf2y5Wd3fV81jfEEFaxl5uzmIherNDzbfLM5e"
	}
}
```

#### Logout
Logout the logged in user
```http  
 POST Bearer{token} /api/auth/logout
 ```  
**success response:**
```json
{
	"status": 200,
	"results": {
		"message": "successfully Logged out."
	}
}
```


#### Send Notification (SMS)
Send a message to a receptor
```http  
 POST Bearer{token} /api/notification/send
 ```  
| Parameter | Type     | Description                |  
| :-------- | :------- | :------------------------- |  
| `message` | `string` | **Required** |  
| `receptor` | `string`/`array` | **Required** mobile number of receptors |  
**success response:**
```json
{
	"status": 200,
	"results": {
		"message": "Message sent."
	}
}
```

#### Report Notification (SMS)
Report of notifications
```http  
 POST Bearer{token} /api/notification/report
 ```  
| Parameter  | Type       | Description                                |  
|:-----------|:-----------|:-------------------------------------------|  
| `receptor` | `string`   | **optional**    filter by receptor         |  
| `driver`   | `string`   | **optional**    filter by driver           |  
| `page`     | `int`      | **optional**    the current page of result |  
**success response:**
```json
{
    "status": 200,
    "results": {
        "current_page": 1,
        "data": [
            {
                "id": 11,
                "user_id": 2,
                "driver": "ghasedak",
                "message": "Adipisci ut rerum minima non.",
                "receptor": "+1.337.566.6649",
                "created_at": "2023-01-31T22:00:24.000000Z",
                "updated_at": "2023-01-31T22:00:24.000000Z"
            },
            {
                "id": 12,
                "user_id": 2,
                "driver": "kavenegar",
                "message": "Sint velit voluptatum ut quo.",
                "receptor": "1-820-575-7099",
                "created_at": "2023-01-31T22:00:24.000000Z",
                "updated_at": "2023-01-31T22:00:24.000000Z"
            }
        ]
}
```
