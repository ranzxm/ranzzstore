<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductPromoResource\Pages;
use App\Filament\Resources\ProductPromoResource\RelationManagers;
use App\Models\ProductPromo;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductPromoResource extends Resource
{
    protected static ?string $model = ProductPromo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Promo";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('discount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('kuota')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('start')
                    ->required(),
                Forms\Components\DateTimePicker::make('end')
                    ->required(),
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                TextInput::make("information")
                    ->dehydrated(false)
                    ->label("")
                    ->placeholder("You can All fields on Products section")
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('discount')
                    ->numeric()
                    ->suffix("%")
                    ->sortable(),
                Tables\Columns\TextColumn::make('kuota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start')
                    ->dateTime(format: 'M j, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end')
                    ->dateTime(format: 'M j, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.provider.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListProductPromos::route('/'),
            'create' => Pages\CreateProductPromo::route('/create'),
            'view' => Pages\ViewProductPromo::route('/{record}'),
            // 'edit' => Pages\EditProductPromo::route('/{record}/edit'),
        ];
    }
}
