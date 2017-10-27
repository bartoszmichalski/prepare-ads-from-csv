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
        $outputDir = 'lab/output/';
        if (file_exists($filename)){
            $lines = explode(PHP_EOL, file_get_contents($filename));
            foreach ($lines as $line) {
                $books[] = explode("\t", $line);
            }
            $bookHeader = $this->getHeader($books);
            unset($books[0]);
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
                if (!file_exists($outputDir)) {
                    mkdir($outputDir);
                }
                file_put_contents($outputDir.'/'.$bookTitle.'.txt', $bookDescription);
            }
        } else {
            exit("$filename not exists");
        }
           
    }
    private function getHeader($books)
    {
            foreach ($books[0] as $header) {
                $bookHeader[] = rtrim($header); 
            }
            
            return $bookHeader;
    }
}