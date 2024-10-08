"use client";

import { ColumnDef } from "@tanstack/react-table";

import { DataTableColumnHeader } from "@/Components/DataTable/ColumnHeader";
import { Empresa } from "..";
import Actions from "@/Components/DataTable/Actions";

export const columns: ColumnDef<Empresa>[] = [
  {
    accessorKey: "nombre",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Nombre" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: false,

    size: 250,
    meta: {
      header: "Nombre",
      key: "nombre",
    },
  },
  {
    accessorKey: "nif",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="NIF" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: false,

    size: 150,
    meta: {
      header: "NIF",
      key: "nif",
    },
  },
  {
    accessorKey: "email",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Email" />
    ),
    enableColumnFilter: true,
    enableSorting: false,
    enableHiding: true,
    minSize: 300,
    meta: {
      header: "Email",
      key: "email",
    },
  },
  {
    accessorKey: "tel",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Tel." />
    ),
    enableColumnFilter: false,
    enableSorting: false,
    enableHiding: true,
    minSize: 250,
    meta: {
      header: "Teléfono",
      key: "tel",
    },
  },
  {
    accessorKey: "perfil",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Perfil" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: true,
    meta: {
      header: "Perfil",
      key: "perfil",
    },
  },
  {
    accessorKey: "codigo",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Código" />
    ),
    enableColumnFilter: true,
    enableSorting: false,
    enableHiding: true,
    minSize: 250,
    meta: {
      header: "Teléfono",
      key: "tel",
    },
  },
  {
    id: "actions",
    cell: ({ row }) => {
      const { original } = row;
      const display = `${original.nombre} (${original.nif})`;

      return <Actions display={display} url={original.url} />;
    },
    enableHiding: false,
    enablePinning: true,
  },
];
