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
import { CreateDialog, DynamicForm, Methods } from "@/lib/forms";
import { Dialog, DialogTrigger } from "@/Components/ui/dialog";
import { buttonVariants } from "@/Components/ui/button";
import { Head, router } from "@inertiajs/react";

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

const handleSubmit = (props: handleSubmitProps) => {
  console.debug("props:", props);

  if (props.method === "post") {
    const { id, ...values } = props.values;
    console.debug("Creando...", values);
    router.post(route("cultivo.store"), values);
    return;
  }
  if (props.method === "put") {
    console.debug("Actualizando...", props.values);
    router.put(route("cultivo.update", props.values.id), props.values);
    return;
  }

  console.debug("No se pudo realizar la acción");
  return;
};
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
      console.debug("original:", original);

      return (
        <Actions
          display={`${original.nombre} (${original.variedad})`}
          simplified
        >
          <DynamicForm
            schema={schema}
            fields={formFields}
            onSubmit={handleSubmit}
            method="put"
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

interface Props {
  data: Cultivo[];
  fields: Record<string, unknown>[];
}

export default function Cultivo({ data, fields }: Props) {
  console.debug("fields:", fields);

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
        <DataTable columns={columns} data={data} />
        <CreateDialog title="Crear cultivo">
          <DynamicForm
            schema={schema}
            fields={formFields}
            onSubmit={handleSubmit}
            method="post"
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
