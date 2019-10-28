# Welcome to VirtualCard API
This API allows you to create, remove, list inner virtual cards using dummy web service API's with micro service architecture. In version 1.0 we just have a single php project based on symfony framework. 

## Installation
Clone this project into your computer, make sure your docker daemon is running then run;

    make
and it'll build and up the necessary containers for you then the server will started on your 8080 port at localhost. 
## .env
I prepared every system configuration in docker-compose.yml but if you want to change something on your own, you can edit .env file that is in base folder.
## Technical Stack

 - Symfony
 - MongoDB
 - Redis
 - Nginx
## Access to databases
You can use adminer to access MongoDB and mysql. Adminer is available at 8180 port on your local host.
## API Documentation
You can access API's documentation at [/doc](http://localhost:8080/doc) path. We used nelmio-api-doc bundle to create documentation. It means you can test every method on project using this documentation. 
## Postman Collection
Also i added postman collection for current API. You can found them in postman
folder.
## Mocky
I used mocky.io to create dummy responses. I'm not sure how much they'll serve the responses because that i added the responses with their keys to mocky folder.
## Code Documentation
I added some comments on code but it's not enough for undestanding the whole architecture. I'll add more comments and i'll prepare a full documentation.
## Contributing
This project complately open source . You can fork and edit everything and you can use this project everywhere you want. I'm transfering my experiences into this project to contribute for open source family and also i'm trying to impress the beginners with unique ways.
