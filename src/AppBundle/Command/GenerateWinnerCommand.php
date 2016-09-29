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
    $results = $winnerController->generateWinnersAction();
    $closedLotteries = $results[0];
    $messages = $results[1];

    if(count($closedLotteries) > 0) {
      foreach ($closedLotteries as $closedLottery) {
        $output->writeln(sprintf("Generated winner for lottery: %s is participant: %s.", $closedLottery['lottery']->getName(), $closedLottery['winner']));
      }
    }
    elseif(count($messages) > 0) {
      foreach ($messages as $key => $message) {
        $output->writeln($message);
      }
    }
    else {
      $output->writeln("There were no Lotteries to close");
    }


  }
}