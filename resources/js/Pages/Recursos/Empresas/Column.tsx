"use client";

import { ColumnDef } from "@tanstack/react-table";

import { ActionUrls, Empresa } from "@/types";
import Actions from "./Actions";
import { DataTableColumnHeader } from "@/Components/Data/ColumnHeader";

export const columns: ColumnDef<Empresa & { urls: ActionUrls }>[] = [
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
    accessorFn: (row) => {
      if (row.ropo?.capacitacion) {
        return row.ropo.capacitacion;
      }
      return null;
    },
    id: "ropo_capacitacion",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Capacitación ROPO" />
    ),
    enableColumnFilter: true,
    enableHiding: true,
    size: 250,
    meta: {
      header: "Capacitación ROPO",
      key: "ropo_capacitacion",
      tipo: "select",
    },
  },
  {
    accessorFn: (row) => {
      if (row.ropo?.nro) {
        return row.ropo.nro;
      }
      return null;
    },
    id: "ropo_nro",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Id. ROPO" />
    ),
    enableColumnFilter: true,
    enableSorting: false,
    meta: {
      header: "Id. ROPO",
      key: "ropo_nro",
    },
  },
  {
    accessorFn: (row) => {
      if (row.ropo?.caducidad) {
        return row.ropo.caducidad;
      }
      return null;
    },
    id: "ropo_caducidad",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Caducidad ROPO" />
    ),
    cell: (info) => {
      if (info.getValue()) {
        return new Date(info.getValue() as string).toLocaleDateString();
      }
    },
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: true,
    meta: {
      header: "Caducidad ROPO",
      key: "ropo_caducidad",
    },
  },
  {
    id: "actions",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Acciones" />
    ),
    cell: ({ row }) => {
      const empresa = row.original;

      return <Actions item={empresa} />;
    },
    enableHiding: false,
    enablePinning: true,
  },
];
