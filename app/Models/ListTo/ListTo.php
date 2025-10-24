<?php

namespace App\Models\ListTo;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTo extends Model
{
    use HasFactory;

    protected $table = 'list';

    // Laravel-activitylog
    protected static $logAttributes = ["*"];
    protected static $ignoreChangedAttributes = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    // protected static $logName = 'Curriculum';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'color',
        'is_archived',
        'position',
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
