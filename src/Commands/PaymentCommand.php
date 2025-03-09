<?php

namespace Mrfansi\Payment\Commands;

use Illuminate\Console\Command;

class PaymentCommand extends Command
{
    public $signature = 'payment';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
