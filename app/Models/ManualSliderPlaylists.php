<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualSliderPlaylists extends Model
{
    protected $table = 'tbl_manual_slider_playlists';
    protected $guarded = [];
    // public function playlist()
    // {
    //     return $this->belongsTo(Playlist::class, 'playlist_id', 'id'); // Adjust 'Playlist::class' if your model name is different
    // }
}
