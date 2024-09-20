import DataLayout from "@/Layouts/DataLayout";
import { createColumn } from "../utils";
import { convertToType } from "@/Pages/Recursos/utils";
import MainLayout from "@/Layouts/MainLayout";
import { Head } from "@inertiajs/react";
import { DataTable } from "@/Components/DataTable/DataTable";

type Row = Record<string, unknown>;

interface Props {
  title: string;
  rows: Row[];
  url: string;
}

export default function Cultivo({ rows }: Props) {
  const columns =
    createColumn(rows[0], ["codigo", "created_at", "updated_at"]) ?? [];

  return (
    <MainLayout>
      <Head title="Auxiliares" />
      <div className="flex w-full">
        <h1 className="font-4xl font-semibold">Cultivos</h1>
      </div>
      <DataTable data={rows} columns={columns} />
    </MainLayout>
  );
}
