<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Actions\CreateAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Datos Básicos')
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->minLength(3)
                            ->maxLength(50)
                            ->required(),
                        TextInput::make('email')
                            ->label(__('Email address'))
                            ->email()
                            ->maxLength(100)
                            ->required(),
                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->tel()
                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                            ->required(),
                        TextInput::make('password')
                            ->label(__('Password'))
                            ->password()
                            ->minLength(8)
                            ->maxLength(100)
                            ->required()
                            ->hiddenOn(['edit']),
                    ])
                    ->columnSpanFull(),

                Fieldset::make('Permisos')
                    ->schema([
                        Toggle::make('is_active')
                            ->required(),
                    ])
                ->columnSpanFull(),
            ]);
    }
}
