<?php

namespace App\Jobs;

use App\Repository\FollowerRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessFollower implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user_id;
    private $source_id;
    private $source_type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $user_id, string $source_id, int $source_type)
    {
        $this->user_id     = $user_id;
        $this->source_id   = $source_id;
        $this->source_type = $source_type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FollowerRepository $follower)
    {
        $follower->create($this->user_id, $this->source_id, $this->source_type);
    }
}
