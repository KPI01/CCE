"use client"

import { ColumnDef } from "@tanstack/react-table"

import { Button } from "@/Components/ui/button"

import {
 CaretSortIcon,

} from "@radix-ui/react-icons"

import { Persona } from "@/types"
import { Checkbox } from "@/Components/ui/checkbox"

export const columns: ColumnDef<Persona>[] = [
    {
        id: "select",
        header: ({ table }) => (
          <Checkbox
            className="size-5"
            checked={
              table.getIsAllPageRowsSelected() ||
              (table.getIsSomePageRowsSelected() && "indeterminate")
            }
            onCheckedChange={(value) => table.toggleAllPageRowsSelected(!!value)}
            aria-label="Select all"
          />
        ),
        cell: ({ row }) => (
          <Checkbox
            checked={row.getIsSelected()}
            onCheckedChange={(value) => row.toggleSelected(!!value)}
            aria-label="Select row"
          />
        ),
        enableSorting: false,
        enableHiding: false,
      },
    {
        accessorKey: "nombres",
        header: ({ column }) => {
            return (
              <Button
                variant="ghost"
                onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
              >
                Nombres
                <CaretSortIcon className="ml-2 h-4 w-4" />
              </Button>
            )
          },
        enableColumnFilter: true,
        meta: {
            header: "Nombres",
            key: "nombres"
        }
    },
    {
        accessorKey: "apellidos",
        header: ({ column }) => {
            return (
              <Button
                variant="ghost"
                onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
              >
                Apellidos
                <CaretSortIcon className="ml-2 h-4 w-4" />
              </Button>
            )
          },
        enableColumnFilter: true,
        meta: {
            header: "Apellidos",
            key: "apellidos"
        }
    },
    {
        accessorKey: "id_nac",
        header: "DNI/NIE",
        enableColumnFilter: true,
        meta: {
            header: "DNI/NIE",
            key: "id_nac"
        }
    },
    {
        accessorKey: "email",
        header: "Email",
        enableColumnFilter: true,
        meta: {
            header: "Email",
            key: "email"
        }
    },
    {
        accessorKey: "tel",
        header: "Teléfono",
        enableColumnFilter: false,
        meta: {
            header: "Teléfono",
            key: "tel"
        }
    },
    {
        accessorKey: "perfil",
        header: ({ column }) => {
            return (
              <Button
                variant="ghost"
                onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
              >
                Perfil
                <CaretSortIcon className="ml-2 h-4 w-4" />
              </Button>
            )
          },
          enableColumnFilter: true,
          meta: {
            header: "Perfil",
            key: "perfil"
        }
    },
    {
        accessorFn: (row) => {
            if (row.ropo?.tipo) {
                return row.ropo.tipo
            }
            return null
        },
        id: "ropo_tipo",
        header: "Tipo de Carnet ROPO",
        enableColumnFilter: true,
        size: 200,
        meta: {
            header: "Tipo de Carnet ROPO",
            key: "ropo_tipo",
            tipo: 'select',
            options: ["*", "Aplicador", "Técnico"]
        }
    },
    {
        accessorFn: (row) => {
            if (row.ropo?.caducidad) {
                return row.ropo.caducidad
            }
            return null
        },
        id: "ropo_caducidad",
        header: ({ column }) => {
            return (
              <Button
                variant="ghost"
                onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
              >
                Caducidad Carnet ROPO
                <CaretSortIcon className="ml-2 h-4 w-4" />
              </Button>
            )
          },
        cell: (info) => {
            if (info.getValue()) {
                return new Date(info.getValue() as string).toLocaleDateString()
            }
        },
        enableColumnFilter: true,
        meta: {
            header: "Caducidad Carnet ROPO",
            key: "ropo_caducidad"
        }
    },
    {
        accessorFn: (row) => {
            if (row.ropo?.nro) {
                return row.ropo.nro
            }
            return null
        },
        id: "ropo_nro",
        header: "N° de Carnet ROPO",
        enableColumnFilter: true,
        meta: {
            header: "N° de Carnet ROPO",
            key: "ropo_nro"
        }
    },
    {
        accessorFn: (row) => {
            if (row.ropo?.tipo_aplicador) {
                return row.ropo.tipo_aplicador
            }
            return null
        },
        id: "ropo_tipo_aplicador",
        header: ({ column }) => {
            return (
              <Button
                variant="ghost"
                onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
              >
                Tipo Aplicador ROPO
                <CaretSortIcon className="ml-2 h-4 w-4" />
              </Button>
            )
          },
        enableColumnFilter: true,
        meta: {
            header: "Tipo Aplicador ROPO",
            key: "ropo_tipo_aplicador"
        }
    },
]
