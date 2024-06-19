"use client"

import { useEffect, useState } from "react"

import {
    ColumnDef,
    flexRender,
    getCoreRowModel,
    useReactTable,
    getPaginationRowModel,
    getSortedRowModel,
    SortingState,
    ColumnFiltersState,
    getFilteredRowModel,
    VisibilityState,
    InitialTableState
} from "@tanstack/react-table"
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow
} from "@/Components/ui/table"
import { Separator } from "@/Components/ui/separator"
import { DataTablePagination } from "./Pagination"
import ColumnFilters from "@/Components/Data/ColumnFilters"
import { DataTableViewOptions } from "@/Components/Data/ColumnToggle"
import { Toaster } from "@/Components/ui/toaster"
import { useToast } from "@/Components/ui/use-toast"
import { usePage } from "@inertiajs/react"
import { Flash } from "@/types"

interface DataTableProps<TData, TValue> {
    columns: ColumnDef<TData, TValue>[]
    data: TData[]
    initialVisibility?: TData
}

export function DataTable<TData, TValue>({
    columns,
    data,
    initialVisibility
}: DataTableProps<TData, TValue>) {
    const { toast } = useToast()
    const pageProps = usePage().props
    const flash = pageProps.flash as Flash

    useEffect(() => {
        if (flash.message?.toast) {
            toast({
                variant: flash.message.toast?.variant,
                title: flash.message.toast?.title !== undefined ? flash.message.toast?.title : '',
                description: flash.message.toast?.description,
            })
        }
    }, [flash])

    const [sorting, setSorting] = useState<SortingState>([])
    const [columnFilters, setColumnFilters] = useState<ColumnFiltersState>([])
    const [rowSelection, setRowSelection] = useState({})
    const [columnVisibility, setColumnVisibility] = useState<VisibilityState>(initialVisibility ? initialVisibility : {})

    const table = useReactTable({
        data,
        columns,
        getCoreRowModel: getCoreRowModel(),
        getPaginationRowModel: getPaginationRowModel(),
        onSortingChange: setSorting,
        getSortedRowModel: getSortedRowModel(),
        onColumnFiltersChange: setColumnFilters,
        getFilteredRowModel: getFilteredRowModel(),
        onRowSelectionChange: setRowSelection,
        onColumnVisibilityChange: setColumnVisibility,
        initialState: {
            sorting: sorting,
            columnFilters: columnFilters,
        },
        state: {
            sorting,
            columnFilters,
            rowSelection,
            columnVisibility
        },
    })

    console.log(table.getState())

    return (
        <div className="select-none">
            <div className="flex items-center justify-end gap-3 mb-3">
                <ColumnFilters table={table} filterState={columnFilters} setFilterState={setColumnFilters} />
                <Separator className="h-10" orientation="vertical" />
                <DataTableViewOptions table={table} />
            </div>
            <div className="rounded-md border overflow-auto w-full mx-auto">
                <Table className="w-full">
                    <TableHeader>
                        {table.getHeaderGroups().map((headerGroup) => {
                            return (
                                <TableRow key={headerGroup.id}>
                                    {headerGroup.headers.map((header) => {
                                        return (
                                            <TableHead key={header.id} className={(header.column.columnDef.id !== "select" ? 'p-3' : 'p-4')} style={{ width: `${header.getSize()}px` }}>
                                                {header.isPlaceholder
                                                    ? null
                                                    : flexRender(
                                                        header.column.columnDef.header,
                                                        header.getContext()
                                                    )}
                                            </TableHead>
                                        )
                                    })}
                                </TableRow>
                            )
                        })}
                    </TableHeader>
                    <TableBody>
                        {table.getRowModel().rows.length ? (
                            table.getRowModel().rows.map((row) => (
                                <TableRow
                                    key={row.id}
                                    data-state={row.getIsSelected() && "selected"}
                                >
                                    {row.getVisibleCells().map((cell) => (
                                        <TableCell key={cell.id}>
                                            {flexRender(cell.column.columnDef.cell, cell.getContext())}
                                        </TableCell>
                                    ))}
                                </TableRow>
                            ))
                        ) : (
                            <TableRow>
                                <TableCell colSpan={columns.length} className="h-24 text-center">
                                    Sin registros.
                                </TableCell>
                            </TableRow>
                        )}
                    </TableBody>
                </Table>
            </div>
            <div className="flex w-full p-4 justify-end">
                <DataTablePagination table={table} />
            </div>
            <Toaster />
        </div >
    )
}
