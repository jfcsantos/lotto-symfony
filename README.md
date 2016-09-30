########## Lottery App ##########

A Symfony2 app for online lotteries and contests. Users can register to participate
and an admin will be able to close and generate a random winner from the participant list.

TODO // Add cron job to call generate winner function when end date is past


##########  Instructions  ##########

A user must login in order to participate in a lottery draw.

When logged in as an admin user we can go to a lottery profile page and generate a winner.

Accessing the following url - lottery/winners/generate as an admin will generate winners for all eligible lotteries, i.e. all ongoing lotteries with participants and whose end date is previous to the current date.

Admin user: 
  admin:admin

##########  Done by  ##########

João Santos
