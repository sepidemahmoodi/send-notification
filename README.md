## About project
This project is built on laravel framework and we used php8.1 and mysql latest version and rabbitmq image for dockerizing project.
we used rabbitmq for consuming messages from queue.
We have a console command in this project that name is `consume:notification` which responsible for consuming messages from queue and store them to db.
this console command call `ConsumeMessage` class that get rabbitmq connection as constructor argument based on configs that we entered in `database.php` file then consume method that start consuming messages. 
I decided to use strategy design pattern for implementing send operation and i used factory design pattern for choosing sms or email sender class based on type of message that published at queue.
for implementing sms send part we use adapter desgin pattern because i imagine sms call part as a third party that i have to make compatible this part with my project and it cuases my code be more scalable for adding another way of sending sms with different urls and implementation.
i used job `StoreNotificationInDbJob` for storing data in database and `ChooseMessageSenderJob` for sending messages, that we dispatch it in appropriate place.

## Installation

for lunching this project you should follow this rules :
   - First of all unzip the send-notification folder then in root of project run `docker compose up -d`
   - Php expoed on 8000 port mysql exposed on 3306 and and admin pannel of rabbitmq exposed on 15672 port.you should login to rabbitmq panel and create queue with notification name then publish some valid json based on defined structure in task.you should login rabbitmq dashboard then in `Queues` part you create new Queue.
   - You should make sure for connecting mysql container to any tools that you work with it lik phpmyadmin or naviat.
   - You should enter the php container with this command `docker exec -it {your php container name or id} bash`
   - Then run this command `php artisan migrate` for creating your database if you didnt create that, and create our table.

## Consume messages : 
   - Enter the php container with `docker exec -it {your php container name or id} bash` command then run `php artisan consume:notification` after that our consumer started to consume messages from queue and insert them in database in log table.

## Run tests : 
   - Enter the php container with `docker exec -it {your php container name or id} bash` command then run `./vendor/bin/phpunit tests/` for running all tests in your application
   - I wrote tests with `@covers` parameter in phpDoc for test coverage but this extension is not installed.
   - I try to write all tests for functionalities that maybe happened in Application but i want to show the way of my coding so maybe for some functionalities there isnt any tests.

## Notice
  - The success column in logs table depends on the result of sending process and based on that we realize the value of success column.
  - try to enter valid json for published messages in your queue.
  - When our program has run consumer consume the messages that exist in queue then it waiting for new messages and with publishing new messages our consumer consume that message suddenly.
