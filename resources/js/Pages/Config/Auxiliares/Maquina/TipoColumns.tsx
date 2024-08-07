import { DataTableColumnHeader } from "@/Components/DataTable/ColumnHeader";
import { TipoMaquina } from "@/types";
import { ColumnDef } from "@tanstack/react-table";

export const columnsTipo: ColumnDef<TipoMaquina>[] = [
  {
    accessorKey: "id",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="ID" />
    ),
    enableColumnFilter: false,
    enableSorting: true,
    enableHiding: false,
  },
  {
    accessorKey: "tipo",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Tipo" />
    ),
    enableColumnFilter: true,
    enableSorting: true,
    enableHiding: false,
    meta: {
      header: "Tipo",
      key: "tipo",
    },
  },
  {
    accessorKey: "url",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Acciones" />
    ),
    enableColumnFilter: false,
    enableSorting: false,
    enableHiding: false,
  },
];
