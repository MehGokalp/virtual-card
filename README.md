[![Build Status](https://travis-ci.org/MehGokalp/virtual-card.svg?branch=master)](https://travis-ci.org/MehGokalp/virtual-card) [![codecov](https://codecov.io/gh/MehGokalp/virtual-card/branch/master/graph/badge.svg)](https://codecov.io/gh/MehGokalp/virtual-card)

# Welcome to VirtualCard API
This API allows you to create, remove, list inner virtual cards using dummy web service API's with micro service architecture. In version 1.0 we just have a single php project based on symfony framework. 

## Story
You can access the whole story of this project [here.](https://github.com/MehGokalp/virtual-card/blob/master/docs/story.md)

## Provider Projects
This project is using payment providers to create cards. You can inspect below providers to understand the flow better.

 - [Vendor Lion](https://github.com/MehGokalp/vendor-lion) on Java
 - [Vendor Bear](https://github.com/MehGokalp/vendor-bear) on NodeJs
 - [Vendor Rhino](https://github.com/MehGokalp/vendor-rhino) on GoLang

## Installation
Clone this project into your computer, make sure your docker daemon is running then run;

    make
and it'll build and up the necessary containers for you then the server will started on your 8080 port at localhost.

## .env
The docker's environment parameters must be in ``docker`` folder. The .env file in base directory is contains application's configurations. 

## Technical Stack

 - Symfony
 - MongoDB
 - Redis
 - Nginx

## Access to databases
You can use [adminer](https://github.com/vrana/adminer) to access MongoDB and mysql. Adminer will be available at 8180 port on your local host.

## API Documentation
You can access API's documentation at [/doc](http://localhost:8080/doc) path. We used nelmio-api-doc bundle to create documentation. It means you can test every method on project using this documentation.

## Postman Collection
Also, I added postman collection for current API. You can found them in postman folder.

## Mocky
I used mocky.io to create dummy responses. I'm not sure how much they'll serve the responses because that i added the responses with their keys to mocky folder.

## Code Documentation
I added some comments on code, but it's not enough for understanding the whole architecture. I'll add more comments, and I'll prepare a full documentation.

## Contributing
This project completely open source . You can fork and modify everything, and you can use this project everywhere you want. I'm transferring my experiences into this project to contribute for open source family, and I'm trying to impress the beginners with unique ways.
