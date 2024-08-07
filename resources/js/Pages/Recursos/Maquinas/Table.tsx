import DataLayout from "@/Layouts/DataLayout";
import { Maquina } from "@/types";
import { columns } from "./Column";

interface Props {
  data: Maquina[];
  url: string;
}

export default function Table({ data, url }: Props) {
  const initVisibility = {
    nombre: true,
    tipo: true,
    matricula: true,
    fabricante: true,
    nro_serie: false,
    cad_iteaf: false,
    roma: false,
  };

  return (
    <DataLayout
      title="Máquina"
      data={data}
      columns={columns}
      url={url}
      initialVisibility={initVisibility}
    />
  );
}
