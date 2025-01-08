<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProviderResource\Pages;
use App\Filament\Resources\ProviderResource\RelationManagers;
use App\Models\Category;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProviderResource extends Resource
{
    protected static ?string $model = Provider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Product";

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make("category_provider.category_id")
                    ->multiple()
                    ->relationship("categories", "name")
                    ->preload()
                    ->required(),
                Forms\Components\FileUpload::make('icon')
                    ->required()
                    ->maxSize(5124)
                    ->imageEditorAspectRatios(["1:1"]),
                Forms\Components\FileUpload::make('banner')
                    ->required()
                    ->maxSize(5124)
                    ->imageEditorAspectRatios(["1:1"]),
                Forms\Components\Repeater::make("provider_contacts")
                    ->relationship()
                    ->schema([
                        Select::make("contact_type")
                            ->options([
                                "email" => "Email",
                                "phone_number" => "Phone Number",
                                "address" => "Address"
                            ])->required()
                            ->afterStateUpdated(function ($get, $set) {
                                $set("contact", "");
                            })
                            ->reactive(),
                        TextInput::make("contact")
                            ->type(fn($get) => $get("contact_type") == "email" ? "email" : "text")
                            ->disabled(fn($get) => $get("contact_type") == null)
                            ->required(),
                    ]),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('icon'),
                Tables\Columns\ImageColumn::make('banner'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make("categories.*.name")
                    ->label("Categories"),
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
            'index' => Pages\ListProviders::route('/'),
            'create' => Pages\CreateProvider::route('/create'),
            'edit' => Pages\EditProvider::route('/{record}/edit'),
        ];
    }
}
