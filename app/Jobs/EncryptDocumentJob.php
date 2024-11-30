<?php

namespace App\Jobs;

use App\Models\DocumentBody;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Crypt;

class EncryptDocumentJob implements ShouldQueue
{
    use Queueable;

    protected $body;
    protected $documentId;
    /**
     * Create a new job instance.
     */
    public function __construct($body, $documentId)
    {
        $this->body = $body;
        $this->documentId = $documentId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $encryptedBody = Crypt::encryptString($this->body);
        DocumentBody::create([
            'document_id' => $this->documentId,
            'encrypted_body' => $encryptedBody,
            'checksum' => hash('sha256', $this->body),
        ]);
    }
}
