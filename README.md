[![Build Status](https://travis-ci.com/MehGokalp/virtual-card.svg?branch=master)](https://travis-ci.com/MehGokalp/virtual-card) [![codecov](https://codecov.io/gh/MehGokalp/virtual-card/branch/master/graph/badge.svg)](https://codecov.io/gh/MehGokalp/virtual-card)

# Welcome to VirtualCard API
This API allows you to create, remove, list inner virtual cards using dummy web service API's with microservice architecture. In version 1.0 we just have a single php project based on symfony framework. 

## Story

The main point of this project is creating a virtual card via a vendor (provider) with an REST API.
Every virtual card is relating to a bucket.
### Bucket System
We can think bucket like a bank account. We store our money into buckets.
The properties of a single bucket are;

|Column|Description|
|--|--|
|startDate|The first day that we can start to use this bucket's balance|
|endDate|The last day that we can start to use this bucket's balance|
|balance|Available balance of this bucket|
|currency|The currency of the bucket. Default is: **USD**|
|vendor|The vendor that this bucket related to|

### Vendor

Vendors are our providers. We can think them like banks. When user wants to create a virtual card we're sending a request to vendor. If the vendor accepts the creation of the virtual card then we create the virtual card.

|Column|Description|
|--|--|
bucketLimit|Vendor's buckets are creating with fixed balance. This field stores the fixed balances|
bucketDateDelta|Vendor's buckets are creating with fixed date delta. Date delta means the day count between start and end date.|


**Exceptions**

When a virtual card creation requested, and the vendor (that we sent a create request) rejects or returns exception, we try to create this virtual card with another available vendor.
Example:

|Vendor's Name|Returned status|
|--|--|
|Lion|503 (Service unavailable)|
|Bear|200 (Success)|

First we sent a request to first vendor (Lion) it returned 503 and we assume that it couldn't create the virtual card. After then we sent another request to our second vendor Bear (this is fallback) and it returns 200 then we end the flow.
If the second vendor returns reject response, we were going to send another request to our third vendor.

### Virtual Card

Virtual card is the main item of this project. We're trying to create a single virtual card using buckets and vendors.
The basic flow to create a virtual card:

![Flow](https://raw.githubusercontent.com/MehGokalp/virtual-card/master/docs/flow.png)

When an user request to create virtual card, the requested balance will substract from chosed bucket. (Read below to know how we're choosing the buckets).

**Bucket choosing**

When user requests to create virtual card, we try to find single bucket to create this virtual card. Conditions are;

- Start date **must** before then virtual card's
- Expire date **must** after then virtual card's end date
- The bucket that has biggest balance will choose



## Provider Projects

This project is using payment providers to create cards. You can inspect below providers to understand the flow better.

 - [Vendor Lion](https://github.com/MehGokalp/vendor-lion) on Java
 - [Vendor Bear](https://github.com/MehGokalp/vendor-bear) on NodeJs
 - [Vendor Rhino](https://github.com/MehGokalp/vendor-rhino) on GoLang

## Installation

Clone this project into your computer, make sure your docker daemon is running then run;

    docker-compose up

after then connect to the php container;

    docker container exec -it vc_php /bin/bash

and run the following command;

    composer install &&
    bin/console doctrine:migrations:migrate --env=dev --no-interaction &&
    bin/console doctrine:fixtures:load --env=dev --no-interaction

then the server will start on your 8080 port at localhost.

## Technical Stack

 - Symfony
 - MongoDB
 - Redis
 - Nginx

## Access to databases

You can use [adminer](https://github.com/vrana/adminer) to access MongoDB and mysql. Adminer will be available at `8180` port on your local host.

## API Documentation

You can access API's documentation at [/doc](http://localhost:8080/doc) path. We used nelmio-api-doc bundle to create documentation. It means you can test every method on project using this documentation.

## Postman Collection

Also, I added postman collection for current API. You can found them in postman folder.

## Code Documentation

I added some comments on code, but it's not enough for understanding the whole architecture. I'll add more comments, and I'll prepare a full documentation.

## Contributing

This project completely open source . You can fork and modify everything, and you can use this project everywhere you want. I'm transferring my experiences into this project to contribute for open source family, and I'm trying to impress the beginners with unique ways.
