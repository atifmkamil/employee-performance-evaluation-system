<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;


class UserResource extends Resource
{
    protected static ?string $model = User::class;


    protected static ?string $navigationIcon = 'heroicon-o-user';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at')->hidden(),
                Forms\Components\TextInput::make('password')
                    ->visibleOn('create')
                    ->password()
                    ->required()
                    ->maxLength(255),

                Select::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->reactive()
                    ->required()
                    ->label('Role'),
                // Select::make('role')
                //     ->relationship('positions', 'name')
                //     ->preload()
                //     ->reactive()
                //     ->required()
                //     ->label('Role'),
                // Select::make('position_id')
                //     ->relationship('position', 'name') // tetap gunakan relationship untuk preload
                //     ->reactive()
                //     ->required(function (callable $get) {
                //         // Ambil ID 'Pegawai' di dalam closure ini
                //         $pegawaiRoleId = Role::where('name', 'Pegawai')->value('id');
                //         return $get('role') == $pegawaiRoleId;
                //     })
                //     ->preload()
                //     ->label('Jabatan')
                //     ->visible(function (callable $get) {
                //         // Ambil ID 'Pegawai' di dalam closure ini
                //         $pegawaiRoleId = Role::where('name', 'Pegawai')->value('id');
                //         return $get('role') == $pegawaiRoleId;
                //     }),
                // dd(Role::where('name', 'Pegawai')->value('id')),
                Select::make('position_id')
                    ->relationship('position', 'name')
                    ->required(function (callable $get) {
                        $pegawaiRoleId = Role::where('name', 'Pegawai')->value('id');
                        $roles = $get('roles') ?? [];
                        // dd($get('roles'), Role::where('name', 'Pegawai')->value('id'), in_array(2, [1, 2]));
                        return in_array($pegawaiRoleId, $roles);
                    })
                    ->preload()
                    ->label('Jabatan')
                    ->visible(function (callable $get) {
                        $pegawaiRoleId = Role::where('name', 'Pegawai')->value('id');
                        $roles = $get('roles') ?? [];
                        return in_array($pegawaiRoleId, $roles);
                    }),
                // Select::make('position_id')
                //     ->relationship('positions', 'name')
                //     ->preload()
                //     ->reactive()
                //     ->dependsOn('roles') // supaya berubah saat roles berubah
                //     ->required(function (callable $get) {
                //         $pegawaiRoleId = Role::where('name', 'Pegawai')->first()?->id;
                //         $roles = $get('roles') ?? [];
                //         return in_array($pegawaiRoleId, $roles);
                //     })
                //     ->visible(function (callable $get) {
                //         $pegawaiRoleId = Role::where('name', 'Pegawai')->first()?->id;
                //         $roles = $get('roles') ?? [];
                //         return in_array($pegawaiRoleId, $roles);
                //     })
                //     ->label('Jabatan'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('email_verified_at')
                //     ->dateTime()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('position.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $pegawaiRole = Role::where('name', 'Pegawai')->first();

        return parent::getEloquentQuery()
            ->whereHas('roles', function ($query) use ($pegawaiRole) {
                $query->where('id', $pegawaiRole->id);
            });
    }
}
