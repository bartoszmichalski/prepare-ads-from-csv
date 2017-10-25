<?php

/**
 * Description of PrepareAdsCommand
 *
 * @author bartosz
 */

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class PrepareAdsCommand extends Command
{
    protected function configure()
    {
        $this
        ->setName('prepareAds')
        ->setDescription('Genarate txt files with your ads')
        ->setHelp('This command allows you prepare txt files with your ads from csv file')
        ->addArgument('filename', InputArgument::REQUIRED, 'Input CSV filename.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');
        if (file_exists($filename)){
            $csvData = file_get_contents($filename);
            $lines = explode(PHP_EOL, $csvData);
            $array = array();
            foreach ($lines as $line) {
                $array[] = explode("\t", $line);
            }
            print_r($array);
        } else {
            exit("$filename not exists");
        }
            
    }
}