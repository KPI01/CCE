"use client";

import { DataTableColumnHeader } from "@/Components/DataTable/ColumnHeader";
import { Checkbox } from "@/Components/ui/checkbox";
import { Campana } from "@/types";
import { ColumnDef } from "@tanstack/react-table";
import Actions from "./Actions";

export const columns: ColumnDef<Campana>[] = [
  {
    accessorKey: "nombre",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Nombre" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: false,
    size: 200,
    meta: {
      header: "Nombre",
      key: "nombre",
    },
  },
  {
    accessorKey: "is_activa",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="¿Activa?" />
    ),
    cell: ({ row }) => <Checkbox checked={row.original.is_activa} />,
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: false,
    size: 200,
    meta: {
      header: "¿Activa?",
      key: "is_activa",
    },
  },
  {
    accessorKey: "inicio",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Inicio" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: false,
    size: 200,
    meta: {
      header: "Inicio",
      key: "inicio",
    },
  },
  {
    accessorKey: "fin",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Fin" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: false,
    size: 200,
    meta: {
      header: "Fin",
      key: "fin",
    },
  },
  {
    accessorKey: "descripcion",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Descripción" />
    ),
    enableColumnFilter: false,
    enableSorting: false,
    enableHiding: false,
    size: 200,
    meta: {
      header: "Descripción",
      key: "descripcion",
    },
  },
  {
    id: "actions",
    cell: ({ row }) => {
      return <Actions data={row.original} />;
    },
  },
];
