"use client";
import {
  flexRender,
  getCoreRowModel,
  getPaginationRowModel,
  useReactTable,
  getSortedRowModel,
} from "@tanstack/react-table";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/Components/ui/table";
import { Pagination } from "./Pagination";
import { Separator } from "../ui/separator";
import { useState } from "react";
import { DataTableProps } from ".";

export default function DataTable<TData, TValue>({
  config,
  state = {},
}: DataTableProps<TData, TValue>) {
  const [visibility, setVisibility] = useState(state.visibility || {});
  const [sorting, setSorting] = useState(state.sorting || []);

  const table = useReactTable({
    data: config.data,
    columns: config.columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    onColumnVisibilityChange: setVisibility,
    onSortingChange: setSorting,
    getSortedRowModel: getSortedRowModel(),
    state: { columnVisibility: visibility, sorting },
    debugAll: true,
  });

  console.debug("state:", table.getState());

  return (
    <div className="my-5 rounded-md border">
      <Table>
        <TableHeader>
          {table.getHeaderGroups().map((headerGroup) => (
            <TableRow key={headerGroup.id}>
              {headerGroup.headers.map((header) => {
                return (
                  <TableHead key={header.id}>
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
          ))}
        </TableHeader>
        <TableBody>
          {table.getRowModel().rows?.length ? (
            table.getRowModel().rows.map((row) => (
              <TableRow
                key={row.id}
                data-state={row.getIsSelected() && "selected"}
              >
                {row.getVisibleCells().map((cell) => (
                  <TableCell key={cell.id} className="px-4 py-3">
                    {flexRender(cell.column.columnDef.cell, cell.getContext())}
                  </TableCell>
                ))}
              </TableRow>
            ))
          ) : (
            <TableRow>
              <TableCell
                colSpan={config.columns.length}
                className="h-24 text-center"
              >
                No results.
              </TableCell>
            </TableRow>
          )}
        </TableBody>
      </Table>
      <Separator />
      <Pagination table={table} />
    </div>
  );
}
