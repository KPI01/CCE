"user server";
import DataLayout from "@/Layouts/DataLayout";
import { columns } from "./Column";
import { Empresa } from "..";

interface Props {
  data: Empresa[];
  url: string;
}

export default function Table({ data, url }: Props) {
  return (
    <DataLayout title="Empresas" data={data} columns={columns} url={url} />
  );
}
