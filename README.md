# Simulate an Order

This project aims to simulate an order of articles where, based on a defined rule, system can apply a discount for user and submit order for 3 different servers with specific parameters.

## Instalation

To install this project, clone the repository to your local machine

    $ git clone https://github.com/gabriel89oliveira/order-testing.git

<br>
Run composer

    $ composer install

<br>
Install dependecies

    $ npm install
    $ npm run dev

<br>

## Setup Environment
Rename .env.example file to .env and update the following parameters

### **Database parameters**<br>
    DB_HOST=<br>
    DB_PORT=<br>
    DB_DATABASE=<br>
    DB_USERNAME=<br>
    DB_PASSWORD=<br>

### **Localhost parameters**<br>
This is your localhost address, for exampe *localhost:8000*<br>

    SANCTUM_STATEFUL_DOMAINS=

<br>

## Run Migrations
Run migration do start your database

    $ php artisan run migration

<br>

## Create articles
To create an article, you need to access article page (e.g. localhost:8000/article) and you will be able create, edit or delete articles at a glance.<br>
After creating the articles, you will be able to simulate an order in the order page.

## Simulate an order
To simulate an order, you need to access order page (e.g. localhost:8000/order) and choose on the left column all articles that needs to be included in the order.<br>
As you add the articles, subtotal, discount and total amount to be paid is calculated automatically, so you can keep an eye on a resume of the order.<br>
After you finish adding the articles, you just submit the order, and system will process the request and send the order to 3 different servers.

<br>

## Unit Test
In order to test the app, you can run the command:

    $ php artisan test

The app will run several unit tests for user, and also 2 additional tests, one for article and another one for order.
<br><br>

To test an article creation, you can access the file:

    tests / Unit / ArticleTest

In this file, you can test several input parameters to check verification rules and so on.
<br><br>

To test an order creation, you can access the file:

    tests / Unit / OrderTest

In this file, you can test orders with several amount of articles.