<?php

namespace App\Command;

use App\Repository\DonationRepository;
use App\Repository\UserLocationRepository;
use Port\Csv\CsvReader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationDonationsFileCommand extends Command
{
    protected static $defaultName = 'app:migrate:donations';

    private DonationRepository $donationRepository;

    private UserLocationRepository $userLocationRepository;

    public function __construct(DonationRepository $donationRepository, UserLocationRepository $userLocationRepository)
    {
        parent::__construct();
        $this->donationRepository = $donationRepository;
        $this->userLocationRepository = $userLocationRepository;

    }

    protected function configure(): void
    {
        $this->setDescription('Migrate data from donations file');
        $this->addArgument('importFolder', InputArgument::REQUIRED, "it's the import folder");

    }

    public function initializeLoop(string $path, InputInterface $input, OutputInterface $output): CsvReader
    {
        /** @var ?string $folder */
        $folder = $input->getArgument('importFolder');
        $fullPath = $folder . DIRECTORY_SEPARATOR . $path;
        $output->writeln(sprintf("\nMigrating from %s", $fullPath));

        $file = new \SplFileObject($fullPath);
        $reader = new CsvReader($file, ',');
        $reader->setHeaderRowNumber(0);
        return $reader;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
       $this->createDataBase();

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;
    }


    public function createDataBase()
    {
        $this->donationRepository->createTable();
        $this->userLocationRepository->createTable();

    }

//    public function handleDonations(InputInterface $input, OutputInterface $output)
//    {
//        $reader = $this->initializeLoop('contact.csv', $input, $output);
//        $i = 0;
//        foreach ($reader as $row) {
//            $this->donationRepository->insertData([
//                'phoneNumber' => $row['Tel'],
//                'amount' => intval($row['Montant'])
//            ]);
//            $this->userLocationRepository->insertData([
//                'phoneNumber' => $row['Tel'],
//                'date' => $row['Date'],
//                'amount' => $row['Code Postal']
//            ]);
//            if ($i = 20){
//                die;
//            }
//            $i++;
//        }
//
//    }

}