"user server";
import DataLayout from "@/Layouts/DataLayout";
import { columns } from "./Column";
import { Persona, TableState } from "..";
import { DataTableProps } from "@/Components/DataTable";

interface Props {
  data: Persona[];
  url: string;
  state: TableState;
}

export default function Table({ data, url }: Props) {
  return (
    <DataLayout title="Personas" data={data} columns={columns} url={url} />
  );
}
