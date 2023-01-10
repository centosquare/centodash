<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;


class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('roles', function (User $user) {
                return $user->roles->map(function ($role) {
                    return $role->name;
                })->implode(',');
            })
            ->addColumn('avatar', function (User $user) {
                return '<img src="' . asset($user["avatar"]). '" class="image-input-wrapper rounded-circle w-50px h-50px" alt="alt text">';
            })
            ->addColumn('edit', function (User $user) {
                return Auth::user()->can('user.edit') 
                ? '<a href="'.route('user.edit',$user['id']).'" class="btn btn-icon btn-success btn-sm"><i class="bi bi-pencil fs-4"></i></a>' 
                : '';
            })
            ->addColumn('delete', function (User $user) {
                return Auth::user()->can('user.delete') 
                ? '<a href="'.route('user.delete',$user['id']).'" class="btn btn-icon btn-danger btn-sm"><i class="bi bi-trash fs-4"></i></a>' 
                : '';
            })
            ->rawColumns(['avatar','edit','delete'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
    {
        return $model->with('roles')->newQuery()->select('id', 'name', 'email','avatar');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('user-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        $columns = [
            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('avatar'),
            Column::make('roles'),
        ];

        if(Auth::user()->can('user.edit'))
        {
            $columns = array_merge($columns,[Column::make('edit')]);
        }

        if(Auth::user()->can('user.delete'))
        {
            $columns = array_merge($columns,[Column::make('delete')]);
        }

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
