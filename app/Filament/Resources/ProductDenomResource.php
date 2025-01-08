<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductDenomResource\Pages;
use App\Filament\Resources\ProductDenomResource\RelationManagers;
use App\Models\Product;
use App\Models\ProductDenom;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductDenomResource extends Resource
{
    protected static ?string $model = ProductDenom::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Product";

    protected static ?string $navigationLabel = "Denoms";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->options(function () {
                        return Provider::with("products")
                            ->get()
                            ->mapWithKeys(function ($provider) {
                                return [
                                    $provider->name => $provider->products->mapWithKeys(function ($product) {
                                        $categoryName = $product->category->name == "Game Online" ? "" : "[{$product->category->name}]";
                                        return [
                                            $product->id => "{$categoryName} {$product->name}",
                                        ];
                                    })->toArray(),
                                ];
                            });
                    })
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR'),
                Forms\Components\FileUpload::make('icon')
                    ->required(),
                Forms\Components\Toggle::make('is_available')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('icon'),
                Tables\Columns\TextColumn::make('price')
                    ->money("IDR")
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_available')
                    ->boolean(),
                Tables\Columns\TextColumn::make('product.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.provider.name')
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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProductDenoms::route('/'),
            'create' => Pages\CreateProductDenom::route('/create'),
            'edit' => Pages\EditProductDenom::route('/{record}/edit'),
        ];
    }
}
