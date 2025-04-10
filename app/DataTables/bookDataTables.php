<?php

namespace App\DataTables;

use App\Models\Book;
use Yajra\DataTables\Services\DataTable;

class BooksDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('created_at', fn($book) => $book->created_at->format('d-m-Y h:iA'))
            ->rawColumns(['actions']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @param  \App\Models\Book $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Book $model)
    {
        return $model->newQuery();
    }

    /**
     * Get the DataTable columns definition.
     *
     * @return array
     */
    public function getColumns()
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('#')
                ->orderable(false)
                ->searchable(false),
            Column::make('title'),
            Column::make('author'),
            Column::make('status'),
            Column::make('created_at')->searchable(false),
            Column::make('actions')->searchable(false)->orderable(false),
        ];
    }

    /**
     * Get the filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Books_' . date('YmdHis');
    }
}
