"use client";

import { useState } from "react";

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
} from "@tanstack/react-table";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/Components/ui/table";
import { Separator } from "@/Components/ui/separator";
import { Pagination } from "./Pagination";
import ColumnFilters from "@/Components/Data/ColumnFilters";
import { ColumnToggle } from "@/Components/Data/ColumnToggle";

interface DataTableProps<TData, TValue> {
  columns: ColumnDef<TData, TValue>[];
  data: TData[];
  initialVisibility?: TData;
}

export function DataTable<TData, TValue>({
  columns,
  data,
  initialVisibility,
}: DataTableProps<TData, TValue>) {
  const [sorting, setSorting] = useState<SortingState>([]);
  const [columnFilters, setColumnFilters] = useState<ColumnFiltersState>([]);
  const [rowSelection, setRowSelection] = useState({});
  const [columnVisibility, setColumnVisibility] = useState<VisibilityState>(
    initialVisibility ? initialVisibility : {},
  );

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
      columnVisibility,
    },
  });

  return (
    <div id="data_table-container" className="select-none">
      <div className="mb-3 flex items-center justify-end gap-3">
        <ColumnFilters
          table={table}
          filterState={columnFilters}
          setFilterState={setColumnFilters}
        />
        <Separator className="h-10" orientation="vertical" />
        <ColumnToggle table={table} />
      </div>
      <div className="mx-auto w-full overflow-auto rounded-md border">
        <Table className="w-full" id="data-table">
          <TableHeader>
            {table.getHeaderGroups().map((headerGroup) => {
              return (
                <TableRow key={headerGroup.id}>
                  {headerGroup.headers.map((header) => {
                    return (
                      <TableHead
                        key={header.id}
                        id={`header-${header.id}`}
                        className={
                          header.column.columnDef.id !== "select"
                            ? "p-3"
                            : "p-4"
                        }
                        style={{ width: `${header.getSize()}px` }}
                      >
                        {header.isPlaceholder
                          ? null
                          : flexRender(
                              header.column.columnDef.header,
                              header.getContext(),
                            )}
                      </TableHead>
                    );
                  })}
                </TableRow>
              );
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
                      {flexRender(
                        cell.column.columnDef.cell,
                        cell.getContext(),
                      )}
                    </TableCell>
                  ))}
                </TableRow>
              ))
            ) : (
              <TableRow>
                <TableCell
                  colSpan={columns.length}
                  className="h-24 text-center"
                >
                  Sin registros.
                </TableCell>
              </TableRow>
            )}
          </TableBody>
        </Table>
      </div>
      <div className="flex w-full justify-end p-4">
        <Pagination table={table} />
      </div>
    </div>
  );
}
