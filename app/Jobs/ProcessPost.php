<?php

namespace App\Jobs;

use App\Repository\PostRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $source_id;
    private $source_type;
    private $text;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $source_id, int $source_type, string $text)
    {
        $this->source_id   = $source_id;
        $this->source_type = $source_type;
        $this->text        = $text;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PostRepository $postRepository)
    {
        $postRepository->create($this->source_id, $this->source_type, $this->text);
    }
}
