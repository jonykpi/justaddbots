<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlansResource\Pages;
use App\Filament\Resources\PlansResource\RelationManagers;
use App\Models\Plan;
use App\Models\Plans;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PlansResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function canViewAny(): bool
    {
        return str_ends_with(Auth::user()->email, '@docs2ai.com');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\TextInput::make('max_number_of_bot')->numeric()->required(),
                Forms\Components\TextInput::make('max_number_of_response')->numeric()->required(),
                Forms\Components\TextInput::make('max_number_of_click')->numeric()->required(),
                Forms\Components\TextInput::make('max_number_of_mb')->numeric()->required(),
                Forms\Components\TextInput::make('price')->numeric()->prefix('$')->required(),
                Forms\Components\Toggle::make('status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('max_number_of_bot')->label('Bot'),
                Tables\Columns\TextColumn::make('max_number_of_response')->label('Response'),
                Tables\Columns\TextColumn::make('max_number_of_click')->label('Click'),
                Tables\Columns\TextColumn::make('max_number_of_mb')->label('MB'),
                Tables\Columns\TextColumn::make('price')->prefix("$"),
                Tables\Columns\ToggleColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
               // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlans::route('/create'),
            'edit' => Pages\EditPlans::route('/{record}/edit'),
        ];
    }
}
