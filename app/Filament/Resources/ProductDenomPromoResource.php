<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductDenomPromoResource\Pages;
use App\Filament\Resources\ProductDenomPromoResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDenomPromo;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductDenomPromoResource extends Resource
{
    protected static ?string $model = ProductDenomPromo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Promo";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make("category_id")
                    ->label("Category")
                    ->dehydrated(false)
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($set) {
                        $set("provider_id", null);
                    })
                    ->preload()
                    ->options(Category::all()->pluck("name", "id")),
                Select::make("provider_id")
                    ->label("Provider")
                    ->dehydrated(false)
                    ->required()
                    ->reactive()
                    ->preload()
                    ->disabled(fn($get) => $get("category_id") == null)
                    ->options(function ($get) {
                        $data = null;
                        if ($get("category_id")) {
                            $data = Category::query()->find($get("category_id"))->providers()->get()->pluck("name", "id");
                        } else {
                            $data = null;
                        }
                        return $data;
                    }),
                Select::make("product_id")
                    ->label("Product")
                    ->dehydrated(false)
                    ->required()
                    ->reactive()
                    ->preload()
                    ->disabled(fn($get) => $get("provider_id") == null)
                    ->options(function ($get) {
                        $data = null;
                        if ($get("provider_id")) {
                            $data = Provider::query()->find($get("provider_id"))->products()->get()->pluck("name", "id");
                        } else {
                            $data = null;
                        }
                        return $data;
                    }),
                Forms\Components\Select::make('product_denom_id')
                    ->relationship('product_denom', 'name')
                    ->required()
                    ->preload()
                    ->disabled(fn($get) => $get("product_id") == null)
                    ->options(function ($get) {
                        $data = null;
                        if ($get("product_id")) {
                            $data = Product::query()->find($get("product_id"))->product_denoms()->get()->pluck("name", "id");
                        } else {
                            $data = null;
                        }
                        return $data;
                    }),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('discount')
                    ->required()
                    ->suffix("%")
                    ->numeric(),
                Forms\Components\TextInput::make('kuota')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('start')
                    ->required(),
                Forms\Components\DatePicker::make('end')
                    ->required(),
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
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end')
                    ->dateTime()
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
                Tables\Columns\TextColumn::make('product_denom.name')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListProductDenomPromos::route('/'),
            'create' => Pages\CreateProductDenomPromo::route('/create'),
            'edit' => Pages\EditProductDenomPromo::route('/{record}/edit'),
        ];
    }
}
