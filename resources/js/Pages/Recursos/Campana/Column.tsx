"use client";

import { DataTableColumnHeader } from "@/Components/DataTable/ColumnHeader";
import { ColumnDef } from "@tanstack/react-table";
import { Switch } from "@/Components/ui/switch";
import { formatDate } from "date-fns";
import { convertToType } from "../utils";
import { Campana } from "..";
import Actions from "@/Components/DataTable/Actions";

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
    cell: ({ row }) => {
      const val = convertToType<boolean>({
        val: row.original.is_activa,
        type: "boolean",
      });
      return (
        <div className="items-top flex space-x-2">
          <Switch className="ms-4" defaultChecked={val} disabled />
        </div>
      );
    },
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
    cell: ({ row }) => {
      const formatted = formatDate(row.original.inicio, "dd/MM/yyyy");
      return formatted;
    },
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
    cell: ({ row }) => {
      const formatted = formatDate(row.original.fin, "dd/MM/yyyy");
      return formatted;
    },
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
      const { original } = row;
      const display = `la campaña ${original.nombre} que está ${
        original.is_activa ? "activa" : "inactiva"
      }`;

      return <Actions display={display} url={original.url} />;
    },
  },
];
