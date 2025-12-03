<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Account')
                    ->columns(2)
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('avatar')
                            ->image()
                            ->avatar()
                            ->directory('users')
                            ->visibility('public')
                            ->moveFiles()
                            ->deletable()
                            ->alignCenter()
                            ->hiddenLabel()
                            ->columnSpanFull(),
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        DateTimePicker::make('email_verified_at'),
                        Select::make('role')
                            ->options(UserRole::class)
                            ->required()
                            ->default(UserRole::Admin->value)
                            ->live(),
                    ])
                    ->columns(2),

                Section::make('Contact')
                    ->visible(fn ($get) => in_array($get('role'), [UserRole::Provider]))
                    ->schema([
                        TextInput::make('company_name')
                            ->columnSpanFull(),
                        TextInput::make('phone')
                            ->tel(),
                        TextInput::make('website')
                            ->url(),

                        Textarea::make('address')
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

                Section::make('Services')
                    ->visible(fn ($get) => in_array($get('role'), [UserRole::Provider]))
                    ->schema([
                        \Filament\Forms\Components\Repeater::make('services')
                            ->compact()
                            ->label('Services')
                            ->hiddenLabel()
                            ->schema([
                                TextInput::make('description')->required(),
                            ]),
                    ])->columns(1),

                Section::make('Security')
                    ->schema([
                        Checkbox::make('change_password')
                            ->label('Change Password')
                            ->dehydrated(false)
                            ->live()
                            ->default(fn (string $operation) => $operation === 'create')
                            ->hidden(fn (string $operation) => $operation === 'create')
                            ->columnSpanFull(),
                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->confirmed()
                            ->required(fn (string $operation, $get) => $operation === 'create' || $get('change_password'))
                            ->disabled(fn (string $operation, $get) => $operation === 'edit' && ! $get('change_password')),
                        TextInput::make('password_confirmation')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation, $get) => $operation === 'create' || $get('change_password'))
                            ->disabled(fn (string $operation, $get) => $operation === 'edit' && ! $get('change_password'))
                            ->dehydrated(false),
                    ])
                    ->columns(2),

            ]);
    }
}
