##About project
This project is built on laravel framework and we used php8.1 and mysql latest version and rabbitmq image for dockerizing project.
we used rabbitmq for consuming messages from queue.
We have a console command in this project that name is `consume:notification` which responsible for consuming messages from queue and store them to db.
this console command call `ConsumeMessage` class that get rabbitmq connection as constructor argument based on configs that we entered in `database.php` file then consume method that start consuming messages. 
I decided to use strategy design pattern for implementing send operation and i used factory design pattern for choosing sms or email sender class based on type of message that published at queue.
for implementing sms send part we use adapter desgin pattern because i imagine sms call part as a third party that i have to make compatible this part with my project and it cuases my code be more scalable for adding another way of sending sms with different urls and implementation.
i used job for storing data in database that after sending message via sms or email we dispatch it.
in handle method of this job i used strategy pattern again for choosing right class for storing data.

## Installation

for lunching this project you should follow this rules :
   - first of all unzip the send-notification folder then in root of project run `docker compose up -d`
   -
