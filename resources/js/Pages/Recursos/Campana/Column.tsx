"use client";

import { DataTableColumnHeader } from "@/Components/DataTable/ColumnHeader";
import { Campana } from "@/types";
import { ColumnDef } from "@tanstack/react-table";
import Actions from "./Actions";
import { Switch } from "@/Components/ui/switch";

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
    cell: ({ row }) => (
      <div className="items-top flex space-x-2">
        <Switch
          className="ms-4"
          defaultChecked={row.original.is_activa}
          disabled
        />
      </div>
    ),
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
    enableHiding: true,
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
