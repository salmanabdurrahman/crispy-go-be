<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Filament\Resources\BlogPostResource\RelationManagers;
use App\Models\BlogPost;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;
    protected static ?string $navigationLabel = 'Postingan Blog';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?int $navigationSort = 2;
    protected static ?string $label = 'Postingan';
    protected static ?string $pluralLabel = 'Postingan Blog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->minLength(3)
                    ->maxLength(255)
                    ->afterStateUpdated(fn(callable $set, $state) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\Textarea::make('excerpt')
                    ->label('Ringkasan')
                    ->required()
                    ->disabled()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('content')
                    ->label('Konten')
                    ->required()
                    ->reactive()
                    ->columnSpanFull()
                    ->afterStateUpdated(fn(callable $set, $state) => $set('excerpt', Str::limit(strip_tags($state), 100))),
                Forms\Components\FileUpload::make('image')
                    ->label('Gambar')
                    ->required()
                    ->image()
                    ->disk('public')
                    ->directory('blog-posts'),
                Forms\Components\Select::make('type')
                    ->label('Tipe')
                    ->required()
                    ->options([
                        'product' => 'Product',
                        'tips' => 'Tips',
                        'news' => 'News',
                        'promotions' => 'Promotions',
                        'review' => 'Review',
                        'tutorial' => 'Tutorial',
                        'interview' => 'Interview',
                        'opinion' => 'Opinion',
                        'press-release' => 'Press Release',
                        'announcement' => 'Announcement',
                    ]),
                Forms\Components\Select::make('user_id')
                    ->label('Penulis')
                    ->label('Author')
                    ->required()
                    ->options(User::all()->pluck('name', 'id'))
                    ->default(fn() => auth()->user()->id),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Dipublikasikan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Konten')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Dipublikasikan')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Dihapus')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'view' => Pages\ViewBlogPost::route('/{record}'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Jumlah postingan blog';
    }
}
