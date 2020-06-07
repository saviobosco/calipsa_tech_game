## About Word Guesser (Multiplayer Game)

Word Guess is a multiplayer game built with laravel framework for calispa technical assessment.

Tech Stack

PHP 7.2 
Ngninx 

WebServer 

Mysql Database Server

Ratchet PHP Library for web socket connection.

Installation 

clone the githhub repository `git clone https://github.com/saviobosco/calipsa_tech_game.git`.

Ensure Docker and Docker compose are installed in your computer, else 
checkout this [docker installation](https://docs.docker.com/get-docker)

Open your terminal or CMD in windows OS and navigate to root folder of the repository. 
Run `docker-compose up -d`
if this is your first time running this operation, it might take some time to complete.

Run `docker-compose exec app php composer.phar install` to install the laravel php dependencies.

Open a new terminal, navigate the project repository and execute `docker-compose exec app php web_socket_server.php` 
to start the websocket server. 

Please Ensure you start the web socket server, else game might not function well.

Navigate the `http://<your-ip>:8080` and enjoy the game.
