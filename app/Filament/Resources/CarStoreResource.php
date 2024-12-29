<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarStoreResource\Pages;
use App\Filament\Resources\CarStoreResource\RelationManagers;
use App\Filament\Resources\CarStoreResource\RelationManagers\PhotosRelationManager;
use App\Filament\Resources\CarStoreResource\RelationManagers\StorePhotosRelationManager;
use App\Models\CarService;
use App\Models\CarStore;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarStoreResource extends Resource
{
    protected static ?string $model = CarStore::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name')->helperText('Store name')->required()->maxLength(255),
                TextInput::make('phone_number')->helperText('Store phone number')->required()->maxLength(255),
                TextInput::make('cs_name')->helperText('Customer Service name')->required()->maxLength(255),
                Select::make('is_open')->options([true => 'Open', false => 'Closed'])->required(),
                Select::make('is_full')->options([true => 'Full Booked', false => 'Available'])->required(),
                Select::make('city_id')->relationship('city', 'name')->searchable()->preload()->required(),
                Repeater::make('store_services')->relationship('storeServices')->schema([
                    Select::make('car_service_id')->relationship('carService', 'name')->searchable()->preload()->required(),
                ]),
                FileUpload::make('thumbnail')->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif'])->image()->required(),
                Textarea::make('address')->helperText('Address')->required()->rows(10)->cols(20)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name')->sortable()->searchable(),
                IconColumn::make('is_open')->boolean()->trueColor('success')->falseColor('danger')->trueIcon('heroicon-o-check-circle')->falseIcon('heroicon-o-x-circle')->label('Buka ?'),
                IconColumn::make('is_full')->boolean()->trueColor('danger')->falseColor('success')->trueIcon('heroicon-o-x-check-circle')->falseIcon('heroicon-o-check-circle')->label('Tersedia ?'),
                ImageColumn::make('thumbnail')->circular()->label('Thumbnail'),
            ])
            ->filters([
                //
                SelectFilter::make('city_id')->relationship('city', 'name')->label('City'),
                SelectFilter::make('car_service_id')->label('Service')->options(CarService::all()->pluck('name', 'id'))->query(function (Builder $query, array $data) {
                    if ($data['value']) {
                        $query->whereHas('storeServices', function (Builder $query) use ($data) {
                            $query->where('car_service_id', $data['value']);
                        });
                    }
                }),
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
            StorePhotosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarStores::route('/'),
            'create' => Pages\CreateCarStore::route('/create'),
            'edit' => Pages\EditCarStore::route('/{record}/edit'),
        ];
    }
}
