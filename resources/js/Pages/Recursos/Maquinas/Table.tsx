import DataLayout from "@/Layouts/DataLayout";
import { Maquina } from "@/types";
import { columns } from "./Column";
import { RECURSO } from "./formSchema";

export default function Table({ data }: { data: Maquina[] }) {
  console.debug(data);
  const initVisibility = {
    nombre: true,
    tipo_id: true,
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
      recurso={RECURSO}
      initialVisibility={initVisibility}
    />
  );
}
