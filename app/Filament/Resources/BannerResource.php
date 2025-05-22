<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              Forms\Components\Select::make('news_id')
                ->label('Judul Berita')
                ->relationship(
                    name: 'news',
                    titleAttribute: 'title',
                    modifyQueryUsing: function ($query, $livewire) {
                        // Ambil semua news_id yang sudah digunakan
                        $usedNewsIds = Banner::pluck('news_id')->toArray();

                        // Jika sedang edit, ambil news_id milik record yang sedang diedit
                        $currentRecordNewsId = $livewire->record->news_id ?? null;

                        // Keluarkan current record dari pengecualian
                        if ($currentRecordNewsId) {
                            $usedNewsIds = array_diff($usedNewsIds, [$currentRecordNewsId]);
                        }

                        // Filter news yang belum digunakan
                        return $query->whereNotIn('id', $usedNewsIds);
                    }
                )
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('news.title')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
