<?php

namespace App\Livewire;

use App\Enums\PropertyStatus;
use App\Models\Property;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyAgent extends Component
{
    use WithPagination;

    public User $agent;

    public function mount($slug)
    {
        $this->agent = User::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        $properties = Property::query()
            ->where('user_id', $this->agent->id)
            ->where('status', PropertyStatus::Approved)
            ->with(['location', 'category', 'thumbnail'])
            ->latest()
            ->paginate(4);

        return view('livewire.property-agent', [
            'properties' => $properties,
        ])->layout('layouts.app', ['title' => $this->agent->name.' - '.config('app.name')]);
    }
}
