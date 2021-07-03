<?php

namespace App\Command;

use App\Entity\Country;
use App\Repository\CountryRepository;
use App\Service\CountryService;
use App\Service\StringConverter;
use App\Validator\CountryValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddNewCountryCommand extends Command
{
    protected static $defaultName = 'add.new.country';
    protected static $defaultDescription = 'Add new country';
    private CountryService $countryService;
    private CountryValidator $countryValidator;
    private StringConverter $stringConverter;

    public function __construct(CountryService $countryService, CountryValidator $countryValidator, StringConverter $stringConverter)
    {
        parent::__construct();

        $this->countryService = $countryService;
        $this->countryValidator = $countryValidator;
        $this->stringConverter = $stringConverter;
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('name', InputArgument::REQUIRED, 'Please add country name, argument is required.')
            ->addArgument('canonicalName', InputArgument::REQUIRED, 'Please add country canonical name, argument is required.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $canonicalName = $this->stringConverter->convertString($input->getArgument('canonicalName'));
        $this->countryService->checkCountry($name, $canonicalName);

        return Command::SUCCESS;
    }
}
