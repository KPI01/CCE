import MainLayout from "@/Layouts/MainLayout";
import { DataTable } from "@/Components/DataTable/Table";
import { ColumnDef } from "@tanstack/react-table";
import { DataTableColumnHeader } from "@/Components/DataTable/ColumnHeader";
import { type Cultivo } from "@/types";
import Actions from "@/Components/DataTable/Actions";
import { z } from "zod";
import {
  MAX_MESSAGE,
  REQUIRED_MSG,
  TYPE_MESSAGE,
} from "@/Pages/Recursos/utils";
import DynamicForm from "@/lib/forms";
import { router } from "@inertiajs/react";

const formFields = [
  { name: "nombre", label: "Nombre", type: "text" },
  { name: "variedad", label: "Variedad", type: "text" },
];

const columns: ColumnDef<Cultivo>[] = [
  {
    accessorKey: "nombre",
    header: ({ column }) => (

      <DataTableColumnHeader column={column} title="Nombre" />
    ),
    enableHiding: false,
    enableColumnFilter: true,
    enableSorting: true,
    size: undefined,
  },
  {
    accessorKey: "variedad",
    header: ({ column }) => (
      <DataTableColumnHeader column={column} title="Variedad" />
    ),
    enableHiding: false,
    enableColumnFilter: true,
    enableSorting: true,
    size: undefined,
  },
  {
    id: "actions",
    enableHiding: false,
    header: ({ column }) => (
      <DataTableColumnHeader
        column={column}
        title="Acciones"
        className="ml-auto text-end"
      />
    ),
    cell: ({ row }) => {
      const original = row.original;

      const schema = z.object({
        nombre: z
          .string({
            required_error: REQUIRED_MSG("El nombre"),
            invalid_type_error: TYPE_MESSAGE("El nombre", "texto"),
          })
          .min(1, REQUIRED_MSG("El nombre"))
          .max(25, MAX_MESSAGE(25)),
        variedad: z.string().max(25, MAX_MESSAGE(25)),
      });

      const onSubmit = () => {
        console.log("Enviando datos...");
        router.put(route("cultivo.store"));
      };

      return (
        <Actions
          display={`${original.nombre} (${original.variedad})`}
          form={
            <DynamicForm
              fields={formFields}
              onSubmit={onSubmit}
              schema={schema}
              defaults={original}
            />
          }
          simplified
        />
      );
    },
  },
];

interface Props {
  data: Cultivo[];
  fields: Record<string, unknown>[];
}

export default function Cultivo({ data, fields }: Props) {
  console.debug("CultivoTable");
  console.log(fields);

  return (
    <MainLayout>
      <div>
        <h1 className="mb-10 mt-6 text-6xl font-bold">Cultivos</h1>
      </div>
      <DataTable columns={columns} data={data} />
    </MainLayout>
  );
}
