<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = "Product";


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('provider_id')
                    ->relationship('provider', 'name')
                    ->disabled(fn($get) => $get("category_id") == null)
                    ->options(function ($get) {
                        $data = null;
                        if ($get("category_id")) {
                            $data = Category::query()->find($get("category_id"))->providers()->get()->pluck("name", "id");
                        } else {
                            $data = null;
                        }
                        return $data;
                    })
                    ->required()
                    ->helperText(function ($get) {
                        if (!$get("category_id")) {
                            return "Select category first to show providers";
                        }
                    }),
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_available')
                    ->required(),
                // Forms\Components\Repeater::make("product_denoms")
                //     ->relationship()
                //     ->label("Product Denoms")
                //     ->columnSpanFull()
                //     ->schema([
                //         Forms\Components\TextInput::make('name')
                //             ->required()
                //             ->maxLength(255),
                //         Forms\Components\FileUpload::make('icon')
                //             ->required(),
                //         Forms\Components\TextInput::make('price')
                //             ->required()
                //             ->numeric()
                //             ->prefix('IDR'),
                //         Forms\Components\Toggle::make('is_available')
                //             ->required()
                //             ->columnSpanFull()
                //     ])
                //     ->columns(2)
                //     ->defaultItems(1),
                Repeater::make("input_fields")
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('field_type')
                            ->required()
                            ->options([
                                "text" => "Text",
                                "option" => "Option"
                            ]),
                        Forms\Components\TextInput::make('label_helper')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_required')
                            ->columnSpanFull()
                            ->required(),
                    ])
                    ->required()
                    ->columnSpanFull()
                    ->collapsible()
                    ->columns(2),
                Repeater::make("product_promo")
                    ->relationship()
                    ->label("Promo")
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('discount')
                            ->required()
                            ->suffix("%")
                            ->numeric(),
                        Forms\Components\TextInput::make('kuota')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Forms\Components\DatePicker::make('start')
                            ->required(),
                        Forms\Components\DatePicker::make('end')
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_available')
                    ->boolean(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('provider.name')
                    ->numeric()
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
