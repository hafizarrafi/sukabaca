<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Doctrine\DBAL\Schema\Column;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('author_id')
                    ->relationship('author', 'name')
                    ->required(),

                 Forms\Components\Select::make('news_category_id')
                    ->relationship('newsCategory', 'title')
                    ->required(),

                Forms\Components\TextInput::make('title')
                    ->minLength(25)
                    ->maxLength(150)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required(),

                Forms\Components\TextInput::make('slug')
                    ->readOnly(),

                Forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->required()
                    ->columnSpanFull(),
                   
                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                    Forms\Components\Toggle::make('is_featured')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author.name'),
                Tables\Columns\TextColumn::make('newsCategory.title'),
                Tables\Columns\TextColumn::make('title')
                ->extraAttributes([
                'style' => 'display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; white-space: normal;'     ])
                ->limit(90), 
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\ToggleColumn::make('is_featured')



            ])
            ->filters([
                Tables\Filters\SelectFilter::make('author_id')
                ->relationship('author', 'name')
                ->label('select author'),
                Tables\Filters\SelectFilter::make('news_category_id')
                ->relationship('newsCategory', 'title')
                ->label('select category')

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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
