"use client"

import { useState } from "react"

import {
    ColumnDef,
    flexRender,
    getCoreRowModel,
    useReactTable,
    getPaginationRowModel,
    PaginationState,
    getSortedRowModel,
    SortingState,
    ColumnFiltersState,
    getFilteredRowModel
} from "@tanstack/react-table"
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow
} from "@/Components/ui/table"
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select"
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetHeader,
    SheetTitle,
    SheetTrigger,

} from "@/Components/ui/sheet"
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from "@/Components/ui/accordion"
import {
    MagnifyingGlassIcon,
    Cross1Icon
} from "@radix-ui/react-icons"
import { Button } from "@/Components/ui/button"
import { Input } from "@/Components/ui/input"
import { Separator } from "@/Components/ui/separator"
import { ScrollArea } from "../ui/scroll-area"
import { Link } from "@inertiajs/react"

type Meta = {
    header: string
    key: string
    tipo: string
    options?: any[]
}

interface DataTableProps<TData, TValue> {
    columns: ColumnDef<TData, TValue>[]
    data: TData[]
    rc: string
}

export function DataTable<TData, TValue>({
    columns,
    data,
    rc
}: DataTableProps<TData, TValue>) {
    const [pagination, setPagination] = useState<PaginationState>({
        pageIndex: 0,
        pageSize: 8,
    })
    const [sorting, setSorting] = useState<SortingState>([])
    const [columnFilters, setColumnFilters] = useState<ColumnFiltersState>([])
    const [rowSelection, setRowSelection] = useState({})
    console.log(rowSelection)

    const table = useReactTable({
        data,
        columns,
        defaultColumn: {
            size: 100,
            minSize: 50,
            maxSize: 200
        },
        getCoreRowModel: getCoreRowModel(),
        getPaginationRowModel: getPaginationRowModel(),
        onPaginationChange: setPagination,
        onSortingChange: setSorting,
        getSortedRowModel: getSortedRowModel(),
        onColumnFiltersChange: setColumnFilters,
        getFilteredRowModel: getFilteredRowModel(),
        onRowSelectionChange: setRowSelection,
        initialState: {
            pagination: pagination,
            sorting: sorting,
            columnFilters: columnFilters,
        },
        state: {
            pagination,
            sorting,
            columnFilters,
            rowSelection
        },
    })

    return (
        <div className="select-none">
            <div className="flex items-center justify-end gap-3 mb-3">
                <Sheet>
                    <SheetTrigger asChild>
                        <Button variant={table.getState().columnFilters.length > 0 ? "default" : "ghost"} className="gap-2">
                            <MagnifyingGlassIcon />
                            Filtros
                            {table.getState().columnFilters.length > 0 ? <span className="text-sm font-medium">({table.getState().columnFilters.length})</span> : null}
                        </Button>
                    </SheetTrigger>
                    <SheetContent className="w-96 overflow-auto">
                        <SheetHeader>
                            <SheetTitle className="font-bold text-xl">
                                Filtros
                            </SheetTitle>
                            <SheetDescription>
                                Selecciona los filtros que desees.
                            </SheetDescription>
                            <div className="flex flex-col items-start gap-10">
                                <div>
                                    <Button variant={"destructive"} size={'sm'} onClick={() => table.resetColumnFilters()}>Limpiar filtros</Button>
                                </div>
                                <div className="flex flex-col gap-8 w-full">
                                    {table.getAllColumns().map((column) => {
                                        if (column.getCanFilter()) {
                                            let info = column.columnDef.meta as Meta
                                            if (info.tipo == 'select') {
                                                return (
                                                    <Accordion key={column.id} type="single" collapsible className="w-full">
                                                        <AccordionItem value={column.id}>
                                                            <AccordionTrigger>{info.header}</AccordionTrigger>
                                                            <AccordionContent>
                                                                <Select open onValueChange={value => {
                                                                    // console.log(columnFilters)
                                                                    const meta = column.columnDef.meta as Meta
                                                                    let val = value === '*' ? undefined : value
                                                                    let copyFilters = columnFilters
                                                                    if (copyFilters.find((filter) => filter.id === meta.key)) {
                                                                        copyFilters.map((filter) => {
                                                                            if (filter.id === meta.key) {
                                                                                filter.value = val
                                                                            }
                                                                        })
                                                                    } else {
                                                                        copyFilters.push({ id: meta.key, value: val })
                                                                    }

                                                                    // console.log('Copia', copyFilters)
                                                                    setColumnFilters(copyFilters)
                                                                }}>
                                                                    <SelectTrigger>
                                                                        <SelectValue placeholder={table.getColumn(info.key)?.getFilterValue() as string ?? "Todos"} />
                                                                    </SelectTrigger>
                                                                    <SelectContent>
                                                                        {info.options?.map((option) => {
                                                                            const curr = table.getColumn(info.key)?.getFilterValue() ? table.getColumn(info.key)?.getFilterValue() : '*'
                                                                            // console.log('curr', curr)
                                                                            let text = option !== '*' ? option : 'Todos'
                                                                            return (
                                                                                <SelectItem key={option} value={option} {...(option === curr ? { 'data-state': 'checked' } : {})}>
                                                                                    {text}
                                                                                </SelectItem>)
                                                                        })}
                                                                    </SelectContent>
                                                                </Select>
                                                            </AccordionContent>
                                                        </AccordionItem>
                                                    </Accordion>
                                                )
                                            }
                                            return (
                                                <Accordion key={column.id} type="single" collapsible className="w-full scroll-auto">
                                                    <AccordionItem value={column.id}>
                                                        <AccordionTrigger>{info.header}</AccordionTrigger>
                                                        <AccordionContent>
                                                            <Input
                                                                placeholder={`${info.header.toLowerCase()}...`}
                                                                value={(table.getColumn(info.key)?.getFilterValue() as string) ?? ""}
                                                                onChange={(e) =>
                                                                    table.getColumn(info.key)?.setFilterValue(e.target.value)
                                                                }
                                                                className="max-w-sm"
                                                            />
                                                        </AccordionContent>
                                                    </AccordionItem>
                                                </Accordion>

                                            )
                                        }
                                    })
                                    }
                                </div>
                            </div>
                        </SheetHeader>
                    </SheetContent>
                </Sheet>
                <Separator className="h-10" orientation="vertical" />
                <Button
                    variant="outline"
                    size="sm"
                    className="select-none"
                    onClick={() => table.previousPage()}
                    disabled={!table.getCanPreviousPage()}
                >
                    Anterior
                </Button>
                <Button
                    variant="outline"
                    size="sm"
                    className="select-none"
                    onClick={() => table.nextPage()}
                    disabled={!table.getCanNextPage()}
                >
                    Siguiente
                </Button>
            </div>
            <div className="rounded-md border overflow-auto">
                <Table>
                    <TableHeader>
                        {table.getHeaderGroups().map((headerGroup) => {
                            return (
                                <TableRow key={headerGroup.id}>
                                    {headerGroup.headers.map((header) => {
                                        return (
                                            <TableHead key={header.id}>
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
            <div className="flex items-center justify-end gap-4 py-4 me-3 select-none">
                <div className="flex items-center gap-2">
                    Mostrar
                    <Select onValueChange={(value) => setPagination({
                        ...pagination,
                        pageSize: Number(value)
                    })}>
                        <SelectTrigger className="w-[10ch]">
                            <SelectValue placeholder={pagination.pageSize} />
                        </SelectTrigger>
                        <SelectContent>
                            {[5, 8, 10, 15].map((pageSize) => (
                                <SelectItem key={pageSize} value={pageSize.toString()}>
                                    {pageSize}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    registros
                </div>
                <Separator orientation="vertical" className="h-10" />
                <div className="flex items-center gap-2">
                    Página
                    <Input
                        type="text"
                        value={table.getState().pagination.pageIndex + 1}
                        onChange={(e) => {
                            let conv = e.target.value ? Number(e.target.value) - 1 : 0
                            let val = conv > table.getPageCount() ? table.getPageCount() - 1 : conv

                            table.setPageIndex(Number(val))
                        }}
                        className="w-[7ch] text-center"
                    />
                    de {table.getPageCount()}
                </div>
            </div>
        </div>
    )
}
