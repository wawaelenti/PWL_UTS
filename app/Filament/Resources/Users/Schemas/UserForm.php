<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Level;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema, $record = null): Schema
    {
        return $schema
            ->components([
                Select::make('level_id')
                    ->label('Level')
                    ->options(Level::all()->pluck('level_nama', 'level_id'))
                    ->required(),
                TextInput::make('username')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),
                TextInput::make('nama')
                    ->required()
                    ->maxLength(100),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->label(
                        fn(string $context) => $context === 'edit'
                            ? 'Password Baru (Kosongkan jika tidak ingin diubah)'
                            : 'Password'
                    )
                    ->required(fn(string $context) => $context === 'create')
                    ->password()
                    ->revealable()
                    ->nullable()
                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn($state) => filled($state)),
            ]);
    }
}
