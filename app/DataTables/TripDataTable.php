<?php

namespace App\DataTables;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TripDataTable extends DataTable
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
            ->addColumn('action', 'trip.action')
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Trip $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Trip $model): QueryBuilder
    {
        $query = Trip::join('cities', 'trips.city_id', '=', 'cities.id')
                ->select('trips.id', 'trips.name', 'cities.name as city_name', 'trips.days', 'trips.price');
        
        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('trip-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->addColumn([
                        'name' => 'action',
                        'data' => 'id',
                        'title' => 'Action',
                        'searchable' => false,
                        'orderable' => false,
                        'render' => "function() {return `<a href='/admin/trip/` + this.id + `/edit'>Edit</a> | <a href='/admin/trip/` + this.id + `/delete'>Delete</a>`}",
                        'footer' => 'Action',
                        'exportable' => false,
                        'printable' => false,
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
            Column::make('city_name'),
            Column::make('days'),
            Column::make('price'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Trip_' . date('YmdHis');
    }
}
