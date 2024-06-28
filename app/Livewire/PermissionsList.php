<?php

namespace App\Livewire;

use App\Models\Permission;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PermissionsList extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Permission::query())
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->searchable()
                    ->sortable(),
            ])
            ->actions([
                Action::make('delete')
                    ->requiresConfirmation()
                    ->label('Delete Permission')
                    ->visible(function () {
                        dump(auth()->user()->can('delete', Permission::class));
                        return auth()->user()->can('delete', Permission::class);
                    }),
            ]);
    }

    public function delete(Permission $record)
    {
        dd('delete' . ' ' . $record->id);
        //return Action::make('delete')
        //    ->requiresConfirmation()
        //    ->action(fn () => $this->permission->delete());
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.permissions-list');
    }
}
