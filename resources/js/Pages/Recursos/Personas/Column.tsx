"use client";

import { ColumnDef } from "@tanstack/react-table";

import { Persona } from "@/types";
import { DataTableColumnHeader } from "@/Components/Data/ColumnHeader";
import Actions from "@/Components/Data/Persona/Actions";

export const columns: ColumnDef<Persona>[] = [
  {
    accessorKey: "nombres",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Nombres" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: false,

    size: 150,
    meta: {
      header: "Nombres",
      key: "nombres",
    },
  },
  {
    accessorKey: "apellidos",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Apellidos" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: false,
    size: 150,
    meta: {
      header: "Apellidos",
      key: "apellidos",
    },
  },
  {
    accessorKey: "id_nac",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="DNI/NIE" />
    ),
    enableColumnFilter: true,
    enableSorting: false,
    enableHiding: false,
    meta: {
      header: "DNI/NIE",
      key: "id_nac",
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
    accessorFn: (row) => {
      if (row.ropo?.tipo) {
        return row.ropo.tipo;
      }
      return null;
    },
    id: "ropo_tipo",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Tipo Carnet ROPO" />
    ),
    enableColumnFilter: true,
    enableHiding: true,
    size: 250,
    meta: {
      header: "Tipo de Carnet ROPO",
      key: "ropo_tipo",
      tipo: "select",
      options: ["*", "Aplicador", "Técnico"],
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
      <DataTableColumnHeader column={column} title="Caducidad" />
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
      header: "Caducidad Carnet ROPO",
      key: "ropo_caducidad",
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
      <DataTableColumnHeader column={column} title="Nº Carnet" />
    ),
    enableColumnFilter: true,
    enableSorting: false,
    meta: {
      header: "N° de Carnet ROPO",
      key: "ropo_nro",
    },
  },
  {
    accessorFn: (row) => {
      if (row.ropo?.tipo_aplicador) {
        return row.ropo.tipo_aplicador;
      }
      return null;
    },
    id: "ropo_tipo_aplicador",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Tipo Aplicador" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    meta: {
      header: "Tipo Aplicador ROPO",
      key: "ropo_tipo_aplicador",
    },
  },
  {
    id: "actions",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Acciones" />
    ),
    cell: ({ row }) => {
      const persona = row.original;

      return <Actions item={persona} />;
    },
    enableHiding: false,
  },
];
