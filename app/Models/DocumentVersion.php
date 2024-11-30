<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentVersion extends Model
{
    protected $fillable = ['version_number', 'changes_summary'];


    public function document()
    {
        return $this->belongsTo(DocumentHeader::class,'document_id');
    }


}
