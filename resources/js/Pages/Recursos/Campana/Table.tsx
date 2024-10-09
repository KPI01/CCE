import DataLayout from "@/Layouts/DataLayout";
import { columns } from "./Column";
import { Campana, TableState } from "..";

interface Props {
  data: Campana[];
  url: string;
}

export default function Table({ data, url }: Props) {
  const state: TableState = {
    visibility: {
      descripcion: false,
    },
  };

  return (
    <DataLayout
      title="Campañas"
      data={data}
      columns={columns}
      url={url}
      state={state}
    />
  );
}
