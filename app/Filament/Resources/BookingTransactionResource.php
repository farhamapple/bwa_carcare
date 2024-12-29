<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingTransactionResource\Pages;
use App\Filament\Resources\BookingTransactionResource\RelationManagers;
use App\Models\BookingTransaction;
use Faker\Core\File;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingTransactionResource extends Resource
{
    protected static ?string $model = BookingTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->helperText('Transaction name')->required()->maxLength(255),
                TextInput::make('trx_id')->helperText('Transaction ID')->required()->maxLength(255),
                TextInput::make('phone_number')->helperText('Phone Number')->required()->maxLength(255),
                TextInput::make('total_amount')->helperText('Total Amount')->required()->numeric()->prefix('IDR'),
                DatePicker::make('started_at')->helperText('Start Date')->required(),
                TimePicker::make('time_at')->helperText('Start Time')->required(),
                Select::make('is_paid')->options([true => 'Paid', false => 'Not Paid'])->required(),
                Select::make('car_service_id')->relationship('carService', 'name')->searchable()->preload()->required(),
                Select::make('car_store_id')->relationship('carStore', 'name')->searchable()->preload()->required(),
                FileUpload::make('proof')->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif'])->image()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('trx_id')->sortable()->searchable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('phone_number')->sortable()->searchable(),
                TextColumn::make('carService.name'),
                TextColumn::make('started_at'),
                TextColumn::make('time_at'),
                IconColumn::make('is_paid')->boolean()->trueColor('success')->falseColor('danger')->trueIcon('heroicon-o-check-circle')->falseIcon('heroicon-o-x-circle')->label('Sudah Bayar ?'),
                ImageColumn::make('proof'),
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
            'index' => Pages\ListBookingTransactions::route('/'),
            'create' => Pages\CreateBookingTransaction::route('/create'),
            'edit' => Pages\EditBookingTransaction::route('/{record}/edit'),
        ];
    }
}
