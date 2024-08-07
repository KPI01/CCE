import DataLayout from "@/Layouts/DataLayout";
import { TipoMaquina } from "@/types";
import { columnsTipo } from "./TipoColumns";

export default function Tipos({ data }: { data: TipoMaquina }) {
  console.debug(data);

  const iniVi = {
    id: true,
    tipo: true,
    url: true,
  };
  return (
    <DataLayout
      title="Tipos de Máquinas"
      columns={columnsTipo}
      recurso="tipos_maquina"
      data={data}
      initialVisibility={iniVi}
    />
  );
}
