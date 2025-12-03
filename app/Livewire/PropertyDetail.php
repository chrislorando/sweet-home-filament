<?php

namespace App\Livewire;

use App\Models\ContactSubmission;
use App\Models\Property;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Livewire\Component;

class PropertyDetail extends Component implements HasForms
{
    use InteractsWithForms;

    public Property $property;

    public ?array $data = [];

    public function mount($slug)
    {
        $this->property = Property::where('slug', $slug)
            ->where('status', \App\Enums\PropertyStatus::Approved)
            ->with(['location', 'category', 'images', 'user', 'characteristics'])
            ->firstOrFail();

        // Pre-fill message with property title
        $this->form->fill([
            'message' => "I am interested in your property: {$this->property->title}. Please contact me.",
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('firstname')
                            ->label('First Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('lastname')
                            ->label('Last Name')
                            ->required()
                            ->maxLength(255),
                    ]),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Phone')
                    ->tel()
                    ->required()
                    ->maxLength(20),

                Grid::make([
                    'default' => 1,
                    'md' => 3,
                ])
                    ->schema([
                        TextInput::make('address')
                            ->label('Address')
                            ->maxLength(255)
                            ->columnSpan(2),

                        TextInput::make('postcode')
                            ->label('Postcode')
                            ->maxLength(20)
                            ->columnSpan(1),
                    ]),

                Textarea::make('message')
                    ->label('Message')
                    ->required()
                    ->rows(4)
                    ->maxLength(1000),
            ])
            ->statePath('data');
    }

    public function submitContact()
    {
        $data = $this->form->getState();

        ContactSubmission::create([
            'property_id' => $this->property->id,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'address' => $data['address'] ?? null,
            'postcode' => $data['postcode'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'],
            'message' => $data['message'],
        ]);

        $this->form->fill([
            'firstname' => '',
            'lastname' => '',
            'address' => '',
            'postcode' => '',
            'email' => '',
            'phone' => '',
            'message' => "I am interested in your property: {$this->property->title}. Please contact me.",
        ]);

        Notification::make()
            ->title('Message sent successfully')
            ->success()
            ->send();

        session()->flash('message', 'Your message has been sent successfully! The agent will contact you shortly.');
    }

    public function render()
    {
        return view('livewire.property-detail')
            ->layout('layouts.app', ['title' => $this->property->title.' - '.config('app.name')]);
    }
}
