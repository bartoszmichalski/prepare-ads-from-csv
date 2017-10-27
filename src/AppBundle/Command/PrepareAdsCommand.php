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
        ->setHelp('This command allows you prepare txt files with your ads from csv file (acctualy TAB separated txt file)')
        ->addArgument('filename', InputArgument::REQUIRED, 'Input CSV filename.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');
        if (file_exists($filename)){
            $csvData = file_get_contents($filename);
            $lines = explode(PHP_EOL, $csvData);
            foreach ($lines as $line) {
                $books[] = explode("\t", $line);
            }
            foreach ($books[0] as $key => $header) {
                $bookHeader[] = rtrim($header); 
            }
            unset($books[0]);
            $bookDescription = '';
            foreach ($books as $book) {
                $bookDescription = '';
                foreach ($book as $key => $bookDetail) {
                    if ($key != 0){
                     $bookDescription .=  $bookHeader[$key] .": ". rtrim($bookDetail)."\n\n";                        
                    }
                    if ($key == 1) {
                       $bookTitle = str_replace(',','-',rtrim($bookDetail));
                    } 
                }
                echo 'OutputFilename: '.$bookTitle."\n";
                echo $bookDescription;
                echo "---\n";                
            }
        } else {
            exit("$filename not exists");
        }
           
    }
}