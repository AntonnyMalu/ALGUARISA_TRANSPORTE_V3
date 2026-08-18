<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('is_mobile')
                    ->label(__('Name'))
                    ->default(fn (User $record): string => $record->name)
                    ->description(fn (User $record): string => $record->email)
                    ->formatStateUsing(fn (string $state): string => Str::ucwords($state))
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->iconColor('success')
                    ->limit(20)
                    ->hiddenFrom('md'),
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->formatStateUsing(fn (string $state): string => Str::ucwords($state))
                    ->limit(20)
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('email')
                    ->label(__('Email address'))
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->default('-')
                    ->alignCenter()
                    ->visibleFrom('md')
                    ->searchable(),
                IconColumn::make('email_verified_at')
                    ->label('Verificado')
                    ->boolean()
                    ->alignCenter()
                    ->visibleFrom('md'),
                ToggleColumn::make('is_active')
                    ->alignCenter(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    self::actionValidarEmail(),
                    self::actionResertPassword(),
                    EditAction::make(),
                    DeleteAction::make(),
                    RestoreAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
                Action::make('actualizar')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->iconButton(),
            ]);
    }

    protected static function actionValidarEmail()
    {
        return Action::make('is_verified')
            ->label('Verificar Email')
            ->color('info')
            ->icon(Heroicon::OutlinedCheckCircle)
            ->requiresConfirmation()
            ->visible(fn (User $record): bool => is_null($record->email_verified_at))
            ->action(function (User $record): void {
                $record->update([
                    'email_verified_at' => now(),
                ]);
                Notification::make()
                    ->title('prueba')
                    ->success()
                    ->send();
            });
    }

    protected static function actionResertPassword()
    {
        return Action::make('reset_password')
            ->label(__('Reset Password'))
            ->color('info')
            ->icon(Heroicon::OutlinedKey)
            ->schema([
                TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->revealable()
                    ->minLength(8)
                    ->required(),
            ])
            ->modalWidth(width: Width::Small)
            ->hidden(fn (User $record): bool => $record->is_root)
            ->action(function (array $data, User $record): void {
                $record->update([
                    'password' => Hash::make($data['password']),
                ]);
                Notification::make()
                    ->title('Contraseña cambiada')
                    ->success()
                    ->send();
            });
    }
}
