import { Head, Link } from "@inertiajs/react";

import MainLayout from "./MainLayout";
import DataTable from "@/Components/DataTable/Table";
import { buttonVariants } from "@/Components/ui/button";
import { TableProps } from ".";

export default function DataLayout<TData, TValue>({
  title,
  url,
  data,
  columns,
  state,
}: TableProps<TData, TValue>) {
  console.debug("data:", data);
  console.debug("state:", state);
  return (
    <MainLayout>
      <Head title={`Recurso: ${title}`} />
      <div className="my-10 flex justify-between">
        <h1 className="text-5xl font-bold">{title}</h1>
        <Link
          as="button"
          href={url}
          className={buttonVariants({
            variant: "default",
            size: "lg",
            className: "text-xl font-medium",
          })}
        >
          Crear
        </Link>
      </div>
      <DataTable config={{ data, columns }} state={state} />
    </MainLayout>
  );
}
