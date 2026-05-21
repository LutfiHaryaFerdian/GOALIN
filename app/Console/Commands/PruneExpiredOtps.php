<?php

namespace App\Console\Commands;

use App\Models\OtpCode;
use Illuminate\Console\Command;

class PruneExpiredOtps extends Command
{
    protected $signature   = 'otp:prune';
    protected $description = 'Hapus kode OTP yang sudah kadaluarsa dari database';

    public function handle(): int
    {
        $deleted = OtpCode::where('expires_at', '<', now())->delete();

        $this->info("Expired OTPs pruned: {$deleted} record(s) deleted.");

        return Command::SUCCESS;
    }
}
