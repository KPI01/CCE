"use client"

import { ColumnDef } from "@tanstack/react-table"
import { MoreHorizontal } from "lucide-react"

import { Button } from "@/Components/ui/button"
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu"
import {
 CaretSortIcon,
 FileTextIcon,
 Pencil2Icon
} from "@radix-ui/react-icons"

import { Persona } from "@/types"
import Actions from "@/Components/Data/Actions"

export const columns: ColumnDef<Persona>[] = [
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
        accessorKey: "ropo.tipo",
        header: "Tipo de Carnet ROPO",
        enableColumnFilter: true,
        meta: {
            header: "Tipo de Carnet ROPO",
            key: "ropo_tipo",
            tipo: 'select',
            options: ["*", "Aplicador", "Técnico"]
        }
    },
    {
        accessorKey: "ropo.caducidad",
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
        accessorKey: "ropo.nro",
        header: "N° de Carnet ROPO",
        enableColumnFilter: true,
        meta: {
            header: "N° de Carnet ROPO",
            key: "ropo_nro"
        }
    },
    {
        accessorKey: "ropo.tipo_aplicador",
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
    {
        id: "actions",
        header: "Acciones",
        cell: ({ row }) => {
            const item = row.original

            return (
                <Actions routeName='recurso.persona.show' item={item.id} />
            )
        },
        enableColumnFilter: false
    }
]
