"use client"

import { ColumnDef } from "@tanstack/react-table"

import { Button } from "@/Components/ui/button"
import {
 CaretSortIcon,
} from "@radix-ui/react-icons"
import { Empresa } from "@/types"
import Actions from "@/Components/Data/Actions"

export const columns: ColumnDef<Empresa>[] = [
    {
        accessorKey: "nombre",
        header: ({ column }) => {
            return (
              <Button
                variant="ghost"
                onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
              >
                Nombre
                <CaretSortIcon className="ml-2 h-4 w-4" />
              </Button>
            )
          },
        enableColumnFilter: true,
        meta: {
            header: "Nombre",
            key: "nombre"
        }
    },
    {
        accessorKey: "nif",
        header: ({ column }) => {
            return (
              <Button
                variant="ghost"
                onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
              >
                NIF
                <CaretSortIcon className="ml-2 h-4 w-4" />
              </Button>
            )
          },
        enableColumnFilter: true,
        meta: {
            header: "NIF",
            key: "nif"
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
        accessorKey: "direccion",
        header: "Dirección",
        enableColumnFilter: false,
        meta: {
            header: "Dirección",
            key: "direccion",
        }
    },
    {
        accessorKey: "observaciones",
        header: "Observaciones",
        enableColumnFilter: false,
        meta: {
            header: "Observaciones",
            key: "observaciones"
        }
    },
    {
        id: "actions",
        header: "Acciones",
        cell: ({ row }) => {
            const item = row.original

            return (
                <Actions routeName='recurso.empresa.show' item={item.id} />
            )
        },
        enableColumnFilter: false
    }
]
