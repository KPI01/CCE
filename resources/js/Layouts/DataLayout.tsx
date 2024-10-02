import { Head, Link, router } from "@inertiajs/react";
import { TableProps } from "@/types";

import MainLayout from "./MainLayout";
import { DataTable } from "@/Components/DataTable/Table";
import { Button } from "@/Components/ui/button";
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from "@/Components/ui/alert-dialog";
import { SendIcon } from "@/Pages/Recursos/utils";
import { Input } from "@/Components/ui/input";
import React from "react";
import { Label } from "@/Components/ui/label";

interface CreateButtonProps {
  url: string;
  withPrompt?: boolean;
}

export default function DataLayout<TData, TValue>({
  title,
  url,
  data,
  columns,
  withPrompt,
}: TableProps<TData, TValue>) {
  console.debug(data);
  return (
    <MainLayout>
      <Head title={`Recurso: ${title}`} />
      <div className="my-10 flex justify-between">
        <h1 className="text-4xl font-semibold">{title}</h1>
        <CreateButton
          title={title}
          url={url}
          columns={columns}
          withPrompt={withPrompt}
        />
      </div>
      <DataTable data={data} columns={columns} />
    </MainLayout>
  );
}

function CreateButton<TData, TValue>({
  url,
  withPrompt,
  title,
  columns,
}: Pick<TableProps<TData, TValue>, "title" | "columns"> & CreateButtonProps) {
  const [values, setValues] = React.useState<Record<string, string>>({});

  console.debug("state:", values);

  function handleChange(e: React.ChangeEvent<HTMLInputElement>) {
    const key = e.target.name;
    const value = e.target.value;
    console.debug("old state:", values);
    console.debug("new to state:", "key:", key, "value:", value);
    setValues({ ...values, [key]: value });
  }

  function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    console.log("POST request:", url);
    console.log("payload:", values);
    router.post(url, values);
    setValues({});
  }

  if (withPrompt === true) {
    return (
      <AlertDialog>
        <AlertDialogTrigger asChild>
          <Button size={"lg"} className="text-lg" id="action-create">
            Crear
          </Button>
        </AlertDialogTrigger>
        <AlertDialogContent asChild>
          <form onSubmit={handleSubmit}>
            <AlertDialogHeader>
              <AlertDialogTitle>{title}</AlertDialogTitle>
              <AlertDialogDescription>
                Completa los campos necesarios para crear el registro.
              </AlertDialogDescription>
            </AlertDialogHeader>
            {columns.map((column) => {
              if (column.id && column.id !== "id" && column.id !== "url") {
                const key = column.id;
                const normal =
                  column.id.charAt(0).toUpperCase() + column.id.slice(1);

                return (
                  <div
                    key={column.id}
                    className="flex w-full items-center justify-between"
                  >
                    <Label htmlFor={`input-${key}`}>{normal}</Label>
                    <Input
                      name={key}
                      id={`input-${key}`}
                      className="max-w-80"
                      placeholder={`Aquí va el ${key}`}
                      value={values[key] || ""}
                      onChange={handleChange}
                    />
                  </div>
                );
              }
            })}
            <AlertDialogFooter>
              <AlertDialogCancel>Cancelar</AlertDialogCancel>
              <AlertDialogAction asChild>
                <Button type="submit">
                  <SendIcon />
                  Guardar
                </Button>
              </AlertDialogAction>
            </AlertDialogFooter>
          </form>
        </AlertDialogContent>
      </AlertDialog>
    );
  } else if (withPrompt === false && !url) {
    return null;
  }

  return (
    <Button asChild size={"lg"} className="text-lg">
      <Link href={`${url}/create`} as="button" id="action-create">
        Crear
      </Link>
    </Button>
  );
}
