<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupJoinRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'user_id',
        'status',
        'message',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function accept(User $respondedBy)
    {
        $this->update([
            'status' => 'accepted',
        ]);

        // Aggiungi l'utente al gruppo
        GroupMember::create([
            'group_id' => $this->group_id,
            'user_id' => $this->user_id,
            'role' => 'member',
        ]);
    }

    public function decline(User $respondedBy)
    {
        $this->update([
            'status' => 'declined',
        ]);
    }
}
