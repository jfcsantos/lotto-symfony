########## Lottery App ##########

A Symfony2 app for online lotteries and contests. Users can register to participate
and an admin will be able to close and generate a random winner from the participant list.

##########  Setting up locally  ##########

Step 1 - First we need a local mysql service running and the database created. Included in the
 mysql-docker folder is a docker-compose file which will spin up a Mysql container
 with the proper DB setup. If you already have a DB server running locally skip to step 2,
 you can enter the DB details then.
- cd mysql-docker
- docker-compose up -d

Step 2 - Install required packages via composer. Make sure the mysql service is up,
then cd back to the root folder.
- cd ../  
- composer install

Step 3 - Finish setting up the local environment, create the DB tables and setup static files
- php bin/console doctrine:schema:update --force
- php bin/console assetic:dump

Step 4 - Run the PHP server and open the site
- php bin/console server:run

Extra steps - Run these in order to have a test and admin user
- php bin/console fos:user:create admin
- php bin/console fos:user:promote admin ROLE_ADMIN
- php bin/console fos:user:create test_user

Finally, go to http://127.0.0.1:8000/lottery/new to create a new lottery.

##########  Instructions  ##########

Setting with Heroku. Make sure you have an Heroku account and the heroku toolbelt set up.

heroku login
heroku create
heroku config:set SYMFONY_ENV=prod
heroku addons:add cleardb:ignite
git push heroku master
heroku run php bin/console doctrine:schema:update --force
heroku open


##########  Instructions  ##########

A user must login in order to participate in a lottery draw.

When logged in as an admin user we can go to a lottery profile page and generate a winner.

Accessing the following url - lottery/winners/generate as an admin will generate winners for all eligible lotteries, i.e. all ongoing lotteries with participants and whose end date is previous to the current date.


##########  Done by  ##########

João Santos
