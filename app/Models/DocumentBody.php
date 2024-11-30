<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class DocumentBody extends Model
{
    protected $fillable = ['document_id', 'encrypted_body', 'checksum'];

    public function getEncryptedBodyAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // Encrypt the body before saving
    public function setEncryptedBodyAttribute($value)
    {
        $this->attributes['encrypted_body'] = Crypt::encryptString($value);
    }
}
