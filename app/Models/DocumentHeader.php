<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentHeader extends Model
{
    protected $fillable = ['user_id','module','version','encryption_key','metadata'];


    public function versions()
    {
        return $this->hasMany(DocumentVersion::class,'document_id','id');
    }
}
