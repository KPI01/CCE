import MainLayout from "@/Layouts/MainLayout";
import { ColumnDef } from "@tanstack/react-table";
import { DataTableColumnHeader } from "@/Components/DataTable/ColumnHeader";
import { type Cultivo } from "@/types";
import { z } from "zod";
import {
  MAX_MESSAGE,
  REQUIRED_MSG,
  TYPE_MESSAGE,
} from "@/Pages/Recursos/utils";
import { CreateDialog, DynamicForm, Methods } from "@/lib/forms";
import { Dialog, DialogTrigger } from "@/Components/ui/dialog";
import { buttonVariants } from "@/Components/ui/button";
import { Head } from "@inertiajs/react";
import Actions from "@/Components/DataTable/Actions";
import DataTable from "@/Components/DataTable/Table";

const schema = z.object({
  id: z.string(),
  nombre: z
    .string({
      required_error: REQUIRED_MSG("El nombre"),
      invalid_type_error: TYPE_MESSAGE("El nombre", "texto"),
    })
    .min(1, REQUIRED_MSG("El nombre"))
    .max(25, MAX_MESSAGE(25)),
  variedad: z.string().max(25, MAX_MESSAGE(25)).nullish(),
});

interface handleSubmitProps {
  values: z.infer<typeof schema>;
  method: Methods;
}

const formFields = [
  { name: "nombre", label: "Nombre", type: "text" },
  { name: "variedad", label: "Variedad", type: "text" },
];

interface Props {
  data: Cultivo[];
  fields: Record<string, unknown>[];
}

export default function Cultivo({ data, fields }: Props) {
  console.debug("fields:", fields);

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
        const { original } = row;
        console.debug("original:", original);

        return (
          <Actions
            display={`${original.nombre} (${original.variedad})`}
            url={route("cultivo.show", original.id)}
            simplified
          >
            <DynamicForm
              schema={schema}
              fields={formFields}
              submitConf={{
                url: route("cultivo.update", original.id),
                method: "put",
                values: original,
              }}
              defaults={{
                id: original.id,
                nombre: original.nombre,
                variedad: original.variedad,
              }}
            />
          </Actions>
        );
      },
    },
  ];

  return (
    <MainLayout>
      <Head title="Recurso: Cultivos" />
      <Dialog>
        <div className="my-6 flex w-full items-center justify-between">
          <h1 className="text-6xl font-bold">Cultivos</h1>
          <DialogTrigger
            className={buttonVariants({
              variant: "default",
              size: "lg",
              className: "text-xl",
            })}
          >
            Crear
          </DialogTrigger>
        </div>
        <DataTable config={{ data, columns }} />
        <CreateDialog title="Crear cultivo">
          <DynamicForm
            schema={schema}
            fields={formFields}
            submitConf={{
              url: route("cultivo.store"),
              method: "post",
            }}
            defaults={{
              id: "",
              nombre: "",
              variedad: "",
            }}
          />
        </CreateDialog>
      </Dialog>
    </MainLayout>
  );
}
