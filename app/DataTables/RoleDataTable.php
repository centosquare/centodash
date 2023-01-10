<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
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
            ->addColumn('guard name', function (Role $role) {
                return ''.$role['guard_name'].'';
            })
            ->addColumn('permissions', function (Role $role) {
                return count($role->permissions);
            })
            ->addColumn('edit', function (Role $role) {
                return Auth::user()->can('role.edit') 
                ? '<a href="'.route('role.edit',$role['id']).'" class="btn btn-icon btn-success btn-sm"><i class="bi bi-pencil fs-4"></i></a>' 
                : '';
            })
            ->addColumn('delete', function (Role $role) {
                return Auth::user()->can('role.delete') 
                ? '<a href="'.route('role.delete',$role['id']).'" class="btn btn-icon btn-danger btn-sm"><i class="bi bi-trash fs-4"></i></a>' 
                : '';
            })
            ->rawColumns(['edit', 'delete'])
            ->setRowId('id');
    }

    
    

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model): QueryBuilder
    {
        return $model->with('permissions')->newQuery()->select('id', 'name', 'guard_name');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('role-table')
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
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('guard name'),
            Column::make('permissions'),
            Column::make('edit'),
            Column::make('delete'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Role_' . date('YmdHis');
    }
}
