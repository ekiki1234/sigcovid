<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $table = "tb_data";
    protected $fillable= ['id_kabupaten','positif','meninggal','sembuh','rawat','tgl_data'];

    public function data()
    {
        return $this->belongsTo(Kabupaten::class, 'id_kabupaten');
    }
}
