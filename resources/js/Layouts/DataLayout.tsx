import { v4 as uuidv4 } from "uuid";

import { Head, Link, router } from "@inertiajs/react";
import { TableProps } from "@/types";

import MainLayout from "./MainLayout";
import { DataTable } from "@/Components/DataTable/DataTable";
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

export default function DataLayout({
  title,
  url,
  data,
  columns,
  initialVisibility,
  withPrompt,
}: TableProps) {
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
      <DataTable
        data={data}
        columns={columns}
        initialVisibility={initialVisibility}
      />
    </MainLayout>
  );
}

function CreateButton({
  url,
  withPrompt,
  title,
  columns,
}: Pick<TableProps, "title" | "columns"> & CreateButtonProps) {
  console.log("columns:", columns);
  const [values, setValues] = React.useState<Record<string, string>>({});

  function handleChange(e: React.ChangeEvent<HTMLInputElement>) {
    const key = e.target.name;
    const value = e.target.value;
    console.debug("old state:", values);
    console.debug("new to state:", "key:", key, "value:", value);
    console.debug("new state:", { ...values, [key]: value });
    setValues((values) => ({ ...values, [key]: value }));
  }

  function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    console.log("POST request:", url);
    console.log("payload:", values);
    router.post(url, values);
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
                  <div className="flex w-full items-center justify-between">
                    <Label htmlFor={`input-${key}`}>{normal}</Label>
                    <Input
                      key={uuidv4()}
                      name={key}
                      id={`input-${key}`}
                      className="max-w-80"
                      placeholder={`Aquí va el ${key}`}
                      value={values[key]}
                      onChange={handleChange}
                      autoFocus
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
