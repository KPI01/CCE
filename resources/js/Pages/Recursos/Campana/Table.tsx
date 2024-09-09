import DataLayout from "@/Layouts/DataLayout";
import { Campana } from "@/types";
import { columns } from "./Column";

interface Props {
  data: Campana[];
  url: string;
}

export default function Table({ data, url }: Props) {
  const initVis = {
    nombre: true,
    is_activa: true,
    inicio: true,
    fin: true,
    descripcion: false,
  };

  return (
    <DataLayout
      title="Campañas"
      data={data}
      columns={columns}
      url={url}
      initialVisibility={initVis}
    />
  );
}
