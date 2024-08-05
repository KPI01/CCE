"use client";

import { DataTableColumnHeader } from "@/Components/Data/ColumnHeader";
import { Maquina } from "@/types";
import { ColumnDef } from "@tanstack/react-table";
import Actions from "./Actions";

export const columns: ColumnDef<Maquina>[] = [
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
    accessorKey: "tipo_id",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Tipo" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: false,
    size: 200,
    meta: {
      header: "Tipo",
      key: "tipo_id",
    },
  },
  {
    accessorKey: "fabricante",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Fabricante" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: false,
    size: 250,
    meta: {
      header: "Fabricante",
      key: "fabricante",
    },
  },
  {
    accessorKey: "matricula",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Matrícula" />
    ),
    enableColumnFilter: true,
    enableSorting: false,
    enableHiding: false,
    size: 100,
    meta: {
      header: "Matrícula",
      key: "matricula",
    },
  },
  {
    accessorKey: "modelo",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Modelo" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: true,
    size: 100,
    meta: {
      header: "Modelo",
      key: "modelo",
    },
  },
  {
    accessorKey: "marca",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Marca" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: true,
    size: 100,
    meta: {
      header: "Marca",
      key: "marca",
    },
  },
  {
    accessorKey: "roma",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Cod. ROMA" />
    ),
    enableColumnFilter: true,
    enableSorting: false,
    enableHiding: true,
    size: 100,
    meta: {
      header: "Cod. ROMA",
      key: "roma",
    },
  },
  {
    accessorKey: "nro_serie",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Nº. Serie" />
    ),
    enableColumnFilter: true,
    enableSorting: false,
    enableHiding: true,
    size: 100,
    meta: {
      header: "Nº. Serie",
      key: "nro_serie",
    },
  },
  {
    accessorKey: "cad_iteaf",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Cad. Iteaf" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: true,
    size: 100,
    meta: {
      header: "Caducidad ITEAF",
      key: "cad_iteaf",
    },
    cell: (info) => {
      if (info.getValue()) {
        return new Date(info.getValue() as string).toLocaleDateString();
      }
    },
  },
  {
    id: "actions",
    cell: ({ row }) => {
      const maquina = row.original;
      return <Actions item={maquina} />;
    },
  },
];
