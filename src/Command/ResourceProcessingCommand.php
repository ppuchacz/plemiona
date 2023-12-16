<?php

namespace App\Command;

use App\Service\ResourceProcessor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResourceProcessingCommand extends Command
{
    private ResourceProcessor $resourceProcessor;

    public function __construct(ResourceProcessor $resourceProcessor)
    {
        $this->resourceProcessor = $resourceProcessor;

        parent::__construct("process:resources");
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        while (true) {
            $this->resourceProcessor->process();
            usleep(100);
        }
    }
}
