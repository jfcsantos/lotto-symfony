<?php

// src/AppBundle/Command/GenerateWinnerCommand.php
namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class GenerateWinnerCommand extends ContainerAwareCommand {
  protected function configure() {
    $this
      // the name of the command (the part after "bin/console")
      ->setName('app:generate-winner')
      // the short description shown while running "php bin/console list"
      ->setDescription('Generates a random lottery winner.')
      // the full command description shown when running the command with
      // the "--help" option
      ->setHelp("This command allows you to create users...")
      // configure an argument
      ->addArgument('lottery_id', InputArgument::REQUIRED, 'The lottery id.');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {

    $winnerController = $this->getContainer()->get('lottery.winner_controller');
    $endedLotteries = $winnerController->generateWinnersAction();

//    foreach ($endedLotteries as $key => $lottery) {
//      $output->writeln(sprintf("About to generate a winner for %s.",$lottery->getName()));
//    }

  }
}